<?php
/**
 * Template Name: Contact Page | تماس با ما
 *
 * @package Market
 */

defined('ABSPATH') || exit;

get_header();
?>

<main id="primary" class="site-main contact-page-main">
    <div class="container">
        <header class="page-header" style="margin-block-end: var(--space-6);">
            <h1 class="page-title"><?php the_title(); ?></h1>
        </header>

        <div class="contact-grid">
            <div class="contact-info-col">
                <div class="contact-card">
                    <div class="contact-icon" aria-hidden="true">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                            <circle cx="12" cy="10" r="3"></circle>
                        </svg>
                    </div>
                    <div>
                        <h3 style="font-size: var(--font-size-base); font-weight: var(--font-weight-bold); margin-block-end: 4px;"><?php esc_html_e('نشانی دفتر مرکزی', 'market'); ?></h3>
                        <p style="font-size: var(--font-size-sm); color: var(--color-text-secondary); margin: 0;">
                            <?php esc_html_e('نشانی فروشگاه پس از تکمیل اطلاعات بارگذاری خواهد شد.', 'market'); ?>
                        </p>
                    </div>
                </div>

                <div class="contact-card">
                    <div class="contact-icon" aria-hidden="true">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 style="font-size: var(--font-size-base); font-weight: var(--font-weight-bold); margin-block-end: 4px;"><?php esc_html_e('شماره تماس پشتیبانی', 'market'); ?></h3>
                        <p style="font-size: var(--font-size-sm); color: var(--color-text-secondary); margin: 0;" class="ltr-text">
                            021-00000000
                        </p>
                    </div>
                </div>

                <div class="contact-card">
                    <div class="contact-icon" aria-hidden="true">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12 6 12 12 16 14"></polyline>
                        </svg>
                    </div>
                    <div>
                        <h3 style="font-size: var(--font-size-base); font-weight: var(--font-weight-bold); margin-block-end: 4px;"><?php esc_html_e('ساعات کاری', 'market'); ?></h3>
                        <p style="font-size: var(--font-size-sm); color: var(--color-text-secondary); margin: 0;">
                            <?php esc_html_e('شنبه تا چهارشنبه ۹ الی ۱۸ | پنج‌شنبه‌ها ۹ الی ۱۴', 'market'); ?>
                        </p>
                    </div>
                </div>
            </div>

            <div class="contact-form-col card p-6" style="background-color: var(--color-bg-surface); border: 1px solid var(--color-border-subtle); border-radius: var(--radius-xl); padding: var(--space-6);">
                <h2 style="font-size: var(--font-size-lg); font-weight: var(--font-weight-bold); margin-block-end: var(--space-4);">
                    <?php esc_html_e('ارسال پیام', 'market'); ?>
                </h2>

                <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                    <?php wp_nonce_field('market_contact_form', 'market_contact_nonce'); ?>
                    <input type="hidden" name="action" value="market_contact_submit">

                    <div class="form-group">
                        <label for="contact-name" class="form-label"><?php esc_html_e('نام و نام خانوادگی', 'market'); ?> *</label>
                        <input type="text" id="contact-name" name="contact_name" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="contact-phone" class="form-label"><?php esc_html_e('شماره موبایل', 'market'); ?> *</label>
                        <input type="tel" id="contact-phone" name="contact_phone" class="form-control ltr-input" placeholder="09xxxxxxxxx" required>
                    </div>

                    <div class="form-group">
                        <label for="contact-message" class="form-label"><?php esc_html_e('متن پیام', 'market'); ?> *</label>
                        <textarea id="contact-message" name="contact_message" class="form-control" rows="4" required></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">
                        <?php esc_html_e('ارسال پیام', 'market'); ?>
                    </button>
                </form>
            </div>
        </div>
    </div>
</main>

<?php
get_footer();
