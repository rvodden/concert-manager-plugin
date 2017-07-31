<?php

namespace uk\org\brentso\concertmanagement\admin;

require_once 'interface-meta-box.php';
require_once constant( 'CONCERT_PLUGIN_PATH' ) . 'common/interface-post-metadata.php';

/**
 * This abstract meta box class implements sensible defaults for location of
 * css and js files and loads them.
 * By default a class with name
 *
 * ExampleMetaBox
 *
 * will automatically load:
 *
 * - admin/js/example_meta_box.js
 * - admin/css/example_meta_box.css
 *
 *
 * @since 0.0.1
 */
abstract class Abstract_Meta_Box implements Interface_Meta_Box {

	/**
	 * The loader that's responsible for maintaining and registering all hooks
	 * that power
	 * the plugin.
	 *
	 * @since 0.0.1
	 * @access protected
	 * @var ConcertManagement_Loader $loader Maintains and registers all hooks
	 *      for the plugin.
	 */
	// TODO: this is turning into a god class - need to split it up into bits.
	protected $loader;

	/**
	 * This is the title of the metabox used at the top of the metabox display
	 * and when the metabox is folded.
	 *
	 * @since 0.0.1
	 * @access protected
	 * @var ConcertManagement_Loader $loader Maintains and registers all hooks
	 *      for the plugin.
	 */
	protected $title;

	/**
	 * This is the post type to which the meta box pertains.
	 * This field is
	 * used to ensure that the box specific style and scripts are only loaded
	 * on the appropriate post type.
	 *
	 * @since 0.0.1
	 * @access protected
	 * @var ConcertManagement_Loader $loader Maintains and registers all hooks
	 *      for the plugin.
	 */
	protected $post_type;

	/**
	 * Collection of metadata belonging to the box
	 *
	 * @var array
	 */
	protected $post_metadata = array();

	/**
	 *
	 * @param unknown $loader
	 * @param unknown $title
	 */
	function __construct( $loader, $title, $post_type ) {
		$this->set_title( $title );
		$this->loader = $loader;
		$this->post_type = $post_type;
		error_log( 'Post Type : ' . $this->get_post_type() );
	}

	public function init() {
		$this->configure_post_metadata();
		$this->define_admin_hooks();
	}

	protected abstract function configure_post_metadata();

	/* returns the url for the style sheets for this display box */
	protected abstract function get_style_url();

	/* returns the tags for the style sheets for this display box */
	protected abstract function get_style_tag();

	/* returns the url for the javascript for this display box */
	protected abstract function get_script_url();

	/* returns the tags for the javascript for this display box */
	protected abstract function get_script_tag();

	/* returns the tags for the javascript for this post type box */
	protected abstract function get_tag();

	/* returns the nonce name for this meta box */
	protected abstract function get_nonce_name();

	/* returns the nonce name for this meta box */
	protected abstract function get_display_file_path();

	protected function define_admin_hooks() {
		$this->loader->add_action( "add_meta_boxes_{$this->post_type}", $this, 'add' );
		$this->loader->add_action( 'save_post', $this, 'save', 10, 2 );

		$this->loader->add_action( 'admin_enqueue_scripts', $this, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_enqueue_scripts', $this, 'enqueue_styles' );
	}

	public function add() {
		add_meta_box(
			$this->get_tag(),
			$this->get_title(),
			array( $this, 'display' ),
			$this->get_post_type(),
			'normal',
			'default'
		);
	}

	/*
	 * Displays the metabox, with the associated data from the post supplied
	 */
	function display( $post ) {
		error_log( 'Displaying post number : ' . $post->ID );
		$metadata = $this->load_post_metadata( $post->ID );
		isset( $metadata ) ? error_log( implode( '|', $metadata ) ) : error_log( 'No metadata' );
		wp_nonce_field( plugin_basename( __FILE__ ), $this->get_nonce_name() );
		require $this->get_display_file_path();
	}

	/*
	 * Checks that the admin page which is being saved is the appropriate post
	 * type and if so enqueues the necessary scripts to save this metabox
	 */
	function save( $post_id, $post ) {
		if ( get_post_type( $post_id ) == $this->post_type ) {
			error_log( 'Saving post' );
			// do nothing if autosaving
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return;
			}

			// do nothing if nonce mismatch
			if ( ! wp_verify_nonce( $_POST[ $this->get_nonce_name() ], plugin_basename( __FILE__ ) ) ) {
				error_log( 'Nonce verification failed' );
				return;
			}

			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				error_log( 'Current user doesn\'t have edit concert features' );
				return;
			}

			$this->save_post_metadata( $post_id, $_POST );
		}
	}

	/*
	 * Checks that the admin page which is being laoded is appropriate
	 * and if so enqueues the necessary scripts for this metabox
	 */
	public function enqueue_scripts( $hook_suffix ) {
		if ( $this->on_post_type_edit_page( $hook_suffix ) ) {
			wp_enqueue_script( $this->get_script_tag(), $this->get_script_url() );
		}
	}

	/*
	 * Checks that the admin page which is being laoded is appropriate
	 * and if so enqueues the necessary styles for this metabox
	 */
	public function enqueue_styles( $hook_suffix ) {
		if ( $this->on_post_type_edit_page( $hook_suffix ) ) {
			wp_enqueue_style( $this->get_style_tag(), $this->get_style_url() );
		}
	}

	/*
	 * Check that we are on the edit page which pertains to the post type
	 * which this meta box is associated with.
	 */
	private function on_post_type_edit_page( $hook_suffix ) {
		if ( 'post.php' == $hook_suffix || 'post-new.php' == $hook_suffix ) {
			$screen = get_current_screen();
			if ( is_object( $screen ) && ( $this->get_post_type() == $screen->post_type ) ) {
				return true;
			}
		}

		return false;
	}

	protected function set_title( $title ) {
		$this->title = $title;
	}

	protected function get_title() {
		return $this->title;
	}

	protected function get_post_type() {
		return $this->post_type;
	}

	public function add_post_metadata( Interface_Post_Metadata $post_metadatum ) {
		// this is horrid PHP notation for "add post_metadatum on the end of post_metadata
		$this->post_metadata[] = $post_metadatum;
	}

	public function load_post_metadata( $post_id ) {
		error_log( 'Loading post metadata from ' . $post_id );
		foreach ( $this->post_metadata as $post_metadatum ) {
			$key = $post_metadatum->get_key();
			$value = $post_metadatum->read( $post_id );
			error_log( 'Loading post (' . $post_id . ') metadata for ' . $key . ' : ' . $value );
			$metadata_array[ $key ] = $value;
		}

		return isset( $metadata_array ) ? $metadata_array : null;
	}

	public function save_post_metadata( $post_id, $metadata_array ) {
		error_log( 'Received metadata : ' . json_encode( $metadata_array ) );
		foreach ( $this->post_metadata as $post_metadatum ) {
			$post_metadatum->update_from_array( $post_id, $metadata_array );
		}
	}
}
