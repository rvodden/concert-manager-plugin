<?php

namespace uk\org\brentso\concertmanagement\common;

use uk\org\brentso\concertmanagement\admin;
use uk\org\brentso\concertmanagement;

/**
 * Register all actions and filters for the plugin
 *
 * @link http://brentso.org.uk
 * @since 0.0.1
 *
 * @package concert_management
 * @subpackage concert_management/common
 */

/**
 * Register the concert custom type for the plugin.
 *
 * TODO: write a description here if we need to
 *
 * @package concert_management
 * @subpackage concert_management/common
 * @author Richard Vodden <richard@vodden.com>
 *
 */
class Concert_Post_Type {

	/**
	 * The loader that's responsible for maintaining and registering all hooks
	 * that power
	 * the plugin.
	 *
	 * @since 0.0.1
	 * @access protected
	 * @var ConcertManagementLoader $loader Maintains and registers all hooks
	 *      for the plugin.
	 */
	protected $loader;

	protected $concert_post_type_admin;

	protected $concert_post_type_public;

	function __construct( $loader ) {
		$this->loader = $loader;
		$this->load_dependencies();
		$this->define_hooks();
		$this->define_admin_hooks();
		$this->concert_post_type_admin = new admin\Concert_Post_Type_Admin( $this->loader );
		$this->concert_post_type_public = new concertmanagement\Concert_Post_Type_Public( $this->loader );
	}

	private function load_dependencies() {
		$concert_plugin_path = constant( 'CONCERT_PLUGIN_PATH' );
		/**
		 * The class responsible for implementing the administrative functions
		 * of the
		 * concert post type
		 */
		require_once $concert_plugin_path . 'admin/class-concert-post-type-admin.php';
		require_once $concert_plugin_path . 'public/class-concert-post-type-public.php';
	}

	private function define_hooks() {
		$this->loader->add_action( 'init', $this, 'create_concert_post_type' );
		error_log( 'Creating Concert Post Type Init Hook' );
	}

	private function define_admin_hooks() {
	}

	function create_concert_post_type() {
		error_log( 'Creating Concert Post Type' );

		$labels = array(
			'name' => _x( 'Concerts', 'Post Type General Name', 'CONCERT_TEXT_DOMAIN' ),
			'singular_name' => _x( 'Concert', 'Post Type Singular Name', 'CONCERT_TEXT_DOMAIN' ),
			'add_new_item' => __( 'Add New Concert', 'CONCERT_TEXT_DOMAIN' ),
			'add_new' => __( 'Add New', 'CONCERT_TEXT_DOMAIN' ),
			'edit_item' => __( 'Edit Concert', 'CONCERT_TEXT_DOMAIN' ),
			'update_item' => __( 'Update Concert', 'CONCERT_TEXT_DOMAIN' ),
			'search_items' => __( 'Search Concerts', 'CONCERT_TEXT_DOMAIN' ),
			'not_found' => __( 'Not Found', 'CONCERT_TEXT_DOMAIN' ),
			'not_found_in_trash' => __( 'Not found in Trash', 'CONCERT_TEXT_DOMAIN' ),
		);

		$args = array(
			'labels' => $labels,
			'hierarchical' => false,
			'public' => true,
			'show_ui' => true,
			'show_in_menu' => true,
			'show_in_rest' => true,
			'menu_icon' => 'dashicons-tickets',
			'exclude_from_search' => false,
			'supports' => array( 'title', 'author', 'thumbnail', 'excerpt', 'revisions', 'page-attributes' ),
			'has_archive' => true,
			'rewrite' => array(
				'slug' => 'concert',
			),
		);

		register_post_type( 'concert', $args );
	}
}
