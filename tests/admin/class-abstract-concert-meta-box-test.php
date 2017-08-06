<?php
namespace uk\org\brentso\concertmanagement\admin;

use uk\org\brentso\concertmanagement\common;
use uk\org\brentso\concertmanagement\tests\helpers;

require_once 'admin/class-abstract-concert-meta-box.php';

class Abstract_Concert_Meta_Box_Test extends helpers\Concert_Test_Case {

	private $under_test;

	function test_constructor_should_set_post_type_to_concert() {

		$loader = $this->getMockBuilder( common\Loader::class )->getMock();
		$this->under_test = $this->getMockForAbstractClass( Abstract_Concert_Meta_Box::class ,
			array( $loader, 'Mock Title', 'mock_post_type' )
		);

		$this->assertEquals( $this->under_test->get_post_type(), 'concert' );
	}
}
