/**
 * Market Theme — WooCommerce REST API Categories Generator
 *
 * اسکریپت خودکار ساخت و پیوند سلسله‌مراتبی دسته‌بندی‌ها و زیردسته‌ها در ووکامرس
 * با پشتیبانی کامل از Node 18+ بدون نیاز به پکیج‌های خارجی (Zero-Dependency)
 */

import fs from "node:fs";
import path from "node:path";
import { fileURLToPath } from "node:url";

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);

// ۱. خواندن فایل .env به صورت بومی و چندمسیره
function loadEnv() {
  const envPaths = [
    path.join(__dirname, ".env"),
    path.join(process.cwd(), ".env"),
    path.join(process.cwd(), "scripts", ".env"),
    path.join(__dirname, "..", ".env"),
    path.join(__dirname, ".env.example"),
  ];

  for (const envPath of envPaths) {
    if (fs.existsSync(envPath)) {
      try {
        const content = fs.readFileSync(envPath, "utf-8");
        const lines = content.split(/\r?\n/);
        let foundAny = false;
        for (const line of lines) {
          const trimmed = line.trim();
          if (trimmed && !trimmed.startsWith("#") && trimmed.includes("=")) {
            const eqIndex = trimmed.indexOf("=");
            const key = trimmed.slice(0, eqIndex).trim().replace(/^\uFEFF/, "");
            const val = trimmed.slice(eqIndex + 1).trim().replace(/^["']|["']$/g, "");
            if (key) {
              process.env[key] = val;
              foundAny = true;
            }
          }
        }
        if (foundAny && (process.env.WC_SITE_URL || process.env.WC_CONSUMER_KEY)) {
          console.log(`📁 مقادیر اتصال از فایل تنظیمات خوانده شد: ${envPath}`);
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

// ۲. پردازش آرگومان‌های خط فرمان یا مقادیر پیش‌فرض
function getArg(flag) {
  const arg = process.argv.find((a) => a.startsWith(`--${flag}=`));
  return arg ? arg.split("=")[1].trim() : null;
}

const SITE_URL = (
  getArg("url") ||
  process.env.WC_SITE_URL ||
  "https://mohamadfarid.ir"
).replace(/\/+$/, "");

const CONSUMER_KEY =
  getArg("ck") ||
  process.env.WC_CONSUMER_KEY ||
  "ck_96329a66f392b5ad127204eb716dc8aef5d24169";

const CONSUMER_SECRET =
  getArg("cs") ||
  process.env.WC_CONSUMER_SECRET ||
  "cs_0aab712a6848fd7c8f5e92d43b35bc27a14e392c";

console.log(`🌐 آدرس سایت: ${SITE_URL}`);
console.log(`🔑 کلید مصرف‌کننده: ${CONSUMER_KEY.slice(0, 8)}...`);
console.log(`🔒 کلید مخفی: ${CONSUMER_SECRET.slice(0, 8)}...`);
// ۳. بررسی اطلاعات اتصال
if (!SITE_URL || !CONSUMER_KEY || !CONSUMER_SECRET) {
  console.error("\n❌ خطا: اطلاعات اتصال به REST API ووکامرس ناقص است.");
  console.log(
    "\nراهنما: لطفاً فایل .env را در پوشه scripts تکمیل کنید یا پارامترها را در خط فرمان وارد نمایید:",
  );
  console.log(
    "  node create-categories.js --url=https://mysite.com --ck=ck_xxx --cs=cs_xxx\n",
  );
  process.exit(1);
}

// ۴. ساختار کامل دسته‌بندی‌ها و زیردسته‌ها بر اساس درخواست
const CATEGORIES_TREE = [
  {
    name: "اسپیکر",
    slug: "speaker",
    children: [
      { name: "ساب ۱۵", slug: "sub-15" },
      { name: "ساب ۱۲", slug: "sub-12" },
      { name: "ساب ۱۰", slug: "sub-10" },
      { name: "ساب ۸", slug: "sub-8" },
      { name: "ساب ۶", slug: "sub-6" },
      { name: "ساب ۴", slug: "sub-4" },
      { name: "مینی ۳", slug: "mini-3" },
    ],
  },
  {
    name: "هدفون و هندزفری",
    slug: "headphones",
    children: [
      { name: "Anker", slug: "anker" },
      { name: "airpods", slug: "airpods" },
      { name: "سری m", slug: "m-series" },
      { name: "گیمینگ", slug: "gaming" },
      { name: "اقتصادی", slug: "budget" },
    ],
  },
  {
    name: "ساعت هوشمند-واچ",
    slug: "smart-watch",
    children: [
      { name: "KEQIWEAR", slug: "keqiwear" },
      { name: "teket", slug: "teket" },
      { name: "DSPort", slug: "dsport" },
    ],
  },
  {
    name: "ماشین اصلاح",
    slug: "shaver",
    children: [{ name: "GODFERY", slug: "godfery" }],
  },
  {
    name: "نورپردازی",
    slug: "lighting",
    children: [], // دسته تک‌سطحی بدون زیردسته
  },
  {
    name: "عروسک",
    slug: "dolls",
    children: [], // دسته تک‌سطحی بدون زیردسته
  },
];

// ۵. تابع ارسال درخواست به REST API ووکامرس با پشتیبانی همزمان Basic Auth و Query Params
async function apiRequest(endpoint, method = "GET", data = null) {
  const isHttps = SITE_URL.startsWith("https://");
  const basicAuth = Buffer.from(`${CONSUMER_KEY}:${CONSUMER_SECRET}`).toString(
    "base64",
  );

  let url = `${SITE_URL}/wp-json/wc/v3/${endpoint}`;
  const headers = {
    Accept: "application/json",
    "Content-Type": "application/json",
  };

  if (isHttps) {
    headers["Authorization"] = `Basic ${basicAuth}`;
  } else {
    const separator = url.includes("?") ? "&" : "?";
    url += `${separator}consumer_key=${encodeURIComponent(CONSUMER_KEY)}&consumer_secret=${encodeURIComponent(CONSUMER_SECRET)}`;
  }

  const options = {
    method,
    headers,
  };

  if (data && (method === "POST" || method === "PUT")) {
    options.body = JSON.stringify(data);
  }

  const response = await fetch(url, options);
  const responseData = await response.json();

  if (!response.ok) {
    // در صورتی که دسته قبلاً ساخته شده باشد WooCommerce کد term_exists بازمی‌گرداند
    if (responseData.code === "term_exists") {
      return {
        id: responseData.data?.resource_id,
        isExisting: true,
      };
    }
    const errMsg = responseData.message || JSON.stringify(responseData);
    throw new Error(`HTTP ${response.status}: ${errMsg}`);
  }

  return responseData;
}

// ۶. بررسی وجود داشتن دسته بر اساس Slug
async function findCategoryBySlug(slug) {
  try {
    const results = await apiRequest(
      `products/categories?slug=${encodeURIComponent(slug)}&per_page=1`,
    );
    if (Array.isArray(results) && results.length > 0) {
      return results[0];
    }
    return null;
  } catch (err) {
    return null;
  }
}

// ۷. تابع اصلی ایجاد کل دسته‌بندی‌ها و زیردسته‌ها
async function main() {
  console.log("=".repeat(65));
  console.log("🚀 آغاز فرآیند ساخت دسته‌بندی‌ها و زیردسته‌ها در ووکامرس");
  console.log(`🌐 آدرس سایت: ${SITE_URL}`);
  console.log("=".repeat(65));

  let totalParents = 0;
  let totalChildren = 0;

  for (const parent of CATEGORIES_TREE) {
    let parentId = null;

    console.log(
      `\n📁 در حال بررسی/ساخت دسته اصلی: "${parent.name}" (Slug: ${parent.slug})`,
    );

    // بررسی وجود داشتن دسته والد
    const existingParent = await findCategoryBySlug(parent.slug);

    if (existingParent) {
      parentId = existingParent.id;
      console.log(`  ℹ️ دسته اصلی از قبل وجود دارد (ID: ${parentId})`);
    } else {
      try {
        const createdParent = await apiRequest("products/categories", "POST", {
          name: parent.name,
          slug: parent.slug,
          parent: 0,
        });
        parentId = createdParent.id;
        console.log(`  ✅ دسته اصلی با موفقیت ساخته شد (ID: ${parentId})`);
        totalParents++;
      } catch (err) {
        console.error(`  ❌ خطا در ساخت دسته "${parent.name}":`, err.message);
        continue;
      }
    }

    // ساخت زیردسته‌ها
    if (parent.children.length > 0) {
      for (const child of parent.children) {
        const existingChild = await findCategoryBySlug(child.slug);

        if (existingChild) {
          console.log(
            `    └─ ℹ️ زیردسته "${child.name}" از قبل وجود دارد (ID: ${existingChild.id})`,
          );
        } else {
          try {
            const createdChild = await apiRequest(
              "products/categories",
              "POST",
              {
                name: child.name,
                slug: child.slug,
                parent: parentId, // پیوند با دسته والد
              },
            );
            console.log(
              `    └─ ✅ زیردسته "${child.name}" ساخته و متصل شد (ID: ${createdChild.id})`,
            );
            totalChildren++;
          } catch (err) {
            console.error(
              `    └─ ❌ خطا در ساخت زیردسته "${child.name}":`,
              err.message,
            );
          }
        }
      }
    } else {
      console.log(`  ▫️ این دسته تک‌سطحی است و زیردسته ندارد.`);
    }
  }

  console.log("\n" + "=".repeat(65));
  console.log("✨ عملیات با موفقیت به پایان رسید!");
  console.log(
    `📊 آمار: ${totalParents} دسته اصلی جدید، ${totalChildren} زیردسته جدید ثبت شد.`,
  );
  console.log(
    "💡 تمام دسته‌ها در پیشخوان وردپرس > محصولات > دسته‌ها قابل مشاهده و در بخش منوها قابل افزودن هستند.",
  );
  console.log("=".repeat(65) + "\n");
}

main().catch((err) => {
  console.error("\n❌ خطای پیش‌بینی‌نشده در اجرای اسکریپت:", err);
  process.exit(1);
});
