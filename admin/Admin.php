<?php

namespace uk\org\brentso\concertmanagement\admin;

require_once constant( 'CONCERT_PLUGIN_PATH' ) . 'vendor/autoload.php';

/**
 * The admin-specific functionality of the concert management plugin.
 *
 * @link       http://brentso.org.uk
 * @since      0.0.1
 *
 * @package    concert-management
 * @subpackage concert-management/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package concert-management
 * @subpackage concert-management/admin
 * @author Richard Vodden <richard.vodden@brentso.org.uk>
 */
class Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since 0.0.1
	 * @access private
	 * @var string $plugin_name The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since 0.0.1
	 * @access private
	 * @var string $version The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since 0.0.1
	 * @param string $plugin_name
	 *     The name of this plugin.
	 * @param string $version
	 *     The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since 0.0.1
	 */
	public function enqueue_styles() {
		$concert_plugin_url = constant( 'CONCERT_PLUGIN_URL' );
		wp_enqueue_style(
			$this->plugin_name,
			$concert_plugin_url . 'admin/css/concert-management-admin.css',
			array(),
			$this->version,
			'all'
		);
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since 0.0.1
	 */
	public function enqueue_scripts() {
		$concert_plugin_url = constant( 'CONCERT_PLUGIN_URL' );
		wp_enqueue_script(
			$this->plugin_name,
			$concert_plugin_url . 'admin/js/concert-management-admin.js',
			array( 'jquery' ),
			$this->version,
			false
		);
	}

	/**
	 * Register the options page for the admin area.
	 *
	 * @since 0.0.1
	 */
	public function add_options_page() {
		$this->plugin_screen_hook_suffix = add_options_page(
			__( 'Concert Management Settings', 'CONCERT_TEXT_DOMAIN' ),
			__( 'Concert Management', 'CONCERT_TEXT_DOMAIN' ),
			'manage_options',
			$this->plugin_name,
			array( $this, 'display_options_page' )
		);
	}

	/**
	 * Render the options page for plugin
	 *
	 * @since 0.0.1
	 */
	public function display_options_page() {
		include_once 'partials/admin-display.php';
	}

}
