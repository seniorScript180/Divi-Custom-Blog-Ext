<?php

/**
 * Helper class with additional functions.
 *
 * @class CBR_CAdditionalFunctions
 */
final class CBR_CAdditionalFunctions {


    /**
     * Versioning & Caching
     */
    static public function set_theme_version() {

        if (defined('WP_DEBUG') && true === WP_DEBUG) {
            $version = time();
        } else {
            $version = wp_get_theme()->get('Version');
        }
        return $version;
    }

    static public function define_variables() {

        define('CBR_THEME_VERSION', self::set_theme_version());
        define('CBR_PARENT_THEME_DIR', get_template_directory());
        define('CBR_PARENT_THEME_URL', get_template_directory_uri());
        define('CBR_CHILD_THEME_DIR', get_stylesheet_directory());
        define('CBR_CHILD_THEME_URL', get_stylesheet_directory_uri());
        define('CBR_PLUGIN_FILE', plugin_dir_url(__FILE__));
        define('CBR_PLUGIN_DIR', plugin_dir_url(__DIR__));
    }



    /**
     * @method styles
     */
    static public function stylesheet($ver) {

        // Load parent theme
        //wp_enqueue_style( 'parent-style', NT_PARENT_THEME_URL . '/style.css' );

        // Load slick styles
        wp_enqueue_style('slick-css', CBR_PLUGIN_DIR . '/assets/css/slick.css', array(), '');
        wp_enqueue_style('slick-theme-css', CBR_PLUGIN_DIR . '/assets/css/slick-theme.css', array(), '');
        wp_enqueue_style('magnificent-popup', CBR_PLUGIN_DIR . '/assets/css/magnific-popup.css', array(), '');
    }

    /**
     * @method scripts
     */
    static public function javascript() {

        // Load swiper slider js
        wp_enqueue_script('slick-js', CBR_PLUGIN_DIR . '/assets/js/slick.min.js', array('jquery'), '', false);
        wp_enqueue_script('magnificent-popup', CBR_PLUGIN_DIR . '/assets/js/jquery.magnific-popup.min.js', array('jquery'), '', false);
        wp_enqueue_script('scripts', CBR_PLUGIN_DIR . '/assets/js/scripts.js', array('slick-js'), CBR_THEME_VERSION, false);
    }


    /**
     * Shortcode creating the Estimate reading time
     */
    static public function post_estimate_reading_time() {

        $defaults = array(
            'german_lang'   => 'lang="de-DE"' === get_language_attributes() ? TRUE : FALSE,
            'show_est_time' => 'on',
            'wpm' => 212
        );

        $moduleClassName     = 'cbr_reading_estimate';
        $args['stopwatch']   = '<svg width="32" height="100%" viewBox="0 0 256 256" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" xmlns:serif="http://www.serif.com/">
            <path class="icon" d="M204.323,89.183L215.554,77.953C217.976,75.531 218.817,72.124 218.078,69.018C217.916,67.523 217.261,66.071 216.114,64.924C215.805,64.615 215.474,64.342 215.127,64.105C211.389,60.795 205.68,60.934 202.108,64.507L190.785,75.83C175.948,63.734 157.603,55.842 137.507,53.931L137.507,43.702L160.46,43.702C164.233,43.702 167.294,40.64 167.294,36.868L167.294,9.532C167.294,5.753 164.233,2.698 160.46,2.698L97.246,2.698C93.467,2.698 90.412,5.753 90.412,9.532L90.412,36.868C90.412,40.64 93.467,43.702 97.246,43.702L118.491,43.702L118.491,53.959C67.994,58.765 28.339,101.305 28.339,153.045C28.339,207.997 73.047,252.698 127.999,252.698C182.951,252.698 227.659,207.997 227.659,153.045C227.659,128.732 218.848,106.49 204.323,89.183ZM127.999,76.849C170.008,76.849 204.188,111.029 204.188,153.044C204.188,195.047 170.008,229.227 127.999,229.227C85.99,229.227 51.81,195.047 51.81,153.044C51.81,111.029 85.99,76.849 127.999,76.849ZM127.999,166.998C133.247,166.998 137.507,162.739 137.507,157.49L137.507,97.68C137.507,92.432 133.247,88.172 127.999,88.172C122.741,88.172 118.491,92.432 118.491,97.68L118.491,157.49C118.491,162.739 122.741,166.998 127.999,166.998ZM111.992,18.548L145.715,18.548L145.715,27.851L111.992,27.851L111.992,18.548Z" />
        </svg>';
        $args['icon_color'] = '#000';

        $args = wp_parse_args($args, $defaults);

        /**
         * Divi carries a lot of additional code as content on each post and page
         * We need only the human readable content to calculate the estimate time
         * So we get rid of all those shortcodes in several levels
         * $word_count is the final variable result
         */
        $post_content = et_strip_shortcodes(et_delete_post_first_video(get_the_content()), true);
        $no_divi = preg_replace('/\[\/?et_pb.*?\]/', '', $post_content);
        $no_shortcodes = strip_shortcodes($no_divi);
        $no_tags = strip_tags($no_shortcodes);
        $word_count = str_word_count($no_tags);

        /**
         * The main calculation. Words / Words Per Minute
         * Result is in minutes in decimal format
         */
        $time = $word_count / $args['wpm'];

        /**
         * Hardcoded Translation
         * German & English
         * Because Polylang is not playing nice
         */
        if ($args['german_lang']) {
            $est_time_text = "Lesedauer";
            $time_text = "Min.";
        } else {
            $est_time_text = esc_html__('Est. reading time', 'custom-blog-ext');
            $time_text = esc_html__('min.', 'custom-blog-ext');
        }

        /**
         * Constructing the time for print
         * Because minutes is in decimal format
         * 1. Modulo 60
         * 2. Remaining seconds
         * 3. Modulo 60 
         */
        $minutes = floor($time % 60);
        $seconds = $time - (int)$time;
        $seconds = round($seconds * 60);

        return sprintf(
            '<span class="%1$s">
                <span class="dmn_estimate_text"> %2$s %3$s</span>
                <span>DEBUG: %4$s</span>
            </span>',
            $moduleClassName,
            $minutes,
            $time_text,
            $time
        );

    }

    /**
     * Shortcode for printing current Year
     */
    static public function year_shortcode() {

        $year = date('Y');

        return sprintf(
            '<span class="current-year check-class">%1$s</span>',
            $year
        );

    }
}

/**
 * Initialize Variables used on Methods
 */
CBR_CAdditionalFunctions::define_variables();

/**
 * Enqueue Assets
 */
//add_action('wp_enqueue_scripts', 'CBR_CAdditionalFunctions::fonts');
add_action('wp_enqueue_scripts', 'CBR_CAdditionalFunctions::stylesheet');
add_action('wp_enqueue_scripts', 'CBR_CAdditionalFunctions::javascript');

/**
 * Add Shortcodes
 */
add_shortcode('est_reading_time', array('CBR_CAdditionalFunctions', 'post_estimate_reading_time'));
add_shortcode('year', array('CBR_CAdditionalFunctions', 'year_shortcode'));
