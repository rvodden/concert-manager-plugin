<?php

namespace uk\org\brentso\concertmanagement\admin;

require_once 'class-start-end-time-box.php';
require_once 'class-pieces-box.php';

/**
 * Admin specific code for the concert post type.
 *
 * @link http://brentso.org.uk
 * @since 0.0.1
 *
 * @package concert_management
 * @subpackage concert_management/common
 */

/**
 * Admin specific code for the concert post type.
 *
 * @package concert_management
 * @subpackage concert_management/common
 * @author Richard Vodden <richard@vodden.com>
 *
 */
class Concert_Post_Type_Admin {

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

	protected $start_end_time_box;

	protected $pieces_box;

	function __construct( $loader ) {
		$this->loader = $loader;
		$this->load_dependencies();
	}

	private function load_dependencies() {
		$this->start_end_time_box = new Start_End_Time_Box( $this->loader, 'Concert Time and Date' );
		$this->pieces_box = new Pieces_Box( $this->loader, 'Concert Pieces' );

		$this->start_end_time_box->init();
		$this->pieces_box->init();
	}
}
