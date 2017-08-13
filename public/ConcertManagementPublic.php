<?php

namespace uk\org\brentso\concertmanagement;

require_once constant( 'CONCERT_PLUGIN_PATH' ) . 'vendor/autoload.php';

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://brentso.org.uk
 * @since      0.0.1
 *
 * @package    concert_management
 * @subpackage concert_management/public
 */
/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public stylesheet and JavaScript.
 *
 * @package    concert_management
 * @subpackage concert_management/public
 * @author     Richard Vodden <richard@vodden.com>
 */
class ConcertManagementPublic {

	/**
	 * The ID of this plugin.
	 *
	 * @since    0.0.1
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    0.0.1
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    0.0.1
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    0.0.1
	 */
	public function enqueue_styles() {
		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The ConcertManagementLoader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_style(
			$this->plugin_name,
			constant( 'CONCERT_PLUGIN_URL' ) . 'public/css/concert-management-public.css',
			array(),
			$this->version,
			'all'
		);
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    0.0.1
	 */
	public function enqueue_scripts() {
		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_script(
			$this->plugin_name,
			constant( 'CONCERT_PLUGIN_URL' ) . 'public/js/concert-management-public.js',
			array( 'jquery' ),
			$this->version,
			false
		);
	}
}
