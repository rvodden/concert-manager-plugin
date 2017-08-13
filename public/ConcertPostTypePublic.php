<?php

namespace uk\org\brentso\concertmanagement;

require_once constant( 'CONCERT_PLUGIN_PATH' ) . 'vendor/autoload.php';

/**
 * This class is responsible for displaying the post type on the public page
 * @author voddenr
 *
 */
class ConcertPostTypePublic {

	/**
	 * The loader that's responsible for maintaining and registering all hooks
	 * that power
	 * the plugin.
	 *
	 * @since 0.0.1
	 * @access protected
	 * @var common\Loader $loader Maintains and registers all hooks
	 *      for the plugin.
	 */
	protected $loader;

	protected $start_time_metadata_public;

	function __construct( $loader ) {
		$this->loader = $loader;
		$this->load_dependencies();
	}

	private function load_dependencies() {
		$this->start_time_metadata_public = new StartTimeMetadataPublic( $this->loader );
	}
}
