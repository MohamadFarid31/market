<?php
/**
 * Market Theme — Comments Template
 *
 * @package Market
 */

defined('ABSPATH') || exit;

if (post_password_required()) {
    return;
}
?>

<div id="comments" class="comments-area" style="margin-block-start: var(--space-8); padding-block-start: var(--space-6); border-block-start: 1px solid var(--color-border-subtle);">
    <?php if (have_comments()) : ?>
        <h2 class="comments-title" style="font-size: var(--font-size-lg); margin-block-end: var(--space-4);">
            <?php
            $market_comment_count = get_comments_number();
            printf(
                /* translators: 1: title. 2: number of comments. */
                esc_html(_nx('یک دیدگاه در «%1$s»', '%2$s دیدگاه در «%1$s»', $market_comment_count, 'comments title', 'market')),
                get_the_title(),
                market_to_persian_numbers(number_format_i18n($market_comment_count))
            );
            ?>
        </h2>

        <ol class="comment-list" style="margin-block-end: var(--space-6);">
            <?php
            wp_list_comments([
                'style'      => 'ol',
                'short_ping' => true,
                'avatar_size'=> 48,
            ]);
            ?>
        </ol>

        <?php
        the_comments_navigation();

        if (!comments_open()) :
            ?>
            <p class="no-comments"><?php esc_html_e('ارسال دیدگاه برای این نوشته بسته شده است.', 'market'); ?></p>
            <?php
        endif;
    endif;

    comment_form([
        'class_form'           => 'comment-form form-group',
        'title_reply'          => esc_html__('ارسال دیدگاه', 'market'),
        'title_reply_to'       => esc_html__('پاسخ به %s', 'market'),
        'cancel_reply_link'    => esc_html__('انصراف از پاسخ', 'market'),
        'label_submit'         => esc_html__('ثبت دیدگاه', 'market'),
        'class_submit'         => 'btn btn-primary',
    ]);
    ?>
</div>
