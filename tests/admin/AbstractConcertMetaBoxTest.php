<?php
namespace uk\org\brentso\concertmanagement\admin;

use uk\org\brentso\concertmanagement\common;
use uk\org\brentso\concertmanagement\tests\helpers;

class AbstractConcertMetaBoxTest extends helpers\ConcertTestCase {

	private $under_test;

	public function testConstructorShouldSetPostTypeToConcert() {

		$loader = $this->getMockBuilder( common\Loader::class )->getMock();
		$this->under_test = $this->getMockForAbstractClass(
			AbstractConcertMetaBox::class,
			array( $loader, 'Mock Title', 'mock_post_type' )
		);

		$this->assertEquals( $this->under_test->get_post_type(), 'concert' );
	}
}
