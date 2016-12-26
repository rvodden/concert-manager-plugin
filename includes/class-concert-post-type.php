<?php
namespace org\eu\brentso\concertmanagement\common;
use org\eu\brentso\concertmanagement\admin;
/**
 * Register all actions and filters for the plugin
 *
 * @link       http://brentso.org.uk
 * @since      0.0.1
 *
 * @package    concert_management
 * @subpackage concert_management/includes
 */

/**
 * Register the concert custom type for the plugin.
 *
 * TODO: write a description here if we need to
 *
 * @package concert_management
 * @subpackage concert_management/includes
 * @author Richard Vodden <richard@vodden.com>
 *        
 */
class ConcertManagementConcertPostType {
	
	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since 0.0.1
	 * @access protected
	 * @var ConcertManagementLoader $loader Maintains and registers all hooks for the plugin.
	 */
	protected $loader;
	protected $concert_post_type_admin;
	function __construct($loader) {
		$this->loader = $loader;
		$this->load_dependencies ();
		$this->define_hooks ();
		$this->define_admin_hooks ();
		$this->concert_post_type_admin = new admin\ConcertPostTypeAdmin ( $this->loader );
	}
	private function load_dependencies() {
		$concert_plugin_path = constant ( 'CONCERT_PLUGIN_PATH' );
		/**
		 * The class responsible for implementing the administrative functions of the
		 * concert post type
		 */
		require_once $concert_plugin_path . 'admin/class-concert-post-type-admin.php';
	}
	private function define_hooks() {
		$this->loader->add_action ( 'init', $this, 'create_concert_post_type' );
		error_log ( "Creating Concert Post Type Init Hook" );
	}
	private function define_admin_hooks() {
	}
	function create_concert_post_type() {
		error_log ( "Creating Concert Post Type" );
		$TEXT_DOMAIN = constant ( 'CONCERT_TEXT_DOMAIN' );
		
		$labels = array (
				'name' => _x ( 'Concerts', 'Post Type General Name', $TEXT_DOMAIN ),
				'singular_name' => _x ( 'Concert', 'Post Type Singular Name', $TEXT_DOMAIN ),
				'add_new_item' => __ ( 'Add New Concert', $TEXT_DOMAIN ),
				'add_new' => __ ( 'Add New', $TEXT_DOMAIN ),
				'edit_item' => __ ( 'Edit Concert', $TEXT_DOMAIN ),
				'update_item' => __ ( 'Update Concert', $TEXT_DOMAIN ),
				'search_items' => __ ( 'Search Concerts', $TEXT_DOMAIN ),
				'not_found' => __ ( 'Not Found', $TEXT_DOMAIN ),
				'not_found_in_trash' => __ ( 'Not found in Trash', $TEXT_DOMAIN )
		);
		
		$args = array (
				'labels' => $labels,
				'hierarchical' => false,
				'public' => true,
				'show_ui' => true,
				'show_in_menu' => true,
				'show_in_rest' => true,
				'menu_icon' => 'dashicons-tickets',
				'exclude_from_search' => false,
				'supports' => array (
						'title',
						'author',
						'thumbnail',
						'excerpt',
						'revisions',
						'page-attributes' 
				),
				'has_archive' => true,
				'rewrite' => array (
						'slug' => 'concert' 
				) 
		);
		
		register_post_type ( 'concert', $args );
	}
}
?>