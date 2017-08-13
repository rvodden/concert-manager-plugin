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
interface MetaBoxInterface {

	/**
	 * Registers the events necessary to add the metabox to the admin page.
	 *
	 * @since 0.0.1
	 * @access protected
	 * @var common\Loader $loader Maintains and registers all hooks
	 *      for the plugin.
	 */
	public function add();

	/**
	 * Generates the html necessary to be displayed inside the meta-box
	 *
	 * @since 0.0.1
	 * @access protected
	 * @var common\Loader $loader Maintains and registers all hooks
	 *      for the plugin.
	 */
	public function display( $post );

	/**
	 * Saves the data which has been entered into the meta-box.
	 *
	 * @since 0.0.1
	 * @access protected
	 * @var common\Loader $loader Maintains and registers all hooks
	 *      for the plugin.
	 */
	public function save( $id, $post );

	/**
	 * Enqueues dependend scripts
	 *
	 * @since 0.0.1
	 * @access protected
	 * @var common\Loader $loader Maintains and registers all hooks
	 *      for the plugin.
	 */
	public function enqueueScripts( $hook_suffix );

	/**
	 * Enqueues dependend styles
	 *
	 * @since 0.0.1
	 * @access protected
	 * @var common\Loader $loader Maintains and registers all hooks
	 *      for the plugin.
	 */
	public function enqueueStyles( $hook_suffix );

	/**
	 * Adds post metadata to the meta box
	 *
	 */
	public function addPostMetadata( common\PostMetadataInterface $post_metadatum );

	/**
	 * Load post metadata and return it in an array
	 *
	 */
	public function loadPostMetadata( $post_id );

	/**
	 * Save post metadata and return it in an array
	 *
	 */
	public function savePostMetadata( $post_id, $array_of_post_metadata );
}
