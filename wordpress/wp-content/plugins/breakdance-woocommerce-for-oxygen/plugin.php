<?php

/**
 * Plugin Name: Breakdance WooCommerce for Oxygen
 * Plugin URI: https://breakdance.com/
 * Description: The Woo integration for Breakdance, available in Oxygen. 
 * Author: Breakdance
 * Author URI: https://breakdance.com/
 * Text Domain: breakdance
 * Domain Path: /languages/
 * Version: 0.3.0
 */

namespace BreakdanceWooForOxygen;

define('BREAKDANCE_WOOCOMMERCE_FOR_OXYGEN_VERSION', '0.3.0');
define('BREAKDANCE_WOOCOMMERCE_FOR_OXYGEN_EDD_ITEM_ID', 4785317);

add_action('plugins_loaded', function () {
    if (!is_oxygen_active()) {
        add_action('admin_notices', '\BreakdanceWooForOxygen\display_missing_dependency_notice');
    }
});

add_action('init', function () {
    if (!is_oxygen_active()) return;

    if (!function_exists('get_plugin_data')) {
        require_once(ABSPATH . 'wp-admin/includes/plugin.php');
    }

    $extension = \Breakdance\Extensions\registerExtension(
        'breakdance_woocommerce',
        path_join(dirname(__FILE__), 'plugin.php'),
        BREAKDANCE_WOOCOMMERCE_FOR_OXYGEN_EDD_ITEM_ID
    );

    $extension->listenForPluginUpdates();
});

add_filter('breakdance_woo_integration_enabled', '__return_true', 1001);

function is_oxygen_active()
{
    return defined('__BREAKDANCE_PLUGIN_FILE__') && defined('BREAKDANCE_MODE') && BREAKDANCE_MODE === 'oxygen';
}

function display_missing_dependency_notice()
{
    ?>
    <div class="notice notice-error">
        <p>
            <b>Breakdance WooCommerce for Oxygen:</b> Oxygen must be installed. <a href="https://oxygenbuilder.com/" target="_blank">Download Now</a>
        </p>
    </div>
    <?php
}