<?php

/**
 * Plugin Name: Oxygen Element Development
 * Plugin URI: https://breakdance.com/
 * Description: ALPHA - NOT TO BE USED IN PRODUCTION
 * Author: Breakdance
 * Author URI: https://breakdance.com/
 * License: GPLv2
 * Text Domain: breakdance
 * Domain Path: /languages/
 * Version: 0.0.1
 */

namespace OxygenElements;

use function Breakdance\Util\getDirectoryPathRelativeToPluginFolder;

add_action('breakdance_loaded', function () {
    if (defined('BREAKDANCE_MODE') && BREAKDANCE_MODE === 'oxygen') {
        \Breakdance\ElementStudio\registerSaveLocation(
            getDirectoryPathRelativeToPluginFolder(__DIR__) . '/elements',
            'OxygenElements',
            'element',
            'Oxygen Elements',
            true
        );
    }
}, 9);
