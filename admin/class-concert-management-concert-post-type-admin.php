<?php
/**
 * Admin specific code for the concert post type.
 *
 * @link       http://brentso.org.uk
 * @since      0.0.1
 *
 * @package    concert_management
 * @subpackage concert_management/includes
 */

/**
 * Admin specific code for the concert post type.
 *
 * @package concert_management
 * @subpackage concert_management/includes
 * @author Richard Vodden <richard@vodden.com>
 *        
 */
class ConcertManagementConcertPostTypeAdmin {
	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since 0.0.1
	 * @access protected
	 * @var ConcertManagementLoader $loader Maintains and registers all hooks for the plugin.
	 */
	protected $loader;
	function __construct($loader) {
		$this->loader = $loader;
		$this->define_admin_hooks ();
	}
	private function define_admin_hooks() {
		$this->loader->add_action ( 'add_meta_boxes', $this, 'add_concert_start_end_time_box' );
		$this->loader->add_action ( 'admin_enqueue_scripts', $this, 'enqueue_scripts' );
		$this->loader->add_action ( 'admin_enqueue_scripts', $this, 'enqueue_styles' );
	}
	public function enqueue_scripts() {
		error_log ( "Scripts are being enqueued" );
		$concert_plugin_url = constant ( 'CONCERT_PLUGIN_URL' );
		
		wp_enqueue_script ( 'jquery-ui-datepicker' );
		wp_enqueue_script ( 'jquery-ui-timepicker', '//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js' );
		wp_enqueue_script ( 'concert-management-concert-post-type-admin', $concert_plugin_url . 'admin/js/concert-management-concert-post-type-admin.js', array (
				'jquery-ui-datepicker',
				'jquery-ui-timepicker' 
		) );
	}
	public function enqueue_styles() {
		error_log ( "Styles are being enqueued" );
		$concert_plugin_url = constant ( 'CONCERT_PLUGIN_URL' );
		wp_enqueue_style ( 'jquery-ui-style', '//ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css', true );
		wp_enqueue_style ( 'jquery-ui-timepicker-style', '//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css' );
		wp_enqueue_style ( 'concert-management-concert-post-type-admin-style', $concert_plugin_url . 'admin/css/concert-management-concert-post-type-admin.css' );
	}
	function add_concert_start_end_time_box() {
		add_meta_box ( 'concert-start-end-time-box', 'Start and End Time', array (
				$this,
				'concert_start_end_time_box_content' 
		), 'concert', 'normal', 'default' );
	}
	function concert_start_end_time_box_content($concert, $args) {
		$concert_plugin_path = constant ( 'CONCERT_PLUGIN_PATH' );
		
		$default_start_date = esc_attr ( get_post_meta ( $concert->ID, 'concert_start_date', true ) );
		$default_start_time = esc_attr ( get_post_meta ( $concert->ID, 'concert_start_time', true ) );
		$default_end_time = esc_attr ( get_post_meta ( $concert->ID, 'concert_end_time', true ) );
		
		wp_nonce_field ( plugin_basename ( __FILE__ ), 'concert_management_concert_start_end_time_box_nonce' );
		require $concert_plugin_path . '/admin/partials/concert-management-concert-start-end-time-box-display.php';
	}
	function concert_start_end_time_box_save($concert_id) {
		// do nothing if autosaving
		if (defined ( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE) {
			return;
		}
		
		// do nothing if nonce saved
		if (! wp_verify_nonce ( $_POST ['concert_management_concert_start_end_time_box_nonce'], plugin_basename ( __FILE__ ) )) {
			return;
		}
		
		if (! current_user_can ( 'edit_concert', $concert_id )) {
			return;
		}
		
		update_post_meta ( $concert_id, 'start_date', $concert_start_date );
	}
}
?>