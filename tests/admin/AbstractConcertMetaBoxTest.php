<?php
namespace uk\org\brentso\concertmanagement\admin;

use uk\org\brentso\concertmanagement\common;
use uk\org\brentso\concertmanagement\tests\helpers;

require_once 'admin/AbstractConcertMetaBox.php';

class AbstractConcertMetaBoxTest extends helpers\Concert_Test_Case {

	private $under_test;

	function test_constructor_should_set_post_type_to_concert() {

		$loader = $this->getMockBuilder( common\Loader::class )->getMock();
		$this->under_test = $this->getMockForAbstractClass( AbstractConcertMetaBox::class ,
			array( $loader, 'Mock Title', 'mock_post_type' )
		);

		$this->assertEquals( $this->under_test->get_post_type(), 'concert' );
	}
}
