<?php
/**
 * Market Theme — Custom Template Tags & Helpers
 *
 * @package Market
 */

defined('ABSPATH') || exit;

if (!function_exists('market_posted_on')) {
    /**
     * Prints HTML with meta information for the current post date/time.
     */
    function market_posted_on() {
        $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

        $time_string = sprintf(
            $time_string,
            esc_attr(get_the_date(DATE_W3C)),
            esc_html(market_format_persian_date(get_the_time('U')))
        );

        echo '<span class="posted-on">' . $time_string . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }
}

if (!function_exists('market_posted_by')) {
    /**
     * Prints HTML with meta information about the author.
     */
    function market_posted_by() {
        $byline = sprintf(
            /* translators: %s: post author. */
            esc_html_x('توسط %s', 'post author', 'market'),
            '<span class="author vcard"><a class="url fn n" href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' . esc_html(get_the_author()) . '</a></span>'
        );

        echo '<span class="byline"> ' . $byline . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }
}

if (!function_exists('market_post_thumbnail')) {
    /**
     * Displays an optional post thumbnail.
     *
     * @param string $size
     * @param array $attr
     */
    function market_post_thumbnail($size = 'market-blog-thumb', $attr = []) {
        if (post_password_required() || is_attachment() || !has_post_thumbnail()) {
            return;
        }

        if (is_singular()) {
            ?>
            <div class="post-thumbnail single-post-thumb">
                <?php the_post_thumbnail($size, $attr); ?>
            </div>
            <?php
        } else {
            ?>
            <a class="post-thumbnail article-card-thumb" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
                <?php the_post_thumbnail($size, $attr); ?>
            </a>
            <?php
        }
    }
}

/**
 * Handle Contact Form Submission
 */
add_action('admin_post_nopriv_market_contact_submit', 'market_handle_contact_submit');
add_action('admin_post_market_contact_submit', 'market_handle_contact_submit');

function market_handle_contact_submit() {
    if (!isset($_POST['market_contact_nonce']) || !wp_verify_nonce($_POST['market_contact_nonce'], 'market_contact_form')) {
        wp_die(esc_html__('درخواست نامعتبر است.', 'market'));
    }

    $first_name = isset($_POST['contact_first_name']) ? sanitize_text_field($_POST['contact_first_name']) : '';
    $last_name  = isset($_POST['contact_last_name']) ? sanitize_text_field($_POST['contact_last_name']) : '';
    $phone      = isset($_POST['contact_phone']) ? sanitize_text_field($_POST['contact_phone']) : '';
    $email      = isset($_POST['contact_email']) ? sanitize_email($_POST['contact_email']) : '';
    $subject    = isset($_POST['contact_subject']) ? sanitize_text_field($_POST['contact_subject']) : '';
    $message    = isset($_POST['contact_message']) ? sanitize_textarea_field($_POST['contact_message']) : '';

    $to = get_option('admin_email');
    $mail_subject = sprintf('پیام جدید از فرم تماس: %s - %s %s', $subject, $first_name, $last_name);
    $body = sprintf("نام: %s %s\nشماره تماس: %s\nایمیل: %s\nموضوع: %s\n\nمتن پیام:\n%s", $first_name, $last_name, $phone, $email, $subject, $message);

    @wp_mail($to, $mail_subject, $body);

    $referer = wp_get_referer();
    $redirect = $referer ? add_query_arg('contact', 'success', $referer) : home_url('/contact-us/?contact=success');
    wp_safe_redirect($redirect);
    exit;
}

/**
 * Handle Complaints & Suggestions Form Submission
 */
add_action('admin_post_nopriv_market_complaint_submit', 'market_handle_complaint_submit');
add_action('admin_post_market_complaint_submit', 'market_handle_complaint_submit');

function market_handle_complaint_submit() {
    if (!isset($_POST['market_complaint_nonce']) || !wp_verify_nonce($_POST['market_complaint_nonce'], 'market_complaint_form')) {
        wp_die(esc_html__('درخواست نامعتبر است.', 'market'));
    }

    $name        = isset($_POST['complaint_name']) ? sanitize_text_field($_POST['complaint_name']) : '';
    $email       = isset($_POST['complaint_email']) ? sanitize_email($_POST['complaint_email']) : '';
    $phone       = isset($_POST['complaint_phone']) ? sanitize_text_field($_POST['complaint_phone']) : '';
    $subject     = isset($_POST['complaint_subject']) ? sanitize_text_field($_POST['complaint_subject']) : '';
    $referral    = isset($_POST['complaint_referral']) ? sanitize_text_field($_POST['complaint_referral']) : '';
    $details     = isset($_POST['complaint_details']) ? sanitize_textarea_field($_POST['complaint_details']) : '';

    $to = get_option('admin_email');
    $mail_subject = sprintf('پیشنهاد یا انتقاد جدید: %s - %s', $subject, $name);
    $body = sprintf(
        "نام و نام خانوادگی: %s\nایمیل: %s\nشماره تماس: %s\nموضوع: %s\nنحوه آشنایی: %s\n\nتوضیحات:\n%s",
        $name, $email, $phone, $subject, $referral, $details
    );

    @wp_mail($to, $mail_subject, $body);

    $referer = wp_get_referer();
    $redirect = $referer ? add_query_arg('complaint', 'success', $referer) : home_url('/complaints/?complaint=success');
    wp_safe_redirect($redirect);
    exit;
}
