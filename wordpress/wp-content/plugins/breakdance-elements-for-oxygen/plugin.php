<?php

/**
 * Plugin Name: Breakdance Elements for Oxygen
 * Plugin URI: https://breakdance.com/
 * Description: Your favorite Breakdance elements, available in Oxygen. 
 * Author: Breakdance
 * Author URI: https://breakdance.com/
 * Text Domain: breakdance
 * Domain Path: /languages/
 * Version: 1.0.0
 */

namespace EssentialElements;

use function Breakdance\Util\getDirectoryPathRelativeToPluginFolder;

define('BREAKDANCE_ELEMENTS_FOR_OXYGEN_VERSION', '1.0.0');
define('BREAKDANCE_ELEMENTS_FOR_OXYGEN_EDD_ITEM_ID', 4785316);

add_action('plugins_loaded', function () {
    if (!is_oxygen_active()) {
        add_action('admin_notices', '\EssentialElements\display_missing_dependency_notice');
        return;
    }

    \Breakdance\ElementStudio\registerSaveLocation(
        getDirectoryPathRelativeToPluginFolder(__DIR__) . '/elements',
        'EssentialElements',
        'element',
        'Breakdance Elements for Oxygen',
        true,
        true
    );

    \Breakdance\ElementStudio\registerSaveLocation(
        getDirectoryPathRelativeToPluginFolder(__DIR__) . '/elements-manual',
        'EssentialElements',
        'element',
        'Breakdance Elements for Oxygen Manual Elements',
        true,
        true
    );

    \Breakdance\Elements\registerCategory('breakdance-elements-for-oxygen', 'Breakdance');
});

add_action('init', function () {
    if (!is_oxygen_active()) return;

    if (!function_exists('get_plugin_data')) {
        require_once(ABSPATH . 'wp-admin/includes/plugin.php');
    }

    $extension = \Breakdance\Extensions\registerExtension(
        'breakdance_elements',
        path_join(dirname(__FILE__), 'plugin.php'),
        BREAKDANCE_ELEMENTS_FOR_OXYGEN_EDD_ITEM_ID
    );

    $extension->listenForPluginUpdates();
});

function is_oxygen_active()
{
    return defined('__BREAKDANCE_PLUGIN_FILE__') && defined('BREAKDANCE_MODE') && BREAKDANCE_MODE === 'oxygen';
}

function display_missing_dependency_notice()
{
    ?>
  <div class="notice notice-error">
    <p>
      <b>Breakdance Elements for Oxygen:</b> Oxygen must be installed. <a href="https://oxygenbuilder.com/" target="_blank">Download Now</a>
    </p>
  </div>
    <?php
}

add_filter('breakdance_global_settings_enable_default_control_sections', '__return_true', 1001);
add_filter('breakdance_global_settings_css_template_enable_default_template', '__return_true', 1001);
add_filter('breakdance_disable_default_api_keys', '__return_false', 1001);
add_filter('body_class', fn($classes) => array_merge($classes, ['breakdance']));
