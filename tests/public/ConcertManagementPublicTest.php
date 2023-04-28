<?php
namespace uk\org\brentso\concertmanagement;

use WP_Mock;
use uk\org\brentso\concertmanagement\tests\helpers\ConcertTestCase;

require_once 'public/ConcertManagementPublic.php';

/**
 * ConcertManagementPublic test case.
 */
class ConcertManagementPublicTest extends ConcertTestCase {

	/**
	 *
	 * @var ConcertManagementPublic
	 */
	private $concertManagementPublic;

	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() : void {
		parent::setUp();
		WP_Mock::setUp();
	}

	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown() : void {
		parent::tearDown();
		WP_Mock::setUp();
	}

	/**
	 * Tests ConcertManagementPublic->enqueueStyles()
	 */
	public function testEnqueueStyles() {
		$this->concertManagementPublic = new concertManagementPublic( 'Mock Plugin', '0.0.1' );
		WP_Mock::userFunction( 'wp_enqueue_style', array(
			'times' => 1,
		) );
		$this->concertManagementPublic->enqueueStyles();
	}

	/**
	 * Tests ConcertManagementPublic->enqueueScripts()
	 */
	public function testEnqueueScripts() {
		$this->concertManagementPublic = new concertManagementPublic( 'Mock Plugin', '0.0.1' );
		WP_Mock::userFunction( 'wp_enqueue_script', array(
			'times' => 1,
		) );
		$this->concertManagementPublic->enqueueScripts();
	}
}
