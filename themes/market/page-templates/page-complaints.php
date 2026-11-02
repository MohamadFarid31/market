<?php
/**
 * Template Name: Complaints Page | شکایات و پیشنهادات
 *
 * @package Market
 */

defined('ABSPATH') || exit;

get_header();
?>

<main id="primary" class="site-main complaints-page-main">
    <div class="container container-narrow">
        <header class="page-header" style="margin-block-end: var(--space-6); text-align: center;">
            <h1 class="page-title"><?php the_title(); ?></h1>
            <p style="color: var(--color-text-secondary); max-width: 580px; margin-inline: auto;">
                <?php esc_html_e('نظرات، پیشنهادات و شکایات شما مستقیماً توسط مدیریت مجموعه بررسی و پیگیری خواهد شد.', 'market'); ?>
            </p>
        </header>

        <div class="card p-6" style="background-color: var(--color-bg-surface); border: 1px solid var(--color-border-subtle); border-radius: var(--radius-xl); padding: var(--space-6);">
            <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                <?php wp_nonce_field('market_complaint_form', 'market_complaint_nonce'); ?>
                <input type="hidden" name="action" value="market_complaint_submit">

                <div class="form-group">
                    <label for="complaint-name" class="form-label"><?php esc_html_e('نام و نام خانوادگی', 'market'); ?> *</label>
                    <input type="text" id="complaint-name" name="complaint_name" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="complaint-phone" class="form-label"><?php esc_html_e('شماره تماس جهت پیگیری', 'market'); ?> *</label>
                    <input type="tel" id="complaint-phone" name="complaint_phone" class="form-control ltr-input" placeholder="09xxxxxxxxx" required>
                </div>

                <div class="form-group">
                    <label for="complaint-order-id" class="form-label"><?php esc_html_e('شماره سفارش (در صورت وجود)', 'market'); ?></label>
                    <input type="text" id="complaint-order-id" name="complaint_order_id" class="form-control ltr-input">
                </div>

                <div class="form-group">
                    <label for="complaint-subject" class="form-label"><?php esc_html_e('موضوع', 'market'); ?> *</label>
                    <select id="complaint-subject" name="complaint_subject" class="form-control" required>
                        <option value="complaint"><?php esc_html_e('شکایت از خدمات یا کالا', 'market'); ?></option>
                        <option value="suggestion"><?php esc_html_e('پیشنهاد و انتقاد سازنده', 'market'); ?></option>
                        <option value="delivery"><?php esc_html_e('پیگیری تأخیر در ارسال', 'market'); ?></option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="complaint-details" class="form-label"><?php esc_html_e('شرح کامل موضوع', 'market'); ?> *</label>
                    <textarea id="complaint-details" name="complaint_details" class="form-control" rows="5" required></textarea>
                </div>

                <button type="submit" class="btn btn-primary btn-block">
                    <?php esc_html_e('ثبت و دریافت کد رهگیری', 'market'); ?>
                </button>
            </form>
        </div>
    </div>
</main>

<?php
get_footer();
