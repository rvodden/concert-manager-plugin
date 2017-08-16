<?php
namespace uk\org\brentso\concertmanagement\admin;

use uk\org\brentso\concertmanagement\tests\helpers;

/**
 * TestAdmin
 *
 * THe bootstrapping code should already have spun the plugin up,
 * which means we just need to check that the appropriate things have
 * been enqueued. Not really a unit test, more integration, but its a test
 * and so its staying here.
 *
 * @package uk\org\brentso\concertmanagement\admin
 */

class AdminTest extends helpers\ConcertTestCase {

	private $plugin_name = 'concert-management';

	private $version_number = '0.0.1';

	private $undertest;

	public function setUp() {
		\WP_Mock::setUp();

		\WP_Mock::userFunction( '__', array(
			'return_arg' => 0,
		) );
		\WP_Mock::userFunction( 'esc_attr', array(
			'return_arg' => 0,
		) );
		\WP_Mock::userFunction( 'esc_html', array(
			'return_arg' => 0,
		) );
	}

	public function testEnqueueStyles() {

		$this->undertest = new Admin( $this->plugin_name, $this->version_number );

		\WP_Mock::userFunction( 'wp_enqueue_style', array(
			'times' => 1,
		) );

		$this->undertest->enqueueStyles();
	}

	public function testEnqueueScripts() {

		$this->undertest = new Admin( $this->plugin_name, $this->version_number );

		\WP_Mock::userFunction( 'wp_enqueue_script', array(
			'times' => 1,
		) );

		$this->undertest->enqueueScripts();
	}

	public function testAddOptionsPage() {

		$this->undertest = new Admin( $this->plugin_name, $this->version_number );

		\WP_Mock::userFunction( 'add_options_page', array(
			'times' => 1,
		) );

		$this->undertest->addOptionsPage();
	}

	public function testDisplayOptionsPage() {
		$this->expectOutputString( "<h1>Concert Management Settings</h1>\n<h2>Section One</h2>\n" );

		$this->undertest = new Admin( $this->plugin_name, $this->version_number );

		$this->undertest->displayOptionsPage();
	}

	public function tearDown() {
		\WP_Mock::tearDown();
	}
}
