<?php
/**
 * Market Theme — Homepage Banners & Sections Meta Boxes (Tailored CMS Edition)
 *
 * Allows store admins to manage homepage banners, slider images with links,
 * promo banners, and interactive hotspots directly from WordPress Admin.
 *
 * @package Market
 */

defined('ABSPATH') || exit;

/**
 * Register Meta Box for Front Page
 */
function market_register_homepage_metaboxes() {
    global $post;

    $front_page_id = (int) get_option('page_on_front');
    $is_front_page = ($post && $front_page_id > 0 && $post->ID === $front_page_id);
    $template = $post ? get_post_meta($post->ID, '_wp_page_template', true) : '';

    if ($is_front_page || $template === 'front-page.php' || (!empty($_GET['post']) && (int)$_GET['post'] === $front_page_id)) {
        add_meta_box(
            'market_homepage_banners_box',
            esc_html__('مدیریت بنرها و اسلایدرهای صفحه اصلی', 'market'),
            'market_render_homepage_banners_box',
            'page',
            'normal',
            'high'
        );
    }
}
add_action('add_meta_boxes', 'market_register_homepage_metaboxes');

/**
 * Enqueue Media Scripts
 */
function market_admin_enqueue_homepage_scripts($hook) {
    if ($hook === 'post.php' || $hook === 'post-new.php') {
        global $post;
        $front_page_id = (int) get_option('page_on_front');
        if ($post && ($post->ID === $front_page_id || get_post_meta($post->ID, '_wp_page_template', true) === 'front-page.php')) {
            wp_enqueue_media();
        }
    }
}
add_action('admin_enqueue_scripts', 'market_admin_enqueue_homepage_scripts');

/**
 * Render Homepage Meta Box
 */
function market_render_homepage_banners_box($post) {
    wp_nonce_field('market_save_homepage_meta', 'market_homepage_nonce');

    $meta = get_post_meta($post->ID, '_market_home_data', true);
    if (!is_array($meta)) {
        $meta = [];
    }

    $hero_slides = isset($meta['hero_slides']) && is_array($meta['hero_slides']) ? $meta['hero_slides'] : [];
    if (empty($hero_slides)) {
        // Default sample slide
        $hero_slides = [
            ['img' => '', 'url' => ''],
        ];
    }

    $circle_badge = isset($meta['circle_badge']) ? $meta['circle_badge'] : '';
    $circle_title = isset($meta['circle_title']) ? $meta['circle_title'] : '';

    $circle_categories = isset($meta['circle_categories']) && is_array($meta['circle_categories']) ? $meta['circle_categories'] : [];
    if (empty($circle_categories)) {
        $circle_categories = [
            [
                'title' => 'نورپردازی',
                'img'   => '',
                'url'   => function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop/'),
            ],
            [
                'title' => 'باتری و شارژرهای اصلی',
                'img'   => '',
                'url'   => function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop/'),
            ],
            [
                'title' => 'باتری و شارژرهای کپی',
                'img'   => '',
                'url'   => function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop/'),
            ],
            [
                'title' => 'میکروفون یقه‌ای',
                'img'   => '',
                'url'   => function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop/'),
            ],
            [
                'title' => 'لوازم جانبی دوربین',
                'img'   => '',
                'url'   => function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop/'),
            ],
            [
                'title' => 'پایه دوربین و رومیزی',
                'img'   => '',
                'url'   => function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop/'),
            ],
        ];
    }

    $wc_categories = [];
    if (taxonomy_exists('product_cat')) {
        $terms = get_terms([
            'taxonomy'   => 'product_cat',
            'hide_empty' => false,
        ]);
        if (!is_wp_error($terms) && !empty($terms)) {
            foreach ($terms as $t) {
                $thumb_id = get_term_meta($t->term_id, 'thumbnail_id', true);
                $thumb_url = $thumb_id ? wp_get_attachment_url($thumb_id) : '';
                $wc_categories[] = [
                    'id'    => $t->term_id,
                    'name'  => $t->name,
                    'link'  => get_term_link($t),
                    'thumb' => $thumb_url ? $thumb_url : '',
                ];
            }
        }
    }

    $hotspots = isset($meta['showcase_hotspots']) && is_array($meta['showcase_hotspots']) ? $meta['showcase_hotspots'] : [];
    if (empty($hotspots)) {
        $hotspots = [
            ['x' => '18', 'y' => '48', 'label' => 'گیمبال و استابلایزر', 'url' => ''],
            ['x' => '48', 'y' => '60', 'label' => 'دوربین و لنز', 'url' => ''],
            ['x' => '54', 'y' => '32', 'label' => 'پنل نور LED', 'url' => ''],
            ['x' => '78', 'y' => '45', 'label' => 'سه‌پایه حرفه‌ای', 'url' => ''],
        ];
    }

    $get_val = function ($key, $default = '') use ($meta) {
        return isset($meta[$key]) ? $meta[$key] : $default;
    };
    ?>
    <style>
        .market-meta-section {
            background: #fff;
            border: 1px solid #ccd0d4;
            border-radius: 8px;
            padding: 16px 20px;
            margin-bottom: 24px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        }
        .market-meta-section h3 {
            margin-top: 0;
            padding-bottom: 10px;
            border-bottom: 2px solid #e52534;
            color: #1d2327;
            font-size: 15px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .market-slide-card, .market-promo-card-item {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 14px;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
        }
        .market-cat-circle-card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 14px;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
            transition: border-color 0.2s ease;
        }
        .market-cat-circle-card:hover {
            border-color: #cbd5e1;
        }
        .market-cat-circle-preview {
            width: 82px;
            height: 82px;
            border-radius: 50%;
            background-color: #ffffff;
            border: 2px solid #e4e4e7;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            flex-shrink: 0;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
            padding: 8px;
            box-sizing: border-box;
        }
        .market-cat-circle-preview img {
            max-width: 100%;
            max-height: 100%;
            width: auto;
            height: auto;
            object-fit: contain;
            border-radius: 50%;
            display: block;
        }
        .market-cat-inputs {
            flex: 1;
            min-width: 280px;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        .market-cat-inputs input,
        .market-cat-inputs select {
            width: 100%;
            padding: 7px 10px;
            border-radius: 4px;
            border: 1px solid #cbd5e1;
            font-size: 13px;
        }
        .market-slide-preview, .market-promo-preview {
            width: 140px;
            height: 70px;
            border: 1px dashed #cbd5e1;
            border-radius: 6px;
            background: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            flex-shrink: 0;
        }
        .market-slide-preview img, .market-promo-preview img {
            max-width: 100%;
            max-height: 100%;
            object-fit: cover;
        }
        .market-slide-inputs {
            flex: 1;
            min-width: 250px;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        .market-slide-inputs input {
            width: 100%;
            padding: 6px 10px;
            border-radius: 4px;
            border: 1px solid #cbd5e1;
        }
        .btn-remove-item {
            color: #dc2626 !important;
            border-color: #fca5a5 !important;
            background: #fef2f2 !important;
        }
        .btn-remove-item:hover {
            background: #fee2e2 !important;
        }

        /* Hotspot Visual Tool */
        .hotspot-interactive-tool {
            position: relative;
            max-width: 100%;
            width: 720px;
            background: #18181b;
            border-radius: 12px;
            overflow: hidden;
            margin: 16px 0;
            cursor: crosshair;
            min-height: 280px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .hotspot-tool-img {
            width: 100%;
            height: auto;
            display: block;
            pointer-events: none;
            opacity: 0.85;
        }
        .admin-hotspot-pin {
            position: absolute;
            width: 22px;
            height: 22px;
            background: #e52534;
            color: #fff;
            border: 2px solid #fff;
            border-radius: 50%;
            font-size: 11px;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            transform: translate(50%, -50%);
            box-shadow: 0 0 10px rgba(229, 37, 52, 0.8);
            z-index: 5;
            cursor: move;
        }
        .hotspot-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
        }
        .hotspot-table th, .hotspot-table td {
            padding: 8px 10px;
            border: 1px solid #e2e8f0;
            text-align: right;
            font-size: 13px;
        }
        .hotspot-table th {
            background: #f1f5f9;
        }
    </style>

    <div class="market-homepage-meta-wrap" dir="rtl">
        <!-- ۱. اسلایدر هیرو (عکس + لینک نامحدود) -->
        <div class="market-meta-section">
            <h3>
                <span><?php esc_html_e('۱. اسلایدر بالای صفحه (Hero Slider)', 'market'); ?></span>
                <button type="button" class="button button-primary" id="addHeroSlideBtn">
                    <?php esc_html_e('+ افزودن اسلاید جدید', 'market'); ?>
                </button>
            </h3>
            <p class="description" style="margin-bottom: 14px;">
                <?php esc_html_e('هر تعداد بنر که تمایل دارید اضافه کنید. برای هر اسلاید فقط عکس بنر و لینک مورد نظر را انتخاب نمایید:', 'market'); ?>
            </p>

            <div id="heroSlidesContainer">
                <?php foreach ($hero_slides as $idx => $slide) : 
                    $img_url = isset($slide['img']) ? $slide['img'] : '';
                    $link_url = isset($slide['url']) ? $slide['url'] : '';
                ?>
                    <div class="market-slide-card" data-index="<?php echo $idx; ?>">
                        <div class="market-slide-preview">
                            <?php if ($img_url) : ?>
                                <img src="<?php echo esc_url($img_url); ?>">
                            <?php else : ?>
                                <span style="font-size: 11px; color: #94a3b8;"><?php esc_html_e('بدون تصویر', 'market'); ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="market-slide-inputs">
                            <div style="display: flex; gap: 8px;">
                                <input type="text" name="market_home[hero_slides][<?php echo $idx; ?>][img]" class="slide-img-input" value="<?php echo esc_url($img_url); ?>" placeholder="<?php esc_attr_e('آدرس تصویر بنر...', 'market'); ?>">
                                <button type="button" class="button slide-upload-btn"><?php esc_html_e('انتخاب تصویر', 'market'); ?></button>
                            </div>
                            <input type="url" name="market_home[hero_slides][<?php echo $idx; ?>][url]" value="<?php echo esc_url($link_url); ?>" placeholder="<?php esc_attr_e('لینک اسلاید (مثلاً https://... یا /shop/)', 'market'); ?>" dir="ltr">
                        </div>
                        <button type="button" class="button btn-remove-item remove-slide-btn"><?php esc_html_e('حذف اسلاید', 'market'); ?></button>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- ۲. دسته‌بندی‌های دایره‌ای (همه تجهیزات موردنیاز شما، در یک نگاه) -->
        <div class="market-meta-section">
            <h3>
                <span><?php esc_html_e('۲. دسته‌بندی‌های دایره‌ای (همه تجهیزات موردنیاز شما، در یک نگاه)', 'market'); ?></span>
                <button type="button" class="button button-primary" id="addCircleCategoryBtn">
                    <?php esc_html_e('+ افزودن دسته‌بندی جدید', 'market'); ?>
                </button>
            </h3>
            <p class="description" style="margin-bottom: 14px;">
                <?php esc_html_e('این دسته‌بندی‌ها به صورت اسلایدر اتوماتیک ۳تایی در یک ردیف در صفحه اصلی نمایش داده می‌شوند. برای هر آیتم می‌توانید تصویر درون دایره سفید، عنوان دسته‌بندی و لینک مقصد را تنظیم کنید (یا از منوی کشویی دسته‌بندی‌های موجود فروشگاه انتخاب نمایید):', 'market'); ?>
            </p>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 16px; background: #f1f5f9; padding: 12px; border-radius: 6px;">
                <div>
                    <label style="font-weight: 600; display: block; margin-bottom: 4px;"><?php esc_html_e('تیتر نشان بالای بخش', 'market'); ?></label>
                    <input type="text" name="market_home[circle_badge]" value="<?php echo esc_attr($circle_badge); ?>" placeholder="<?php esc_attr_e('همه تجهیزات موردنیاز شما، در یک نگاه', 'market'); ?>" style="width: 100%;">
                </div>
                <div>
                    <label style="font-weight: 600; display: block; margin-bottom: 4px;"><?php esc_html_e('عنوان اصلی بخش', 'market'); ?></label>
                    <input type="text" name="market_home[circle_title]" value="<?php echo esc_attr($circle_title); ?>" placeholder="<?php esc_attr_e('دسته‌بندی محصولات', 'market'); ?>" style="width: 100%;">
                </div>
            </div>

            <div id="circleCategoriesContainer">
                <?php foreach ($circle_categories as $c_idx => $c_item) : 
                    $c_title = isset($c_item['title']) ? $c_item['title'] : '';
                    $c_img = isset($c_item['img']) ? $c_item['img'] : '';
                    $c_url = isset($c_item['url']) ? $c_item['url'] : '';
                ?>
                    <div class="market-cat-circle-card" data-index="<?php echo $c_idx; ?>">
                        <div class="market-cat-circle-preview" title="<?php esc_attr_e('پیش‌نمایش تصویر در دایره سفید با بردر طوسی', 'market'); ?>">
                            <?php if ($c_img) : ?>
                                <img src="<?php echo esc_url($c_img); ?>" alt="<?php echo esc_attr($c_title); ?>">
                            <?php else : ?>
                                <span style="font-size: 11px; color: #94a3b8; text-align: center;"><?php esc_html_e('بدون تصویر', 'market'); ?></span>
                            <?php endif; ?>
                        </div>

                        <div class="market-cat-inputs">
                            <?php if (!empty($wc_categories)) : ?>
                                <select class="cat-quick-picker" style="background: #ffffff; color: #334155; border-color: #cbd5e1;">
                                    <option value="">-- انتخاب سریع از دسته‌بندی‌های ووکامرس (پر کردن خودکار) --</option>
                                    <?php foreach ($wc_categories as $wc_cat) : ?>
                                        <option value="<?php echo esc_attr($wc_cat['id']); ?>" 
                                                data-name="<?php echo esc_attr($wc_cat['name']); ?>" 
                                                data-link="<?php echo esc_url($wc_cat['link']); ?>" 
                                                data-thumb="<?php echo esc_url($wc_cat['thumb']); ?>">
                                            <?php echo esc_html($wc_cat['name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            <?php endif; ?>

                            <div style="display: flex; gap: 8px;">
                                <input type="text" name="market_home[circle_categories][<?php echo $c_idx; ?>][title]" class="cat-circle-title-input" value="<?php echo esc_attr($c_title); ?>" placeholder="<?php esc_attr_e('عنوان دسته‌بندی (مثلاً: نورپردازی)', 'market'); ?>" style="flex: 1;">
                                <button type="button" class="button cat-circle-upload-btn"><?php esc_html_e('انتخاب تصویر دایره', 'market'); ?></button>
                                <button type="button" class="button cat-circle-clear-btn" title="<?php esc_attr_e('حذف تصویر', 'market'); ?>">✕</button>
                            </div>

                            <div style="display: flex; gap: 8px;">
                                <input type="text" name="market_home[circle_categories][<?php echo $c_idx; ?>][img]" class="cat-circle-img-input" value="<?php echo esc_url($c_img); ?>" placeholder="<?php esc_attr_e('آدرس تصویر درون دایره (PNG یا JPG)...', 'market'); ?>" style="flex: 1;">
                                <input type="url" name="market_home[circle_categories][<?php echo $c_idx; ?>][url]" class="cat-circle-url-input" value="<?php echo esc_url($c_url); ?>" placeholder="<?php esc_attr_e('لینک دسته‌بندی (https://... یا /shop/)', 'market'); ?>" style="flex: 1;" dir="ltr">
                            </div>
                        </div>

                        <button type="button" class="button btn-remove-item remove-cat-circle-btn"><?php esc_html_e('حذف', 'market'); ?></button>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- ۳. ردیف اول ۳ بنر تبلیغاتی -->
        <div class="market-meta-section">
            <h3><?php esc_html_e('۳. ردیف اول ۳ بنر تبلیغاتی (۳ بنر کنار هم)', 'market'); ?></h3>
            <p class="description" style="margin-bottom: 14px;">
                <?php esc_html_e('تصویر طراحی‌شده و لینک هر یک از ۳ بنر ردیف اول را مشخص کنید:', 'market'); ?>
            </p>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 14px;">
                <?php for ($i = 1; $i <= 3; $i++) : 
                    $b_img = $get_val("promo_row1_{$i}_img", '');
                    $b_url = $get_val("promo_row1_{$i}_url", '');
                ?>
                    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 12px;">
                        <strong style="display: block; margin-bottom: 8px; color: #e52534;">
                            <?php echo sprintf(esc_html__('بنر %s', 'market'), market_to_persian_numbers($i)); ?>
                        </strong>
                        <div class="market-promo-preview" style="width: 100%; height: 90px; margin-bottom: 8px;">
                            <?php if ($b_img) : ?>
                                <img src="<?php echo esc_url($b_img); ?>">
                            <?php else : ?>
                                <span style="font-size: 11px; color: #94a3b8;"><?php esc_html_e('بدون تصویر', 'market'); ?></span>
                            <?php endif; ?>
                        </div>
                        <div style="display: flex; gap: 6px; margin-bottom: 8px;">
                            <input type="text" name="market_home[promo_row1_<?php echo $i; ?>_img]" class="slide-img-input" value="<?php echo esc_url($b_img); ?>" placeholder="<?php esc_attr_e('آدرس تصویر...', 'market'); ?>" style="width: 100%;">
                            <button type="button" class="button slide-upload-btn" style="flex-shrink: 0;"><?php esc_html_e('انتخاب', 'market'); ?></button>
                        </div>
                        <input type="url" name="market_home[promo_row1_<?php echo $i; ?>_url]" value="<?php echo esc_url($b_url); ?>" placeholder="<?php esc_attr_e('لینک بنر...', 'market'); ?>" style="width: 100%;" dir="ltr">
                    </div>
                <?php endfor; ?>
            </div>
        </div>

        <!-- ۴. بنر عریض کشف دنیای تجهیزات و نقاط تعاملی (Hotspots) -->
        <div class="market-meta-section">
            <h3><?php esc_html_e('۴. بنر عریض و نقاط تعاملی (Interactive Hotspots)', 'market'); ?></h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 12px;">
                <div>
                    <label style="font-weight: 600; display: block; margin-bottom: 4px;"><?php esc_html_e('بج بالای بنر', 'market'); ?></label>
                    <input type="text" name="market_home[showcase_badge]" value="<?php echo esc_attr($get_val('showcase_badge', 'جزئیات بیشتر، انتخابی دقیق‌تر')); ?>" style="width: 100%;">
                </div>
                <div>
                    <label style="font-weight: 600; display: block; margin-bottom: 4px;"><?php esc_html_e('عنوان اصلی بنر', 'market'); ?></label>
                    <input type="text" name="market_home[showcase_title]" value="<?php echo esc_attr($get_val('showcase_title', 'دنیای تجهیزات حرفه‌ای را کشف کنید')); ?>" style="width: 100%;">
                </div>
            </div>

            <div style="margin-bottom: 14px;">
                <label style="font-weight: 600; display: block; margin-bottom: 4px;"><?php esc_html_e('متن توضیحات بنر', 'market'); ?></label>
                <textarea name="market_home[showcase_desc]" rows="2" style="width: 100%;"><?php echo esc_textarea($get_val('showcase_desc', 'هر محصول برای یک هدف ساخته شده است: از ثبت تصاویر خیره‌کننده تا تولید محتوای حرفه‌ای، تجهیزات موردنیاز خود را از میان مجموعه‌ای از محصولات تخصصی پیدا کنید و با اطمینان، ابزار مناسب برای مسیر خلاقیت خود را انتخاب کنید.')); ?></textarea>
            </div>

            <div style="margin-bottom: 16px;">
                <label style="font-weight: 600; display: block; margin-bottom: 4px;"><?php esc_html_e('تصویر زمینه بنر برای قرارگیری نقاط تعاملی', 'market'); ?></label>
                <div style="display: flex; gap: 8px;">
                    <input type="text" name="market_home[showcase_img]" id="showcaseImgInput" class="slide-img-input" value="<?php echo esc_url($get_val('showcase_img')); ?>" placeholder="<?php esc_attr_e('آدرس تصویر بنر عریض...', 'market'); ?>" style="flex: 1;">
                    <button type="button" class="button slide-upload-btn" id="showcaseUploadBtn"><?php esc_html_e('انتخاب تصویر بنر', 'market'); ?></button>
                </div>
            </div>

            <!-- ابزار انتخاب نقاط روی عکس با کلیک -->
            <div style="background: #f1f5f9; padding: 14px; border-radius: 8px;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <strong><?php esc_html_e('تعیین نقاط تعاملی روی تصویر (روی عکس کلیک کنید):', 'market'); ?></strong>
                    <button type="button" class="button" id="addHotspotBtn"><?php esc_html_e('+ افزودن نقطه جدید', 'market'); ?></button>
                </div>

                <div class="hotspot-interactive-tool" id="hotspotCanvas">
                    <?php 
                    $showcase_bg = $get_val('showcase_img', '');
                    ?>
                    <img src="<?php echo esc_url($showcase_bg); ?>" class="hotspot-tool-img" id="hotspotToolImg" style="<?php echo empty($showcase_bg) ? 'display:none;' : ''; ?>">
                    <span id="hotspotPlaceholderNotice" style="<?php echo !empty($showcase_bg) ? 'display:none;' : ''; ?> color: #cbd5e1; font-size: 13px;">
                        <?php esc_html_e('ابتدا تصویر بنر را از فیلد بالا انتخاب کنید یا مستقیماً در کادر زیر کلیک کنید', 'market'); ?>
                    </span>

                    <div id="hotspotPinsContainer">
                        <?php foreach ($hotspots as $p_idx => $point) : ?>
                            <div class="admin-hotspot-pin" style="right: <?php echo esc_attr($point['x']); ?>%; top: <?php echo esc_attr($point['y']); ?>%;" data-idx="<?php echo $p_idx; ?>">
                                <?php echo ($p_idx + 1); ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- جدول مشخصات هر نقطه -->
                <table class="hotspot-table">
                    <thead>
                        <tr>
                            <th style="width: 40px; text-align: center;">#</th>
                            <th style="width: 100px;"><?php esc_html_e('افقی (X%)', 'market'); ?></th>
                            <th style="width: 100px;"><?php esc_html_e('عمودی (Y%)', 'market'); ?></th>
                            <th><?php esc_html_e('عنوان / متن نقطه', 'market'); ?></th>
                            <th><?php esc_html_e('لینک مقصد', 'market'); ?></th>
                            <th style="width: 80px; text-align: center;"><?php esc_html_e('عملیات', 'market'); ?></th>
                        </tr>
                    </thead>
                    <tbody id="hotspotRowsTbody">
                        <?php foreach ($hotspots as $p_idx => $point) : ?>
                            <tr data-idx="<?php echo $p_idx; ?>">
                                <td style="text-align: center; font-weight: bold; color: #e52534;"><?php echo ($p_idx + 1); ?></td>
                                <td><input type="number" step="0.1" name="market_home[showcase_hotspots][<?php echo $p_idx; ?>][x]" class="hotspot-coord-x" value="<?php echo esc_attr($point['x']); ?>" style="width: 100%;" dir="ltr"></td>
                                <td><input type="number" step="0.1" name="market_home[showcase_hotspots][<?php echo $p_idx; ?>][y]" class="hotspot-coord-y" value="<?php echo esc_attr($point['y']); ?>" style="width: 100%;" dir="ltr"></td>
                                <td><input type="text" name="market_home[showcase_hotspots][<?php echo $p_idx; ?>][label]" value="<?php echo esc_attr($point['label']); ?>" placeholder="<?php esc_attr_e('عنوان محصول یا تجهیز...', 'market'); ?>" style="width: 100%;"></td>
                                <td><input type="url" name="market_home[showcase_hotspots][<?php echo $p_idx; ?>][url]" value="<?php echo esc_url($point['url']); ?>" placeholder="https://..." style="width: 100%;" dir="ltr"></td>
                                <td style="text-align: center;">
                                    <button type="button" class="button btn-remove-item remove-hotspot-btn"><?php esc_html_e('حذف', 'market'); ?></button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ۵. ردیف دوم ۳ بنر تبلیغاتی -->
        <div class="market-meta-section">
            <h3><?php esc_html_e('۵. ردیف دوم ۳ بنر تبلیغاتی (۳ بنر کنار هم)', 'market'); ?></h3>
            <p class="description" style="margin-bottom: 14px;">
                <?php esc_html_e('تصویر و لینک ۳ بنر ردیف دوم را مشخص کنید:', 'market'); ?>
            </p>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 14px;">
                <?php for ($i = 1; $i <= 3; $i++) : 
                    $b_img = $get_val("promo_row2_{$i}_img", '');
                    $b_url = $get_val("promo_row2_{$i}_url", '');
                ?>
                    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 12px;">
                        <strong style="display: block; margin-bottom: 8px; color: #e52534;">
                            <?php echo sprintf(esc_html__('بنر %s', 'market'), market_to_persian_numbers($i)); ?>
                        </strong>
                        <div class="market-promo-preview" style="width: 100%; height: 90px; margin-bottom: 8px;">
                            <?php if ($b_img) : ?>
                                <img src="<?php echo esc_url($b_img); ?>">
                            <?php else : ?>
                                <span style="font-size: 11px; color: #94a3b8;"><?php esc_html_e('بدون تصویر', 'market'); ?></span>
                            <?php endif; ?>
                        </div>
                        <div style="display: flex; gap: 6px; margin-bottom: 8px;">
                            <input type="text" name="market_home[promo_row2_<?php echo $i; ?>_img]" class="slide-img-input" value="<?php echo esc_url($b_img); ?>" placeholder="<?php esc_attr_e('آدرس تصویر...', 'market'); ?>" style="width: 100%;">
                            <button type="button" class="button slide-upload-btn" style="flex-shrink: 0;"><?php esc_html_e('انتخاب', 'market'); ?></button>
                        </div>
                        <input type="url" name="market_home[promo_row2_<?php echo $i; ?>_url]" value="<?php echo esc_url($b_url); ?>" placeholder="<?php esc_attr_e('لینک بنر...', 'market'); ?>" style="width: 100%;" dir="ltr">
                    </div>
                <?php endfor; ?>
            </div>
        </div>
    </div>

    <!-- Template for Adding New Circle Category Item -->
    <template id="tmplCircleCategoryRow">
        <div class="market-cat-circle-card" data-index="__INDEX__">
            <div class="market-cat-circle-preview" title="<?php esc_attr_e('پیش‌نمایش تصویر در دایره سفید با بردر طوسی', 'market'); ?>">
                <span style="font-size: 11px; color: #94a3b8; text-align: center;"><?php esc_html_e('بدون تصویر', 'market'); ?></span>
            </div>
            <div class="market-cat-inputs">
                <?php if (!empty($wc_categories)) : ?>
                    <select class="cat-quick-picker" style="background: #ffffff; color: #334155; border-color: #cbd5e1;">
                        <option value="">-- انتخاب سریع از دسته‌بندی‌های ووکامرس (پر کردن خودکار) --</option>
                        <?php foreach ($wc_categories as $wc_cat) : ?>
                            <option value="<?php echo esc_attr($wc_cat['id']); ?>" 
                                    data-name="<?php echo esc_attr($wc_cat['name']); ?>" 
                                    data-link="<?php echo esc_url($wc_cat['link']); ?>" 
                                    data-thumb="<?php echo esc_url($wc_cat['thumb']); ?>">
                                <?php echo esc_html($wc_cat['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                <?php endif; ?>
                <div style="display: flex; gap: 8px;">
                    <input type="text" name="market_home[circle_categories][__INDEX__][title]" class="cat-circle-title-input" placeholder="<?php esc_attr_e('عنوان دسته‌بندی (مثلاً: لنز دوربین)', 'market'); ?>" style="flex: 1;">
                    <button type="button" class="button cat-circle-upload-btn"><?php esc_html_e('انتخاب تصویر دایره', 'market'); ?></button>
                    <button type="button" class="button cat-circle-clear-btn" title="<?php esc_attr_e('حذف تصویر', 'market'); ?>">✕</button>
                </div>
                <div style="display: flex; gap: 8px;">
                    <input type="text" name="market_home[circle_categories][__INDEX__][img]" class="cat-circle-img-input" placeholder="<?php esc_attr_e('آدرس تصویر درون دایره (PNG یا JPG)...', 'market'); ?>" style="flex: 1;">
                    <input type="url" name="market_home[circle_categories][__INDEX__][url]" class="cat-circle-url-input" placeholder="<?php esc_attr_e('لینک دسته‌بندی (https://... یا /shop/)', 'market'); ?>" style="flex: 1;" dir="ltr">
                </div>
            </div>
            <button type="button" class="button btn-remove-item remove-cat-circle-btn"><?php esc_html_e('حذف', 'market'); ?></button>
        </div>
    </template>

    <!-- Admin Interactive Script -->
    <script>
    jQuery(document).ready(function($) {
        // افزودن دسته‌بندی دایره‌ای جدید
        $('#addCircleCategoryBtn').on('click', function() {
            var container = $('#circleCategoriesContainer');
            var uniqueIdx = new Date().getTime();
            var tmpl = $('#tmplCircleCategoryRow').html();
            var newCard = tmpl.replace(/__INDEX__/g, uniqueIdx);
            container.append(newCard);
        });

        // حذف دسته‌بندی دایره‌ای
        $(document).on('click', '.remove-cat-circle-btn', function() {
            $(this).closest('.market-cat-circle-card').remove();
        });

        // انتخاب سریع از دسته‌بندی‌های ووکامرس
        $(document).on('change', '.cat-quick-picker', function() {
            var opt = $(this).find('option:selected');
            if (!opt.val()) return;
            var card = $(this).closest('.market-cat-circle-card');
            var name = opt.data('name');
            var link = opt.data('link');
            var thumb = opt.data('thumb');

            if (name) {
                card.find('.cat-circle-title-input').val(name);
            }
            if (link) {
                card.find('.cat-circle-url-input').val(link);
            }
            if (thumb) {
                card.find('.cat-circle-img-input').val(thumb);
                card.find('.market-cat-circle-preview').html('<img src="' + thumb + '" alt="' + name + '">');
            }
        });

        // آپلود تصویر دسته‌بندی دایره‌ای
        $(document).on('click', '.cat-circle-upload-btn', function(e) {
            e.preventDefault();
            var btn = $(this);
            var card = btn.closest('.market-cat-circle-card');
            var input = card.find('.cat-circle-img-input');
            var preview = card.find('.market-cat-circle-preview');

            var mediaModal = wp.media({
                title: 'انتخاب یا آپلود تصویر دسته‌بندی دایره‌ای',
                button: { text: 'استفاده از این تصویر' },
                multiple: false
            });

            mediaModal.on('select', function() {
                var attachment = mediaModal.state().get('selection').first().toJSON();
                input.val(attachment.url);
                preview.html('<img src="' + attachment.url + '">');
            });

            mediaModal.open();
        });

        // پاک کردن تصویر دایره‌ای
        $(document).on('click', '.cat-circle-clear-btn', function(e) {
            e.preventDefault();
            var card = $(this).closest('.market-cat-circle-card');
            card.find('.cat-circle-img-input').val('');
            card.find('.market-cat-circle-preview').html('<span style="font-size: 11px; color: #94a3b8; text-align: center;">بدون تصویر</span>');
        });
        // ۱. مدیریت آپلود تصاویر با مدیا لایبرری
        $(document).on('click', '.slide-upload-btn', function(e) {
            e.preventDefault();
            var btn = $(this);
            var parent = btn.parent();
            var input = parent.find('.slide-img-input');
            var card = btn.closest('.market-slide-card, div');
            var preview = card.find('.market-slide-preview, .market-promo-preview');

            var mediaModal = wp.media({
                title: 'انتخاب تصویر بنر',
                button: { text: 'استفاده از این تصویر' },
                multiple: false
            });

            mediaModal.on('select', function() {
                var attachment = mediaModal.state().get('selection').first().toJSON();
                input.val(attachment.url);
                preview.html('<img src="' + attachment.url + '">');

                if (btn.attr('id') === 'showcaseUploadBtn') {
                    $('#hotspotToolImg').attr('src', attachment.url).show();
                    $('#hotspotPlaceholderNotice').hide();
                }
            });

            mediaModal.open();
        });

        // ۲. افزودن اسلاید جدید به اسلایدر هیرو
        $('#addHeroSlideBtn').on('click', function() {
            var container = $('#heroSlidesContainer');
            var count = container.children('.market-slide-card').length;
            var html = `
                <div class="market-slide-card" data-index="${count}">
                    <div class="market-slide-preview">
                        <span style="font-size: 11px; color: #94a3b8;">بدون تصویر</span>
                    </div>
                    <div class="market-slide-inputs">
                        <div style="display: flex; gap: 8px;">
                            <input type="text" name="market_home[hero_slides][${count}][img]" class="slide-img-input" placeholder="آدرس تصویر بنر...">
                            <button type="button" class="button slide-upload-btn">انتخاب تصویر</button>
                        </div>
                        <input type="url" name="market_home[hero_slides][${count}][url]" placeholder="لینک اسلاید (مثلاً https://... یا /shop/)" dir="ltr">
                    </div>
                    <button type="button" class="button btn-remove-item remove-slide-btn">حذف اسلاید</button>
                </div>
            `;
            container.append(html);
        });

        // حذف اسلاید هیرو
        $(document).on('click', '.remove-slide-btn', function() {
            $(this).closest('.market-slide-card').remove();
        });

        // ۳. مدیریت کلیک روی بنر عریض برای قرار دادن یا اضافه کردن نقطه (Hotspot)
        $('#hotspotCanvas').on('click', function(e) {
            if ($(e.target).hasClass('admin-hotspot-pin')) return;

            var offset = $(this).offset();
            var width = $(this).outerWidth();
            var height = $(this).outerHeight();

            // Calculate percentage (in RTL, Right% is (width - clickX) / width * 100)
            var clickX = e.pageX - offset.left;
            var clickY = e.pageY - offset.top;

            var rightPct = ((width - clickX) / width * 100).toFixed(1);
            var topPct = (clickY / height * 100).toFixed(1);

            addHotspotRow(rightPct, topPct, '', '');
        });

        $('#addHotspotBtn').on('click', function() {
            addHotspotRow(50, 50, '', '');
        });

        function addHotspotRow(x, y, label, url) {
            var tbody = $('#hotspotRowsTbody');
            var idx = tbody.children('tr').length;
            var num = idx + 1;

            var rowHtml = `
                <tr data-idx="${idx}">
                    <td style="text-align: center; font-weight: bold; color: #e52534;">${num}</td>
                    <td><input type="number" step="0.1" name="market_home[showcase_hotspots][${idx}][x]" class="hotspot-coord-x" value="${x}" style="width: 100%;" dir="ltr"></td>
                    <td><input type="number" step="0.1" name="market_home[showcase_hotspots][${idx}][y]" class="hotspot-coord-y" value="${y}" style="width: 100%;" dir="ltr"></td>
                    <td><input type="text" name="market_home[showcase_hotspots][${idx}][label]" value="${label}" placeholder="عنوان محصول یا تجهیز..." style="width: 100%;"></td>
                    <td><input type="url" name="market_home[showcase_hotspots][${idx}][url]" value="${url}" placeholder="https://..." style="width: 100%;" dir="ltr"></td>
                    <td style="text-align: center;">
                        <button type="button" class="button btn-remove-item remove-hotspot-btn">حذف</button>
                    </td>
                </tr>
            `;
            tbody.append(rowHtml);

            var pinHtml = `<div class="admin-hotspot-pin" style="right: ${x}%; top: ${y}%;" data-idx="${idx}">${num}</div>`;
            $('#hotspotPinsContainer').append(pinHtml);
        }

        // تغییر زنده موقعیت پین‌ها با تغییر اعداد
        $(document).on('input', '.hotspot-coord-x, .hotspot-coord-y', function() {
            var tr = $(this).closest('tr');
            var idx = tr.data('idx');
            var x = tr.find('.hotspot-coord-x').val();
            var y = tr.find('.hotspot-coord-y').val();
            var pin = $('#hotspotPinsContainer').find(`.admin-hotspot-pin[data-idx="${idx}"]`);
            if (pin.length) {
                pin.css({ right: x + '%', top: y + '%' });
            }
        });

        // حذف نقطه
        $(document).on('click', '.remove-hotspot-btn', function() {
            var tr = $(this).closest('tr');
            var idx = tr.data('idx');
            tr.remove();
            $('#hotspotPinsContainer').find(`.admin-hotspot-pin[data-idx="${idx}"]`).remove();
            // Renumber
            $('#hotspotRowsTbody tr').each(function(i) {
                $(this).find('td:first').text(i + 1);
            });
            $('#hotspotPinsContainer .admin-hotspot-pin').each(function(i) {
                $(this).text(i + 1);
            });
        });
    });
    </script>
    <?php
}

/**
 * Save Homepage Meta Data
 */
function market_save_homepage_meta($post_id) {
    if (!isset($_POST['market_homepage_nonce']) || !wp_verify_nonce($_POST['market_homepage_nonce'], 'market_save_homepage_meta')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_page', $post_id)) {
        return;
    }

    if (isset($_POST['market_home']) && is_array($_POST['market_home'])) {
        $raw = $_POST['market_home'];
        $clean = [];

        // 1. Hero Slides
        if (!empty($raw['hero_slides']) && is_array($raw['hero_slides'])) {
            $clean['hero_slides'] = [];
            foreach ($raw['hero_slides'] as $slide) {
                if (!empty($slide['img']) || !empty($slide['url'])) {
                    $clean['hero_slides'][] = [
                        'img' => esc_url_raw(trim($slide['img'])),
                        'url' => esc_url_raw(trim($slide['url'])),
                    ];
                }
            }
        }

        // 2. Circle Categories (دسته‌بندی‌های دایره‌ای)
        $clean['circle_badge'] = !empty($raw['circle_badge']) ? sanitize_text_field($raw['circle_badge']) : '';
        $clean['circle_title'] = !empty($raw['circle_title']) ? sanitize_text_field($raw['circle_title']) : '';

        if (!empty($raw['circle_categories']) && is_array($raw['circle_categories'])) {
            $clean['circle_categories'] = [];
            foreach ($raw['circle_categories'] as $cat) {
                $title = !empty($cat['title']) ? sanitize_text_field($cat['title']) : '';
                $img   = !empty($cat['img']) ? esc_url_raw(trim($cat['img'])) : '';
                $url   = !empty($cat['url']) ? esc_url_raw(trim($cat['url'])) : '';

                if (!empty($title) || !empty($img) || !empty($url)) {
                    $clean['circle_categories'][] = [
                        'title' => $title,
                        'img'   => $img,
                        'url'   => $url,
                    ];
                }
            }
        }

        // 3. Promo Row 1 (Banners 1, 2, 3)
        for ($i = 1; $i <= 3; $i++) {
            $clean["promo_row1_{$i}_img"] = !empty($raw["promo_row1_{$i}_img"]) ? esc_url_raw(trim($raw["promo_row1_{$i}_img"])) : '';
            $clean["promo_row1_{$i}_url"] = !empty($raw["promo_row1_{$i}_url"]) ? esc_url_raw(trim($raw["promo_row1_{$i}_url"])) : '';
        }

        // 4. Showcase Section & Hotspots
        $clean['showcase_badge'] = !empty($raw['showcase_badge']) ? sanitize_text_field($raw['showcase_badge']) : '';
        $clean['showcase_title'] = !empty($raw['showcase_title']) ? sanitize_text_field($raw['showcase_title']) : '';
        $clean['showcase_desc']  = !empty($raw['showcase_desc']) ? sanitize_textarea_field($raw['showcase_desc']) : '';
        $clean['showcase_img']   = !empty($raw['showcase_img']) ? esc_url_raw(trim($raw['showcase_img'])) : '';

        if (!empty($raw['showcase_hotspots']) && is_array($raw['showcase_hotspots'])) {
            $clean['showcase_hotspots'] = [];
            foreach ($raw['showcase_hotspots'] as $pt) {
                if (!empty($pt['label']) || !empty($pt['url']) || isset($pt['x'])) {
                    $clean['showcase_hotspots'][] = [
                        'x'     => floatval($pt['x']),
                        'y'     => floatval($pt['y']),
                        'label' => sanitize_text_field($pt['label']),
                        'url'   => esc_url_raw(trim($pt['url'])),
                    ];
                }
            }
        }

        // 5. Promo Row 2 (Banners 1, 2, 3)
        for ($i = 1; $i <= 3; $i++) {
            $clean["promo_row2_{$i}_img"] = !empty($raw["promo_row2_{$i}_img"]) ? esc_url_raw(trim($raw["promo_row2_{$i}_img"])) : '';
            $clean["promo_row2_{$i}_url"] = !empty($raw["promo_row2_{$i}_url"]) ? esc_url_raw(trim($raw["promo_row2_{$i}_url"])) : '';
        }

        update_post_meta($post_id, '_market_home_data', $clean);
    }
}
add_action('save_post_page', 'market_save_homepage_meta');
