<?php
namespace uk\org\brentso\concertmanagement\admin;

use uk\org\brentso\concertmanagement\common;

require_once 'admin/class-abstract-meta-box.php';
require_once 'common/class-loader.php';

class Abstract_Meta_Box_Test extends \PHPUnit_Framework_TestCase {
	private $under_test;

	function setUp() {
		\WP_Mock::setUp();
	}

	function test_define_admin_hooks() {

		$loader = new common\Loader();

		$this->under_test = $this->getMockForAbstractClass(Abstract_Meta_Box::class,
			array(
				$loader,
				'Mock Title',
				'mock_post_type',
			)
		);

		\WP_Mock::expectActionAdded( 'add_meta_boxes_mock_post_type', array( $this->under_test, 'add' ) );
		\WP_Mock::expectActionAdded( 'save_post', array( $this->under_test, 'save' ) , 10 , 2 );
		\WP_Mock::expectActionAdded( 'admin_enqueue_scripts', array( $this->under_test, 'enqueue_styles' ) );

		$this->under_test->init();
		$loader->run();

		\WP_Mock::assertHooksAdded();
	}

	function tearDown() {
		\WP_Mock::tearDown();
	}
}
