<?php
namespace uk\org\brentso\concertmanagement\admin;

require_once 'admin/class-admin.php';

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

class Admin_Test extends \PHPUnit_Framework_TestCase {

	private $plugin_name = 'concert-management';

	private $version_number = '0.0.1';

	private $undertest;

	function setUp() {
		\WP_Mock::setUp();
	}

	function test_enqueue_styles() {

		$this->undertest = new Admin( $this->plugin_name, $this->version_number );

		\WP_Mock::wpFunction( 'wp_enqueue_style', array(
			'times' => 1,
		) );

		$this->undertest->enqueue_styles();

	}

	function test_enqueue_scripts() {

		$this->undertest = new Admin( $this->plugin_name, $this->version_number );

		\WP_Mock::wpFunction( 'wp_enqueue_script', array(
			'times' => 1,
		) );

		$this->undertest->enqueue_scripts();

	}

	function test_add_options_page() {

		$this->undertest = new Admin( $this->plugin_name, $this->version_number );

		\WP_Mock::wpFunction( 'add_options_page', array(
			'times' => 1,
		) );

		$this->undertest->add_options_page();

	}


	function tearDown() {
		\WP_Mock::tearDown();
	}
}

