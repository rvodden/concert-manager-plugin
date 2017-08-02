<?php

namespace uk\org\brentso\concertmanagement\admin;

use uk\org\brentso\concertmanagement\common;

/**
 * Meta Box interface for adding meta-boxes to custom post types.
 *
 * @link       http://brentso.org.uk
 * @since      0.0.1
 *
 * @package    concert_management
 * @subpackage concert_management/admin
 */

/**
 * Meta Box interface for adding meta-boxes to custom post types.
 *
 * @package concert_management
 * @subpackage concert_management/admin
 * @author Richard Vodden <richard@vodden.com>
 *
 */
interface Interface_Meta_Box {

	/**
	 * Registers the events necessary to add the metabox to the admin page.
	 *
	 * @since 0.0.1
	 * @access protected
	 * @var ConcertManagementLoader $loader Maintains and registers all hooks
	 *      for the plugin.
	 */
	public function add();

	/**
	 * Generates the html necessary to be displayed inside the meta-box
	 *
	 * @since 0.0.1
	 * @access protected
	 * @var ConcertManagementLoader $loader Maintains and registers all hooks
	 *      for the plugin.
	 */
	public function display( $post );

	/**
	 * Saves the data which has been entered into the meta-box.
	 *
	 * @since 0.0.1
	 * @access protected
	 * @var ConcertManagementLoader $loader Maintains and registers all hooks
	 *      for the plugin.
	 */
	public function save( $id, $post );

	/**
	 * Enqueues dependend scripts
	 *
	 * @since 0.0.1
	 * @access protected
	 * @var ConcertManagementLoader $loader Maintains and registers all hooks
	 *      for the plugin.
	 */
	public function enqueue_scripts( $hook_suffix );

	/**
	 * Enqueues dependend styles
	 *
	 * @since 0.0.1
	 * @access protected
	 * @var ConcertManagementLoader $loader Maintains and registers all hooks
	 *      for the plugin.
	 */
	public function enqueue_styles( $hook_suffix );

	/**
	 * Adds post metadata to the meta box
	 *
	 */
	function add_post_metadata( common\Interface_Post_Metadata $post_metadatum );

	/**
	 * Load post metadata and return it in an array
	 *
	 */
	function load_post_metadata( $post_id );

	/**
	 * Save post metadata and return it in an array
	 *
	 */
	function save_post_metadata( $post_id, $array_of_post_metadata );
}
