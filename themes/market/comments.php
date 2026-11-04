<?php
/**
 * Market Theme — Comments Template (Taj Bazar Style)
 *
 * @package Market
 */

defined('ABSPATH') || exit;

if (post_password_required()) {
    return;
}

$comments_count = get_comments_number();
?>

<div id="comments" class="comments-area taj-comments-section">
    <!-- تیتر بخش دیدگاه‌ها -->
    <div class="taj-comments-header">
        <h2 class="taj-comments-title">
            <span class="comments-indicator-dot"></span>
            <span><?php esc_html_e('دیدگاه کاربران', 'market'); ?></span>
        </h2>
    </div>

    <?php if (have_comments()) : ?>
        <ol class="comment-list taj-comment-list">
            <?php
            wp_list_comments([
                'style'       => 'ol',
                'short_ping'  => true,
                'avatar_size' => 44,
            ]);
            ?>
        </ol>

        <?php the_comments_navigation(); ?>

        <?php if (!comments_open()) : ?>
            <p class="no-comments"><?php esc_html_e('ارسال دیدگاه برای این نوشته بسته شده است.', 'market'); ?></p>
        <?php endif; ?>
    <?php else : ?>
        <!-- حالت بدون دیدگاه مطابق تاج بازار -->
        <div class="taj-comments-empty">
            <div class="empty-comment-icon">
                <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="#a1a1aa" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                    <line x1="8" y1="9" x2="16" y2="9"></line>
                    <line x1="8" y1="13" x2="14" y2="13"></line>
                </svg>
            </div>
            <p class="empty-comment-text"><?php esc_html_e('هنوز دیدگاهی ثبت نشده است.', 'market'); ?></p>
        </div>
    <?php endif; ?>

    <?php if (comments_open()) : ?>
        <!-- دکمه باز کردن فرم دیدگاه -->
        <div class="taj-comment-toggle-wrap">
            <button type="button" class="taj-comment-toggle-btn" id="tajOpenCommentBtn">
                <div class="toggle-btn-content">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                        <line x1="8" y1="9" x2="16" y2="9"></line>
                        <line x1="8" y1="13" x2="14" y2="13"></line>
                    </svg>
                    <span><?php esc_html_e('دیدگاه خود را درباره این مطلب بنویسید', 'market'); ?></span>
                </div>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="toggle-btn-chevron">
                    <polyline points="15 18 9 12 15 6"></polyline>
                </svg>
            </button>
        </div>

        <!-- فرم ارسال دیدگاه -->
        <div class="taj-comment-form-wrap" id="tajCommentFormWrap" style="display: none;">
            <?php
            $commenter = wp_get_current_commenter();
            $req = get_option('require_name_email');
            $aria_req = ($req ? " aria-required='true'" : '');

            comment_form([
                'class_form'           => 'taj-comment-form',
                'title_reply'          => '',
                'title_reply_to'       => esc_html__('پاسخ به %s', 'market'),
                'cancel_reply_link'    => esc_html__('انصراف از پاسخ', 'market'),
                'label_submit'         => esc_html__('ارسال دیدگاه', 'market'),
                'class_submit'         => 'taj-comment-submit-btn',
                'comment_field'        => '<div class="form-group"><label class="form-label" for="comment">' . esc_html__('متن دیدگاه شما', 'market') . ' *</label><textarea id="comment" name="comment" class="form-control taj-comment-textarea" rows="5" placeholder="' . esc_attr__('دیدگاه یا سوال خود را در مورد این مقاله بنویسید...', 'market') . '" required></textarea></div>',
                'fields'               => [
                    'author' => '<div class="taj-comment-fields-row"><div class="form-group"><label class="form-label" for="author">' . esc_html__('نام و نام خانوادگی', 'market') . ($req ? ' *' : '') . '</label><input id="author" name="author" type="text" class="form-control" value="' . esc_attr($commenter['comment_author']) . '"' . $aria_req . ' placeholder="' . esc_attr__('نام شما', 'market') . '" /></div>',
                    'email'  => '<div class="form-group"><label class="form-label" for="email">' . esc_html__('ایمیل', 'market') . ($req ? ' *' : '') . '</label><input id="email" name="email" type="email" class="form-control ltr-input" value="' . esc_attr($commenter['comment_author_email']) . '"' . $aria_req . ' placeholder="example@gmail.com" dir="ltr" /></div></div>',
                ],
            ]);
            ?>
        </div>

        <script>
        document.addEventListener('DOMContentLoaded', function() {
            var btn = document.getElementById('tajOpenCommentBtn');
            var wrap = document.getElementById('tajCommentFormWrap');
            if (btn && wrap) {
                btn.addEventListener('click', function() {
                    var isHidden = wrap.style.display === 'none';
                    wrap.style.display = isHidden ? 'block' : 'none';
                    if (isHidden) {
                        wrap.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }
                });
            }
        });
        </script>
    <?php endif; ?>
</div>
