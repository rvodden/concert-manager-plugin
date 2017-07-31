<?php
namespace uk\org\brentso\concertmanagement\admin;

use uk\org\brentso\concertmanagement\common;

require_once 'admin/class-abstract-meta-box.php';
require_once 'common/class-loader.php';

class Abstract_Meta_Box_Test extends \PHPUnit_Framework_TestCase {
	private $underTest;

	function setUp() {
		\WP_Mock::setUp();
	}

	function test_define_admin_hooks() {

		$loader = new common\Loader();

		$this->underTest = $this->getMockForAbstractClass(Abstract_Meta_Box::class,
			array(
				$loader,
				"Mock Title",
				"mock_post_type",
			)
			);

		\WP_Mock::expectActionAdded( 'add_meta_boxes_mock_post_type', array($this->underTest, 'add') );
		\WP_Mock::expectActionAdded( 'save_post', array($this->underTest, 'save') , 10 , 2 );
		\WP_Mock::expectActionAdded( 'admin_enqueue_scripts', array($this->underTest, 'enqueue_styles') );

		$this->underTest->init();
		$loader->run();

		\WP_Mock::assertHooksAdded();
	}

	function tearDown() {
		\WP_Mock::tearDown();
	}
}
