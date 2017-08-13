<?php
namespace uk\org\brentso\concertmanagement\admin;

use uk\org\brentso\concertmanagement\tests\helpers;

require_once 'admin/Admin.php';

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

class Admin_Test extends helpers\Concert_Test_Case {

	private $plugin_name = 'concert-management';

	private $version_number = '0.0.1';

	private $undertest;

	function setUp() {
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

	function test_display_options_page() {
		$this->expectOutputString( "<h1>Concert Management Settings</h1>\n<h2>Section One</h2>\n" );

		$this->undertest = new Admin( $this->plugin_name, $this->version_number );

		$this->undertest->display_options_page();
	}

	function tearDown() {
		\WP_Mock::tearDown();
	}
}

