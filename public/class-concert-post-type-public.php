<?php

namespace uk\org\brentso\concertmanagement;

require_once 'class-start-time-metadata-public.php';

/**
 * This class is responsible for displaying the post type on the public page
 * @author voddenr
 *
 */
class Concert_Post_Type_Public {

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

	protected $start_time_metadata_public;

	function __construct( $loader ) {
		$this->loader = $loader;
		$this->load_dependencies();
	}

	private function load_dependencies() {
		$this->start_time_metadata_public = new Start_Time_Metadata_Public( $this->loader );
	}
}
