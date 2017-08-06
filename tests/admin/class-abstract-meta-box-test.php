<?php

namespace uk\org\brentso\concertmanagement\admin;

use uk\org\brentso\concertmanagement\common;
use uk\org\brentso\concertmanagement\tests\helpers;

require_once 'admin/class-abstract-meta-box.php';
require_once 'common/class-abstract-post-metadata.php';
require_once 'common/class-loader.php';

class Abstract_Meta_Box_Test extends helpers\Concert_Test_Case {

	private $under_test;

	function setUp() {
		\WP_Mock::setUp();
	}

	function test_define_admin_hooks() {
		$loader = $this->getMockBuilder( common\Loader::class )->setMethods( [ 'add_action' ] )->getMock();

		$this->under_test = $this->getMockForAbstractClass(
			Abstract_Meta_Box::class,
			array( $loader, 'Mock Title', 'mock_post_type' )
		);

		$this->under_test->expects( $this->once() )->method( 'configure_post_metadata' );

		$loader->expects( $this->exactly( 4 ) )->method( 'add_action' )->withConsecutive(
			[ 'add_meta_boxes_mock_post_type', $this->under_test, 'add', 10, 1 ],
			[ 'save_post', $this->under_test, 'save', 10, 2 ],
			[ 'admin_enqueue_scripts', $this->under_test, 'enqueue_scripts', 10, 1 ],
			[ 'admin_enqueue_scripts', $this->under_test, 'enqueue_styles', 10, 1 ]
		);

		$this->under_test->init();
	}

	function test_add() {
		$loader = $this->getMockBuilder( common\Loader::class )->setMethods( [ 'get_tag' ] )->getMock();

		$this->under_test = $this->getMockForAbstractClass(
			Abstract_Meta_Box::class,
			array( $loader, 'Mock Title', 'mock_post_type' )
		);
		$this->under_test->method( 'get_tag' )->willReturn( 'mock_tag' );

		\WP_Mock::userFunction( 'add_meta_box', array(
			'times' => 1,
			'args' => array(
				'mock_tag',
				'Mock Title',
				array( $this->under_test, 'display' ),
				'mock_post_type',
				'normal',
				'default',
			),
		));

		$this->under_test->add();
	}

	function test_styles_are_enqueued_if_on_post_type_edit_page() {
		$loader = $this->getMockBuilder( common\Loader::class )->setMethods( [ 'get_tag' ] )->getMock();

		$this->under_test = $this->getMockForAbstractClass(
			Abstract_Meta_Box::class,
			array( $loader, 'Mock Title', 'mock_post_type' )
		);
		$this->under_test->method( 'get_style_tag' )->willReturn( 'mock_post_type' );

		$screen = $this->getMockBuilder( \WP_Screen::class )->getMock();
		$screen->post_type = 'mock_post_type';

		\WP_Mock::userFunction('get_current_screen', array(
			'return' => $screen,
		));

		\WP_Mock::userFunction('wp_enqueue_style', array(
			'times' => '1',
		));

		$this->under_test->enqueue_styles( 'post.php' );
	}

	function test_styles_are_not_enqueued_if_not_on_post_type_edit_page() {
		$loader = $this->getMockBuilder( common\Loader::class )->setMethods( [ 'get_tag' ] )->getMock();

		$this->under_test = $this->getMockForAbstractClass(
			Abstract_Meta_Box::class,
			array( $loader, 'Mock Title', 'mock_post_type' )
		);
		$this->under_test->method( 'get_style_tag' )->willReturn( 'wrong_post_type' );

		$screen = $this->getMockBuilder( \WP_Screen::class )->getMock();
		$screen->post_type = 'wrong_post_type';

		\WP_Mock::userFunction('get_current_screen', array(
			'return' => $screen,
		));

		\WP_Mock::userFunction('wp_enqueue_style', array(
			'times' => '0',
		));

		$this->under_test->enqueue_styles( 'post.php' );
	}

	function test_scripts_are_enqueued_if_on_post_type_edit_page() {
		$loader = $this->getMockBuilder( common\Loader::class )->setMethods( [ 'get_tag' ] )->getMock();

		$this->under_test = $this->getMockForAbstractClass(
			Abstract_Meta_Box::class,
			array( $loader, 'Mock Title', 'mock_post_type' )
			);
		$this->under_test->method( 'get_style_tag' )->willReturn( 'mock_post_type' );

		$screen = $this->getMockBuilder( \WP_Screen::class )->getMock();
		$screen->post_type = 'mock_post_type';

		\WP_Mock::userFunction('get_current_screen', array(
			'return' => $screen,
		));

		\WP_Mock::userFunction('wp_enqueue_script', array(
			'times' => '1',
		));

		$this->under_test->enqueue_scripts( 'post.php' );
	}


	function tearDown() {
		\WP_Mock::tearDown();
	}
}
