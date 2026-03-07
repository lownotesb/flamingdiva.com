<?php

namespace Breakdance\CLI;

// Only load WP-CLI commands when WP-CLI is available
if ( ! defined( 'WP_CLI' ) || ! WP_CLI ) {
    return;
}

require_once __DIR__ . '/element-i18n-command.php';

\WP_CLI::add_command( 'breakdance i18n', 'Breakdance\CLI\ElementI18nCommand' );

