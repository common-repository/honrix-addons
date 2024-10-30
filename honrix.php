<?php

/**
 * Plugin Name: Honrix Addons
 * Author: Honar Systems
 * Version: 1.0.2
 * Description: Honrix addons is a plugin to add more functionalities to the WordPress themes.
 * Plugin URI: https://honarsystems.com/honrix-addons
 * Text Domain: honrix-addon
 */

if (!defined('ABSPATH')) {
    exit;
}

define('HONRIX_ADDONS_ROOT', plugin_dir_url(__FILE__));

require_once('inc/settings.php');

function honrix_elementor_widget_categories($elements_manager)
{

    $elements_manager->add_category(
        'honrix-addon',
        [
            'title' => esc_html__('Honrix Addon', 'honrix-addon'),
            'icon' => 'fa fa-plug',
        ]
    );
}
add_action('elementor/elements/categories_registered', 'honrix_elementor_widget_categories');

add_action('elementor/widgets/widgets_registered', function () {
    include_once('widgets/team_member/member.php');
    include_once('widgets/menu/menu.php');
    include_once('widgets/logo/logo.php');
});

if (!function_exists('hooya_enqueue_scripts')) {
    function hooya_enqueue_scripts()
    {
        /* javascript */
        wp_enqueue_script('honrix-addons-script', esc_url(HONRIX_ADDONS_ROOT . '/assets/js/custom.js'), array('jquery'), '1.0.0', true);
    }

    add_action('wp_enqueue_scripts', 'hooya_enqueue_scripts');
}
