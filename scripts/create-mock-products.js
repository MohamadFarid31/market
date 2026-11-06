/**
 * Market Theme — WooCommerce REST API Mock Products Generator
 *
 * اسکریپت خودکار ساخت محصولات تستی و ماک برای تمامی دسته‌بندی‌های ووکامرس:
 * ۱. دریافت خودکار تمامی دسته‌ها و زیردسته‌های تعریف شده در سایت
 * ۲. ساخت چند محصول ماک به ازای هر دسته با نام‌گذاری هوشمند بر اساس دسته‌بندی و شماره
 *    (مثال: «اسپیکر ساب ۱۰ شماره ۱»، «اسپیکر ساب ۱۰ شماره ۲»)
 * ۳. قیمت‌گذاری تصادفی و واقع‌گرایانه (قیمت عادی و تخفیف‌های تصادفی)
 * ۴. مدیریت وضعیت موجودی تصادفی (موجود در انبار و ناموجود)
 * ۵. انتساب تصویر بندانگشتی تستی (Placeholder) با پالت‌های رنگی متنوع و مدیریت هوشمند خطای هاست
 * ۶. پیوند خودکار محصول به زیردسته و دسته والد مربوطه
 *
 * بدون نیاز به پکیج‌های خارجی (Zero-Dependency) — نیازمند Node 18+
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

// ۲. پردازش آرگومان‌های خط فرمان
function getArg(flag, defaultValue = null) {
  const arg = process.argv.find((a) => a.startsWith(`--${flag}=`));
  if (arg) return arg.split("=")[1].trim();
  return defaultValue;
}

const hasFlag = (flag) => process.argv.includes(`--${flag}`);

const SITE_URL = (
  getArg("url") ||
  process.env.WC_SITE_URL ||
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

const PRODUCTS_PER_CATEGORY = parseInt(getArg("count", "3"), 10) || 3;
const IS_DRY_RUN = hasFlag("dry-run");
const NO_IMAGES = hasFlag("no-images");
const INCLUDE_PARENTS = hasFlag("include-parents");
const CLEAN_MOCK_ONLY = hasFlag("clean");
const IMAGE_PROVIDER = getArg("provider", "dummyimage"); // dummyimage | picsum | placehold

// پالت‌های رنگی جذاب برای تصاویر بندانگشتی تستی
const PALETTES = [
  { bg: "2563eb", fg: "ffffff" }, // آبی رویال
  { bg: "059669", fg: "ffffff" }, // زمردی
  { bg: "7c3aed", fg: "ffffff" }, // بنفش
  { bg: "d97706", fg: "ffffff" }, // کهربایی / طلایی
  { bg: "dc2626", fg: "ffffff" }, // قرمز
  { bg: "0891b2", fg: "ffffff" }, // فیروزه‌ای
  { bg: "4f46e5", fg: "ffffff" }, // ایندیگو
  { bg: "0f172a", fg: "f8fafc" }, // زغالی / مشکی شیک
];

// ۳. بررسی اطلاعات احراز هویت
if (!SITE_URL || !CONSUMER_KEY || !CONSUMER_SECRET) {
  console.error("\n❌ خطا: اطلاعات اتصال به REST API ووکامرس ناقص است.");
  console.log(
    "\nراهنما: لطفاً فایل .env را در پوشه scripts تکمیل کنید یا پارامترها را در خط فرمان وارد نمایید:",
  );
  console.log(
    "  node create-mock-products.js --url=https://mysite.com --ck=ck_xxx --cs=cs_xxx\n",
  );
  process.exit(1);
}

// ۴. تابع ارسال درخواست به REST API ووکامرس
async function apiRequest(endpoint, method = "GET", data = null) {
  const isHttps = SITE_URL.startsWith("https://");
  const basicAuth = Buffer.from(`${CONSUMER_KEY}:${CONSUMER_SECRET}`).toString("base64");

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
  let responseData;
  try {
    responseData = await response.json();
  } catch (err) {
    const rawText = await response.text().catch(() => "");
    throw new Error(`خطای نامعتبر سرور (HTTP ${response.status}): ${rawText.slice(0, 150)}`);
  }

  if (!response.ok) {
    const errMsg = responseData.message || JSON.stringify(responseData);
    const err = new Error(`HTTP ${response.status}: ${errMsg}`);
    err.code = responseData.code;
    err.data = responseData;
    throw err;
  }

  return responseData;
}

// وقفه کوچک بین درخواست‌ها برای محافظت از سرور
const sleep = (ms) => new Promise((resolve) => setTimeout(resolve, ms));

// ۵. دریافت تمام دسته‌بندی‌های موجود در سایت (با پشتیبانی از صفحه‌بندی)
async function fetchAllCategories() {
  console.log("🔍 در حال دریافت فهرست دسته‌بندی‌ها از فروشگاه...");
  const categories = [];
  let page = 1;
  const perPage = 100;

  while (true) {
    try {
      const pageResults = await apiRequest(
        `products/categories?per_page=${perPage}&page=${page}&orderby=id&order=asc`,
      );
      if (!Array.isArray(pageResults) || pageResults.length === 0) {
        break;
      }
      categories.push(...pageResults);
      if (pageResults.length < perPage) {
        break;
      }
      page++;
    } catch (err) {
      if (err.message.includes("rest_category_invalid_page_number") || err.message.includes("400")) {
        break;
      }
      throw err;
    }
  }

  return categories;
}

// ۶. تولید قیمت و تخفیف تصادفی واقع‌گرایانه (به تومان / ریال)
function generateRandomPricing() {
  // تولید قیمت پایه بین ۱۵۰,۰۰۰ تا ۶,۵۰۰,۰۰۰ تومان به صورت مضرب‌های رند ۱۰,۰۰۰ یا ۵۰,۰۰۰ تومانی
  const baseThousands = Math.floor(Math.random() * 450) * 10 + 150; // بین 150 تا 4650 هزار تومان
  const regularPrice = baseThousands * 1000;

  // حدود ۴۰ درصد احتمال داشتن قیمت تخفیف‌دار
  const hasSale = Math.random() < 0.4;
  let salePrice = "";

  if (hasSale) {
    // تخفیف بین ۱۰ تا ۳۰ درصد
    const discountPercent = Math.floor(Math.random() * 21) + 10;
    const discounted = Math.round((regularPrice * (1 - discountPercent / 100)) / 10000) * 10000;
    if (discounted < regularPrice) {
      salePrice = discounted.toString();
    }
  }

  return {
    regular_price: regularPrice.toString(),
    sale_price: salePrice,
  };
}

// ۷. تولید موجودی و وضعیت انبار تصادفی
function generateRandomStock() {
  // ۸۵٪ شانس موجود در انبار، ۱۵٪ شانس ناموجود
  const isInStock = Math.random() < 0.85;

  if (isInStock) {
    const quantity = Math.floor(Math.random() * 25) + 3; // بین ۳ تا ۲۸ عدد
    return {
      manage_stock: true,
      stock_status: "instock",
      stock_quantity: quantity,
    };
  }

  return {
    manage_stock: true,
    stock_status: "outofstock",
    stock_quantity: 0,
  };
}

// ۸. ساخت آدرس تصویر تستی
function getPlaceholderImageUrl(productName, index, categoryId) {
  const palette = PALETTES[Math.abs(categoryId + index) % PALETTES.length];

  if (IMAGE_PROVIDER === "picsum") {
    // سرویس تصاویر واقعی با Seed اختصاصی برای هر محصول
    return `https://picsum.photos/seed/market-${categoryId}-${index}/800/800`;
  }

  if (IMAGE_PROVIDER === "placehold") {
    const safeText = encodeURIComponent(`Product ${index + 1}`);
    return `https://placehold.co/800x800/${palette.bg}/${palette.fg}.png?text=${safeText}`;
  }

  // پیش‌فرض: dummyimage با رندر تمیز و پرسرعت
  const safeText = encodeURIComponent(`Product ${index + 1}`);
  return `https://dummyimage.com/800x800/${palette.bg}/${palette.fg}.png&text=${safeText}`;
}

// ۹. تولید توضیحات ساختگی استاندارد برای محصول
function generateProductDescriptions(fullName) {
  const shortDesc = `<p><strong>${fullName}</strong> — گزینه‌ای ایده‌آل و باکیفیت با طراحی مدرن، عملکرد فوق‌العاده و گارانتی معتبر اصالت کالا ویژه مشتریان گرامی.</p>`;

  const fullDesc = `
<h3>ویژگی‌ها و مزایای برجسته ${fullName}</h3>
<p>این محصول تستی ماک با بالاترین استانداردهای کیفی طراحی و تولید شده است. طراحی ارگونومیک، استحکام متریال و بهره‌گیری از آخرین فناوری‌های روز، این کالا را به یک انتخاب هوشمندانه برای استفاده روزمره و حرفه‌ای تبدیل کرده است.</p>
<ul>
  <li>کیفیت ساخت بالا با استاندارد جهانی</li>
  <li>عملکرد پایدار و بهینه‌سازی شده در تمامی شرایط</li>
  <li>طراحی ارگونومیک، مینیمال و کاربرپسند</li>
  <li>دارای مهلت تست ۷ روزه و ضمانت اصالت فیزیکی کالا</li>
  <li>پشتیبانی همه‌روزه و خدمات پس از فروش اختصاصی مارکت</li>
</ul>
<p>جهت دریافت اطلاعات بیشتر و استعلام شرایط عمده‌فروشی با واحد پشتیبانی مشتریان تماس حاصل فرمایید.</p>
  `.trim();

  return { shortDesc, fullDesc };
}

// ۱۰. پاکسازی محصولات ماک ساخته شده قبلی (اختیاری با پرچم --clean)
async function cleanMockProducts() {
  console.log("🧹 در حال جستجو و پاکسازی محصولات ماک ساخته شده قبلی...");
  let page = 1;
  let deletedCount = 0;

  while (true) {
    const products = await apiRequest(`products?per_page=50&page=${page}&search=شماره`);
    if (!Array.isArray(products) || products.length === 0) {
      break;
    }

    for (const prod of products) {
      if (prod.name.includes("شماره")) {
        try {
          await apiRequest(`products/${prod.id}?force=true`, "DELETE");
          console.log(`  🗑️ محصول ماک حذف شد: "${prod.name}" (ID: ${prod.id})`);
          deletedCount++;
        } catch (err) {
          console.error(`  ❌ خطا در حذف محصول ${prod.id}:`, err.message);
        }
      }
    }

    if (products.length < 50) break;
  }

  console.log(`✨ مجموعاً ${deletedCount} محصول ماک با موفقیت حذف گردید.\n`);
}

// ۱۱. تابع اصلی ایجاد محصولات ماک برای هر دسته
async function main() {
  console.log("=".repeat(70));
  console.log("🛍️  اسکریپت خودکار ساخت محصولات ماک ووکامرس (Market Theme)");
  console.log(`🌐 آدرس سایت: ${SITE_URL}`);
  console.log(`📦 تعداد محصول به ازای هر دسته: ${PRODUCTS_PER_CATEGORY}`);
  if (IS_DRY_RUN) console.log("⚠️ حالت شبیه‌سازی (Dry Run) فعال است: تغییری در دیتابیس ثبت نمی‌شود.");
  if (NO_IMAGES) console.log("⚡ حالت بدون تصویر (No Images) فعال است.");
  console.log("=".repeat(70) + "\n");

  // اگر پرچم --clean ارسال شده باشد، ابتدا محصولات ماک قبلی پاک می‌شوند
  if (CLEAN_MOCK_ONLY) {
    await cleanMockProducts();
    return;
  }

  // ۱. دریافت تمامی دسته‌بندی‌ها
  const allCategories = await fetchAllCategories();

  if (!allCategories || allCategories.length === 0) {
    console.error("❌ هیچ دسته‌بندی در سایت یافت نشد.");
    console.log("💡 ابتدا دسته‌ها را بسازید: node create-categories.js\n");
    return;
  }

  console.log(`✅ تعداد ${allCategories.length} دسته‌بندی در سایت یافت شد.\n`);

  // ایجاد مپ برای دسترسی سریع به اطلاعات والدین
  const categoryMap = new Map();
  const parentIdsWithChildren = new Set();

  for (const cat of allCategories) {
    categoryMap.set(cat.id, cat);
    if (cat.parent && cat.parent > 0) {
      parentIdsWithChildren.add(cat.parent);
    }
  }

  // تفکیک دسته‌هایی که باید برایشان محصول ساخته شود:
  // طبق درخواست: ساخت محصول برای دسته‌ها با اولویت دسته‌های برگ (زیردسته‌ها) و دسته‌های تک‌سطحی
  // اگر --include-parents تعیین شده باشد، برای والدینی که زیردسته دارند هم محصول مجزا ساخته می‌شود.
  const targetCategories = allCategories.filter((cat) => {
    // از دسته پیش‌فرض "دسته‌بندی نشده" صرف نظر می‌کنیم
    if (cat.slug === "uncategorized" || cat.name === "دسته‌بندی نشده") {
      return false;
    }
    const hasChildren = parentIdsWithChildren.has(cat.id);
    if (hasChildren && !INCLUDE_PARENTS) {
      return false; // این دسته والد است و زیردسته دارد؛ محصولات را در زیردسته‌های آن ایجاد می‌کنیم
    }
    return true;
  });

  console.log(
    `🎯 تعداد ${targetCategories.length} دسته برای ایجاد محصولات ماک انتخاب شدند.\n`,
  );

  let totalProductsCreated = 0;
  let totalInStock = 0;
  let totalOutOfStock = 0;
  let totalDiscounted = 0;

  let currentCategoryIndex = 0;

  for (const cat of targetCategories) {
    currentCategoryIndex++;

    // محاسبه نام ترکیبی دسته برای نام‌گذاری هوشمند
    // مثلاً اگر والد «اسپیکر» و فرزند «ساب ۱۰» باشد -> «اسپیکر ساب ۱۰»
    let fullCategoryTitle = cat.name.trim();
    const categoryIdsForProduct = [{ id: cat.id }];

    if (cat.parent && cat.parent > 0 && categoryMap.has(cat.parent)) {
      const parentCat = categoryMap.get(cat.parent);
      // افزودن ID والد تا محصول هم در صفحه دسته فرزند و هم در صفحه دسته والد نمایش داده شود
      categoryIdsForProduct.push({ id: parentCat.id });

      // اگر نام فرزند شامل نام والد نیست، نام والد را قبل از آن اضافه می‌کنیم
      if (!fullCategoryTitle.includes(parentCat.name)) {
        fullCategoryTitle = `${parentCat.name} ${fullCategoryTitle}`;
      }
    }

    console.log(
      `\n📂 [${currentCategoryIndex}/${targetCategories.length}] پردازش دسته: "${fullCategoryTitle}" (ID: ${cat.id})`,
    );

    for (let i = 1; i <= PRODUCTS_PER_CATEGORY; i++) {
      // فرمت دقیق نام بر اساس درخواست کاربر: «اسپیکر ساب ۱۰ شماره ۱»
      const productName = `${fullCategoryTitle} شماره ${i}`;
      const pricing = generateRandomPricing();
      const stock = generateRandomStock();
      const { shortDesc, fullDesc } = generateProductDescriptions(productName);

      if (stock.stock_status === "instock") {
        totalInStock++;
      } else {
        totalOutOfStock++;
      }

      if (pricing.sale_price) {
        totalDiscounted++;
      }

      // تنظیمات تصویر تستی
      const imagesPayload = NO_IMAGES
        ? []
        : [
            {
              src: getPlaceholderImageUrl(productName, i, cat.id),
              name: productName,
              alt: productName,
            },
          ];

      const productPayload = {
        name: productName,
        type: "simple",
        status: "publish",
        categories: categoryIdsForProduct,
        regular_price: pricing.regular_price,
        sale_price: pricing.sale_price,
        manage_stock: stock.manage_stock,
        stock_status: stock.stock_status,
        stock_quantity: stock.stock_quantity,
        short_description: shortDesc,
        description: fullDesc,
        images: imagesPayload,
      };

      const priceDisplay = Number(pricing.regular_price).toLocaleString("fa-IR");
      const saleDisplay = pricing.sale_price
        ? ` (تخفیف: ${Number(pricing.sale_price).toLocaleString("fa-IR")} ت)`
        : "";
      const stockDisplay =
        stock.stock_status === "instock"
          ? `موجود (${stock.stock_quantity} عدد)`
          : "ناموجود";

      if (IS_DRY_RUN) {
        console.log(
          `  🔎 [شبیه‌سازی] ${productName} | قیمت: ${priceDisplay} ت${saleDisplay} | وضعیت: ${stockDisplay}`,
        );
        totalProductsCreated++;
        continue;
      }

      try {
        let createdProduct;
        try {
          // تلاش برای ساخت محصول همراه با تصویر
          createdProduct = await apiRequest("products", "POST", productPayload);
        } catch (postErr) {
          // در صورتی که هاست به دلیل تحریم یا تایم‌اوت نتواند تصویر خارجی را دانلود کند،
          // بدون تصویر دوباره امتحان می‌کنیم تا ساخت محصولات هرگز متوقف نشود.
          if (
            postErr.message.includes("upload") ||
            postErr.message.includes("image") ||
            postErr.code === "woocommerce_product_image_upload_error"
          ) {
            console.log(
              `    ⚠️ بارگذاری تصویر با خطا مواجه شد؛ در حال ثبت بدون تصویر...`,
            );
            const fallbackPayload = { ...productPayload, images: [] };
            createdProduct = await apiRequest("products", "POST", fallbackPayload);
          } else {
            throw postErr;
          }
        }

        console.log(
          `  ✅ محصول ایجاد شد: "${productName}" (ID: ${createdProduct.id}) | ${priceDisplay} ت${saleDisplay} | ${stockDisplay}`,
        );
        totalProductsCreated++;

        // وقفه کوتاه برای پایداری سرور و جلوگیری از Rate Limit
        await sleep(150);
      } catch (createErr) {
        console.error(
          `  ❌ خطا در ساخت محصول "${productName}":`,
          createErr.message,
        );
      }
    }
  }

  // گزارش نهایی
  console.log("\n" + "=".repeat(70));
  console.log("🎉 فرآیند ساخت محصولات ماک با موفقیت پایان یافت!");
  console.log(`📦 کل محصولات ساخته شده: ${totalProductsCreated} محصول`);
  console.log(`🟢 موجود در انبار: ${totalInStock}`);
  console.log(`🔴 ناموجود: ${totalOutOfStock}`);
  console.log(`🏷️ دارای قیمت تخفیف‌دار: ${totalDiscounted}`);
  console.log(
    "💡 برای مشاهده و بررسی، به منوی محصولات در پیشخوان وردپرس یا صفحه فروشگاه سر بزنید.",
  );
  console.log("=".repeat(70) + "\n");
}

main().catch((err) => {
  console.error("\n❌ خطای پیش‌بینی‌نشده در اجرای اسکریپت:", err.message || err);
  process.exit(1);
});

