<?php
/**
 * Market Theme — Persian Localization & Number Formatter Helpers
 *
 * @package Market
 */

defined('ABSPATH') || exit;

if (!function_exists('market_to_persian_numbers')) {
    /**
     * Converts English digits to Persian digits.
     *
     * @param string|int $number
     * @return string
     */
    function market_to_persian_numbers($number) {
        $en = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        $fa = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        return str_replace($en, $fa, (string) $number);
    }
}

if (!function_exists('market_normalize_persian_text')) {
    /**
     * Normalizes Arabic characters (ي, ك) to Persian (ی, ک).
     *
     * @param string $text
     * @return string
     */
    function market_normalize_persian_text($text) {
        $arabic  = ['ي', 'ك', 'ۀ', 'ة'];
        $persian = ['ی', 'ک', 'ه', 'ت'];
        return str_replace($arabic, $persian, $text);
    }
}

if (!function_exists('market_format_persian_date')) {
    /**
     * Formats a Unix timestamp or date string to localized Persian format.
     *
     * @param int|string $timestamp
     * @param string $format
     * @return string
     */
    function market_format_persian_date($timestamp = null, $format = 'j F Y') {
        if (null === $timestamp) {
            $timestamp = current_time('timestamp');
        } elseif (!is_numeric($timestamp)) {
            $timestamp = strtotime($timestamp);
        }

        // If WP-Parsidate plugin is installed and active
        if (function_exists('parsidate')) {
            return market_to_persian_numbers(parsidate($format, $timestamp));
        }

        // Native WordPress date_i18n fallback
        return market_to_persian_numbers(date_i18n($format, $timestamp));
    }
}
