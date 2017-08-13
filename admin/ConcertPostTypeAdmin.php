<?php

namespace uk\org\brentso\concertmanagement\admin;

use uk\org\brentso\concertmanagement\common;

require_once constant( 'CONCERT_PLUGIN_PATH' ) . 'vendor/autoload.php';

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
class ConcertPostTypeAdmin {

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

	protected $start_end_time_box;
	protected $pieces_box;

	function __construct( $loader ) {
		$this->loader = $loader;
		$this->load_dependencies();
	}

	private function load_dependencies() {
		$this->start_end_time_box = new StartEndTimeBox( $this->loader, 'Concert Time and Date' );
		$this->pieces_box = new PiecesBox( $this->loader, 'Concert Pieces' );

		$this->start_end_time_box->init();
		$this->pieces_box->init();
	}
}
