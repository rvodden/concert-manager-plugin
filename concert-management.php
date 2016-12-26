<?php
use org\eu\brentso\concertmanagement\admin;
use org\eu\brentso\concertmanagement\common;
use org\eu\brentso\concertmanagement;
/*
 Plugin Name: Concert Manager
 Plugin URI: http://www.vodden.com/concertmanager
 Description: This is to make maintaining musical ensembles websites much more easily!
 Version: 0.0.1
 Author: Richard Vodden
 Author URI: http://www.vodden.com/
 License: GPL
 License URI: https://www.gnu.org/licenses/gpl-3.0.html
 Text Domain: concert-management
 Domain Path: /languages
 */

define("CONCERT_TEXT_DOMAIN", "concert-management");
define('CONCERT_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('CONCERT_PLUGIN_URL', plugin_dir_url(__FILE__) );

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Setup extra debug logging
if ( defined(WP_DEBUG) ) {
	
	function tl_save_error() {
		update_option( 'plugin_error',  ob_get_contents() );
	}
	
	add_action( 'activated_plugin', 'tl_save_error' );
	
	error_log( ob_get_contents() ); 
}


/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-plugin-name-activator.php
 */
function activate_concert_management() {
	require_once constant('CONCERT_PLUGIN_PATH') . 'includes/class-activator.php';
	common\ConcertManagementActivator::activate();
}


/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-plugin-name-deactivator.php
 */
function deactivate_concert_management() {
	require_once constant('CONCERT_PLUGIN_PATH') . 'includes/class-deactivator.php';
	common\ConcertManagementDeactivator::deactivate();
}
register_activation_hook( __FILE__, 'activate_concert_management' );
register_deactivation_hook( __FILE__, 'deactivate_concert_management' );


/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require constant('CONCERT_PLUGIN_PATH') . 'includes/class-concert-management.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    0.0.1
 */
function run_concert_management() {
	$plugin = new concertmanagement\ConcertManagement();
	$plugin->run();
}

run_concert_management();