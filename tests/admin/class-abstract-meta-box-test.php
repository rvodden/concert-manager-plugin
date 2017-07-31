<?php

namespace uk\org\brentso\concertmanagement\admin;

use uk\org\brentso\concertmanagement\common;

require_once 'admin/class-abstract-meta-box.php';
require_once 'common/class-loader.php';

class Abstract_Meta_Box_Test extends \PHPUnit_Framework_TestCase {

	private $under_test;

	function setUp() {

	}

	function test_define_admin_hooks() {
		$loader = $this->getMockBuilder( common\Loader::class )->setMethods( [ 'add_action' ] )->getMock();

		$this->under_test = $this->getMockForAbstractClass(
			Abstract_Meta_Box::class,
			array( $loader, 'Mock Title', 'mock_post_type' )
		);

		$loader->expects( $this->exactly( 4 ) )->method( 'add_action' )->withConsecutive(
			[ 'add_meta_boxes_mock_post_type', $this->under_test, 'add', 10, 1 ],
			[ 'save_post', $this->under_test, 'save', 10, 2 ],
			[ 'admin_enqueue_scripts', $this->under_test, 'enqueue_scripts', 10, 1 ],
			[ 'admin_enqueue_scripts', $this->under_test, 'enqueue_styles', 10, 1 ]
		);

		$this->under_test->init();
	}

	function tearDown() {

	}
}
