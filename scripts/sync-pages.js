/**
 * Market Theme — WordPress REST API Pages Synchronizer
 *
 * اسکریپت خودکار مدیریت و همگام‌سازی برگه‌های پوسته مارکت:
 * ۱. بررسی برگه‌های موجود در سایت از طریق REST API
 * ۲. ساخت برگه‌های الزامی پوسته همراه با قالب‌های اختصاصی (تماس با ما، درباره ما، سوالات متداول، شکایات، راهنما، وبلاگ، علاقه‌مندی‌ها)
 * ۳. حذف یا انتقال به سطل زباله برگه‌های بلااستفاده و پیش‌فرض (برگه نمونه، پیش‌نویس‌های بدون لینک)
 * ۴. حفظ کامل برگه‌های ضروری ووکامرس (صفحه اصلی، فروشگاه، سبد خرید، تسویه حساب، حساب کاربری)
 *
 * بدون نیاز به پکیج‌های خارجی (Zero-Dependency) — نیازمند Node 18+
 */

import fs from "node:fs";
import path from "node:path";
import { fileURLToPath } from "node:url";

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);

// ۱. خواندن فایل .env به صورت بومی
function loadEnv() {
  const envPaths = [
    path.join(__dirname, ".env"),
    path.join(process.cwd(), ".env"),
    path.join(process.cwd(), "scripts", ".env"),
    path.join(__dirname, "..", ".env"),
  ];

  for (const envPath of envPaths) {
    if (fs.existsSync(envPath)) {
      try {
        const content = fs.readFileSync(envPath, "utf-8");
        const lines = content.split(/\r?\n/);
        for (const line of lines) {
          const trimmed = line.trim();
          if (trimmed && !trimmed.startsWith("#") && trimmed.includes("=")) {
            const eqIndex = trimmed.indexOf("=");
            const key = trimmed.slice(0, eqIndex).trim().replace(/^\uFEFF/, "");
            const val = trimmed.slice(eqIndex + 1).trim().replace(/^["']|["']$/g, "");
            if (key) {
              process.env[key] = val;
            }
          }
        }
        if (
          process.env.WC_SITE_URL ||
          process.env.WC_CONSUMER_KEY ||
          process.env.WP_APP_USER
        ) {
          console.log(`📁 فایل تنظیمات با موفقیت خوانده شد: ${envPath}`);
          return true;
        }
      } catch (err) {
        // ادامه بررسی سایر مسیرها
      }
    }
  }
  return false;
}

loadEnv();

// ۲. دریافت آرگومان‌های خط فرمان
function getArg(flag) {
  const arg = process.argv.find((a) => a.startsWith(`--${flag}=`));
  if (arg) return arg.split("=")[1].trim();
  return null;
}

const hasFlag = (flag) => process.argv.includes(`--${flag}`);

const SITE_URL = (
  getArg("url") ||
  process.env.WC_SITE_URL ||
  process.env.WP_SITE_URL ||
  "https://mohamadfarid.ir"
).replace(/\/+$/, "");

const CONSUMER_KEY =
  getArg("ck") ||
  process.env.WC_CONSUMER_KEY ||
  "";

const CONSUMER_SECRET =
  getArg("cs") ||
  process.env.WC_CONSUMER_SECRET ||
  "";

const APP_USER =
  getArg("user") ||
  process.env.WP_APP_USER ||
  process.env.WP_USERNAME ||
  "";

const APP_PASSWORD =
  getArg("pass") ||
  getArg("app-pass") ||
  process.env.WP_APP_PASSWORD ||
  process.env.WP_APPLICATION_PASSWORD ||
  "";

const IS_DRY_RUN = hasFlag("dry-run");
const IS_FORCE_DELETE = !hasFlag("trash"); // پیش‌فرض: حذف کامل (با --trash به سطل زباله می‌رود)
const SKIP_DELETE = hasFlag("skip-delete");

// ۳. تعریف برگه‌های الزامی پوسته (بر اساس بررسی کدهای قالب)
const REQUIRED_PAGES = [
  {
    slug: "contact-us",
    title: "تماس با ما",
    template: "page-templates/page-contact.php",
    status: "publish",
    description: "لینک شده در منوی هدر دسکتاپ و ستون ۱ فوتر",
    content: "<!-- wp:paragraph --><p>به صفحه تماس با ما خوش آمدید. از طریق اطلاعات زیر و فرم تماس می‌توانید با کارشناسان ما در ارتباط باشید.</p><!-- /wp:paragraph -->",
  },
  {
    slug: "faq",
    title: "پرسش و پاسخ",
    template: "page-templates/page-faq.php",
    status: "publish",
    description: "لینک شده در منوی هدر دسکتاپ و ستون ۳ فوتر (پشتیبانی)",
    content: "<!-- wp:paragraph --><p>پاسخ متداول‌ترین پرسش‌های کاربران درباره سفارش، ارسال و پیگیری سفارش‌ها.</p><!-- /wp:paragraph -->",
  },
  {
    slug: "complaints",
    title: "پیشنهادات و انتقادات",
    template: "page-templates/page-complaints.php",
    status: "publish",
    description: "لینک شده در منوی هدر دسکتاپ و ستون ۳ فوتر (پشتیبانی)",
    content: "<!-- wp:paragraph --><p>نظرات، پیشنهادات و شکایات شما مستقیماً توسط مدیریت مجموعه دریافت و رسیدگی خواهد شد.</p><!-- /wp:paragraph -->",
  },
  {
    slug: "guide",
    title: "راهنمای سفارش",
    template: "page-templates/page-guide.php",
    status: "publish",
    description: "لینک شده در ستون ۳ فوتر (راهنمای خرید و ثبت سفارش)",
    content: "<!-- wp:paragraph --><p>راهنمای گام‌به‌گام ثبت سفارش آنلاین، پرداخت الکترونیک و تحویل سفارش درب منزل.</p><!-- /wp:paragraph -->",
  },
  {
    slug: "about-us",
    title: "درباره ما",
    template: "page-templates/page-about.php",
    status: "publish",
    description: "دارای قالب اختصاصی page-about.php در پوسته",
    content: "<!-- wp:paragraph --><p>فروشگاه ما با تمرکز بر عرضه جدیدترین تجهیزات دیجیتال، نورپردازی، صدا و لوازم جانبی با ضمانت اصالت فیزیکی و پشتیبانی فعال فعالیت می‌کند.</p><!-- /wp:paragraph -->",
  },
  {
    slug: "blog",
    title: "وبلاگ",
    template: "",
    status: "publish",
    description: "لینک شده در ستون ۱ فوتر (صفحه مقالات و وبلاگ)",
    content: "<!-- wp:paragraph --><p>جدیدترین مقالات تخصصی، اخبار دنیای فناوری و راهنماهای خرید کالا.</p><!-- /wp:paragraph -->",
  },
  {
    slug: "wishlist",
    title: "علاقه‌مندی‌ها",
    template: "",
    status: "publish",
    description: "لینک شده در دکمه علاقه‌مندی‌ها در هدر سایت (/wishlist/)",
    content: "<!-- wp:paragraph --><p>لیست کالاهای مورد علاقه شما جهت بررسی و سفارش در آینده.</p><!-- /wp:paragraph -->",
  },
];

// ۴. برگه‌های سیستمی ووکامرس که باید دست‌نخورده باقی بمانند
const CORE_PROTECTED_SLUGS = [
  "checkout",    // پرداخت — صفحه تسویه حساب
  "my-account",  // حساب کاربری من — صفحه حساب کاربری من
  "cart",        // سبد خرید — صفحه سبد خرید
  "shop",        // فروشگاه — صفحه فروشگاه
  "home",        // صفحه اصلی
];

// ۵. برگه‌های غیرضروری و بلااستفاده که باید پاک شوند (شناسایی با اسلاگ انگلیسی، فارسی و عنوان)
const UNUSED_SLUGS_TO_DELETE = [
  "sample-page",                 // برگه نمونه انگلیسی
  "برگه-نمونه",                  // برگه نمونه فارسی
  "privacy-policy",              // سیاست حفظ حریم خصوصی انگلیسی
  "سیاست-حفظ-حریم-خصوصی",        // سیاست حفظ حریم خصوصی فارسی
  "refund_returns",              // سیاست مرجوعی و عودت
  "refund-and-returns-policy",   // حالت دیگر مرجوعی
  "سیاست-مرجوعی-و-عودت",         // مرجوعی فارسی
];

// ۶. ساخت هدر احراز هویت
function getAuthHeader() {
  if (APP_USER && APP_PASSWORD) {
    const cleanPass = APP_PASSWORD.replace(/\s+/g, "");
    const token = Buffer.from(`${APP_USER}:${cleanPass}`).toString("base64");
    return {
      type: "Application Password",
      header: `Basic ${token}`,
    };
  }

  if (CONSUMER_KEY && CONSUMER_SECRET) {
    const token = Buffer.from(`${CONSUMER_KEY}:${CONSUMER_SECRET}`).toString("base64");
    return {
      type: "WooCommerce Keys",
      header: `Basic ${token}`,
    };
  }

  return null;
}

// ۷. ارسال درخواست به REST API وردپرس
async function wpRequest(endpoint, method = "GET", data = null) {
  const auth = getAuthHeader();
  let url = `${SITE_URL}/wp-json/wp/v2/${endpoint}`;

  const headers = {
    Accept: "application/json",
    "Content-Type": "application/json",
  };

  if (auth) {
    headers["Authorization"] = auth.header;
  }

  // در صورتی که با کلید ووکامرس باشد و SSL یا سرور نیاز به پارامتر Query داشته باشد
  if (auth && auth.type === "WooCommerce Keys" && !headers["Authorization"]) {
    const sep = url.includes("?") ? "&" : "?";
    url += `${sep}consumer_key=${encodeURIComponent(CONSUMER_KEY)}&consumer_secret=${encodeURIComponent(CONSUMER_SECRET)}`;
  }

  const options = {
    method,
    headers,
  };

  if (data && (method === "POST" || method === "PUT")) {
    options.body = JSON.stringify(data);
  }

  const response = await fetch(url, options);
  let responseData;
  try {
    responseData = await response.json();
  } catch (e) {
    responseData = { message: await response.text() };
  }

  if (!response.ok) {
    const err = new Error(`HTTP ${response.status}: ${responseData.message || JSON.stringify(responseData)}`);
    err.status = response.status;
    err.code = responseData.code;
    err.data = responseData;
    throw err;
  }

  return responseData;
}

// ۸. دریافت تمام برگه‌ها از وردپرس (شامل پیش‌نویس، سطل زباله و منتشر شده)
async function fetchAllRemotePages() {
  try {
    // در وردپرس وضعیت‌ها را می‌توان به صورت چندگانه با آرایه یا فراخوانی جداگانه دریافت کرد
    let pages = [];
    try {
      pages = await wpRequest("pages?per_page=100&status[]=publish&status[]=draft&status[]=pending&status[]=private&_fields=id,slug,title,status,template");
    } catch (e) {
      // در صورت محدودیت دسترسی به وضعیت‌های غیرمنتشر شده، برگه‌های عمومی دریافت می‌شوند
      pages = await wpRequest("pages?per_page=100&_fields=id,slug,title,status,template");
    }
    return Array.isArray(pages) ? pages : [];
  } catch (err) {
    if (err.status === 401 || err.status === 403) {
      console.error("\n❌ خطای عدم دسترسی (۴۰۱/۴۰۳):");
      console.error("  سرور اجازه مدیریت برگه‌های وردپرس (/wp/v2/pages) را با اطلاعات فعلی نداد.");
      console.log("\n💡 راهکار حل مشکل:");
      console.log("  برای دسترسی کامل به برگه‌های هسته وردپرس، از Application Password استفاده کنید:");
      console.log("  ۱. وارد پیشخوان وردپرس > کاربران > شناسنامه شما شوید.");
      console.log("  ۲. در بخش «گذرواژه‌های کاربردی»، نامی وارد کرده و رمز اختصاصی دریافت کنید.");
      console.log("  ۳. آن را در فایل scripts/.env وارد کرده یا در خط فرمان بنویسید:");
      console.log("     WP_APP_USER=نام_کاربری");
      console.log("     WP_APP_PASSWORD=xxxx xxxx xxxx xxxx");
      console.log("\n  یا دستور را این‌گونه اجرا نمایید:");
      console.log("     node sync-pages.js --user=admin --pass=\"xxxx xxxx xxxx xxxx\"\n");
    }
    throw err;
  }
}

// ۹. تابع اصلی همگام‌سازی برگه‌ها
async function main() {
  console.log("=".repeat(70));
  console.log("📄 آغاز تحلیل و همگام‌سازی برگه‌های پوسته مارکت در وردپرس");
  console.log(`🌐 آدرس سایت: ${SITE_URL}`);
  const auth = getAuthHeader();
  if (auth) {
    console.log(`🔐 روش احراز هویت: ${auth.type}`);
  } else {
    console.warn("⚠️ هشدار: هیچ اطلاعات احراز هویتی یافت نشد.");
  }
  if (IS_DRY_RUN) {
    console.log("🧪 حالت شبیه‌سازی فعال است (--dry-run). هیچ تغییری روی سایت اعمال نمی‌شود.");
  }
  console.log("=".repeat(70));

  // مرحله ۱: دریافت برگه‌های موجود روی سایت
  console.log("\n📥 ۱. در حال دریافت لیست کامل برگه‌ها از وردپرس...");
  const remotePages = await fetchAllRemotePages();
  console.log(`  📊 تعداد ${remotePages.length} برگه روی سایت یافت شد:\n`);

  for (const page of remotePages) {
    const title = page.title?.rendered || "(بدون عنوان)";
    console.log(`     • [ID: ${page.id}] ${title} | Slug: "${page.slug}" | وضعیت: ${page.status} | قالب: ${page.template || "پیش‌فرض"}`);
  }

  // نقشه اسلاگ و شناسه به برگه (با پشتیبانی از کاراکترهای یونیکد فارسی)
  const remotePageMap = new Map();
  for (const p of remotePages) {
    remotePageMap.set(p.slug, p);
    try {
      const decoded = decodeURIComponent(p.slug);
      if (decoded !== p.slug) {
        remotePageMap.set(decoded, p);
      }
    } catch (e) {}
  }

  // مرحله ۲: حذف برگه‌های بدون استفاده
  console.log("\n🗑️  ۲. بررسی و حذف برگه‌های بدون استفاده...");
  let hasAuthPermissionError = false;
  if (SKIP_DELETE) {
    console.log("  ⏭️ پرش از حذف برگه‌ها به دلیل پرچم --skip-delete");
  } else {
    let deletedCount = 0;
    const handledIds = new Set();

    for (const deleteSlug of UNUSED_SLUGS_TO_DELETE) {
      const targetPage = remotePageMap.get(deleteSlug);
      if (targetPage && !handledIds.has(targetPage.id)) {
        handledIds.add(targetPage.id);
        const title = targetPage.title?.rendered || deleteSlug;
        console.log(`  ⚠️ برگه غیرضروری یافت شد: "${title}" (Slug: ${deleteSlug}, ID: ${targetPage.id})`);
        if (IS_DRY_RUN) {
          console.log(`     [DRY-RUN] این برگه ${IS_FORCE_DELETE ? "به صورت دائمی حذف" : "به سطل زباله منتقل"} می‌شد.`);
        } else {
          try {
            await wpRequest(`pages/${targetPage.id}?force=${IS_FORCE_DELETE}`, "DELETE");
            console.log(`     ✅ برگه با موفقیت ${IS_FORCE_DELETE ? "حذف دائم" : "به سطل زباله منتقل"} شد.`);
            deletedCount++;
          } catch (err) {
            console.error(`     ❌ خطا در حذف برگه: ${err.message}`);
            if (err.status === 401 || err.status === 403) {
              hasAuthPermissionError = true;
            }
          }
        }
      }
    }
    if (deletedCount === 0 && !IS_DRY_RUN) {
      console.log("  ✨ هیچ برگه بلااستفاده‌ای برای حذف یافت نشد (یا قبلاً پاک شده است).");
    }
  }

  // مرحله ۳: ساخت برگه‌های الزامی پوسته
  console.log("\n✨ ۳. بررسی و ساخت برگه‌های الزامی پوسته مارکت...");
  let createdCount = 0;
  let updatedCount = 0;

  for (const required of REQUIRED_PAGES) {
    const existing = remotePageMap.get(required.slug);

    if (existing) {
      console.log(`  ℹ️ برگه "${required.title}" (Slug: ${required.slug}) از قبل وجود دارد [ID: ${existing.id}]`);

      // بررسی آیا قالب نیاز به به‌روزرسانی دارد؟
      if (required.template && existing.template !== required.template) {
        console.log(`     🔄 قالب برگه نیازمند به‌روزرسانی است: "${existing.template || "پیش‌فرض"}" ➔ "${required.template}"`);
        if (IS_DRY_RUN) {
          console.log(`     [DRY-RUN] قالب برگه به‌روزرسانی می‌شد.`);
        } else {
          try {
            await wpRequest(`pages/${existing.id}`, "POST", {
              template: required.template,
            });
            console.log(`     ✅ قالب برگه با موفقیت روی "${required.template}" تنظیم شد.`);
            updatedCount++;
          } catch (err) {
            console.error(`     ❌ خطا در به‌روزرسانی قالب برگه: ${err.message}`);
          }
        }
      }
    } else {
      console.log(`  ➕ در حال ساخت برگه: "${required.title}" (Slug: ${required.slug})`);
      console.log(`     📝 کاربرد: ${required.description}`);
      if (required.template) {
        console.log(`     🎨 قالب اختصاصی: ${required.template}`);
      }

      if (IS_DRY_RUN) {
        console.log(`     [DRY-RUN] این برگه با موفقیت ایجاد می‌شد.`);
      } else {
        try {
          const payload = {
            title: required.title,
            slug: required.slug,
            status: required.status,
            content: required.content,
          };
          if (required.template) {
            payload.template = required.template;
          }

          const created = await wpRequest("pages", "POST", payload);
          console.log(`     ✅ برگه با موفقیت ایجاد شد! (شناسه: ${created.id}, پیوند: ${created.link})`);
          createdCount++;
        } catch (err) {
          console.error(`     ❌ خطا در ایجاد برگه "${required.title}": ${err.message}`);
          if (err.status === 401 || err.status === 403) {
            hasAuthPermissionError = true;
          }
        }
      }
    }
  }

  if (hasAuthPermissionError && auth?.type === "WooCommerce Keys") {
    console.log("\n" + "!".repeat(70));
    console.log("⚠️ توجه: کلیدهای کنونی ووکامرس (ck/cs) دسترسی ساخت/حذف برگه‌های هسته وردپرس را ندارند.");
    console.log("برای حل این مورد و اجرای موفق ساخت/حذف برگه‌ها، لطفاً Application Password بسازید:");
    console.log("۱. به پیشخوان وردپرس > کاربران > شناسنامه شما بروید.");
    console.log("۲. در بخش «گذرواژه‌های کاربردی»، نامی وارد کرده و دکمه «افزودن گذرواژه کاربردی تازه» را بزنید.");
    console.log("۳. مقادیر را به فایل scripts/.env اضافه فرمایید:");
    console.log("   WP_APP_USER=نام_کاربری_شما");
    console.log("   WP_APP_PASSWORD=xxxx xxxx xxxx xxxx");
    console.log("\nسپس مجدداً دستور زیر را اجرا کنید:");
    console.log("   node scripts/sync-pages.js");
    console.log("!".repeat(70));
  }

  // مرحله ۴: جمع‌بندی
  console.log("\n" + "=".repeat(70));
  console.log("🏁 جمع‌بندی عملیات:");
  console.log(`   • برگه‌های جدید ایجاد شده: ${createdCount}`);
  console.log(`   • برگه‌های به‌روزرسانی شده: ${updatedCount}`);
  console.log(`   • برگه‌های محافظت‌شده ووکامرس: ${CORE_PROTECTED_SLUGS.length} (${CORE_PROTECTED_SLUGS.join(", ")})`);
  console.log("=".repeat(70) + "\n");
}

main().catch((err) => {
  console.error("\n❌ اجرای اسکریپت با خطا متوقف شد:", err.message);
  process.exit(1);
});
