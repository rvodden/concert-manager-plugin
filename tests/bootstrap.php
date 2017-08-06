<?php
/**
 * PHPUnit bootstrap file
 *
 * @package Concert_Management
 */
require_once 'vendor/autoload.php';
require_once 'tests/helpers/class-concert-test-case.php';

WP_Mock::activateStrictMode();
WP_Mock::setUsePatchwork( true );
WP_Mock::bootstrap();

ini_set( 'error_log', '/dev/null' );

define( 'CONCERT_PLUGIN_URL', 'http://wordpress.dev/wp-content/plugins/concert-management/' );
define( 'CONCERT_PLUGIN_PATH', './' );

//Mock out global functions

