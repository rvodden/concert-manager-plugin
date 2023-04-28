<?php
namespace uk\org\brentso\concertmanagement\admin;

use uk\org\brentso\concertmanagement\common;
use uk\org\brentso\concertmanagement\tests\helpers;

class AbstractConcertMetaBoxTest extends helpers\ConcertTestCase {

	private $under_test;

	public function setUp() : void {
		$loader = $this->getMockBuilder( common\Loader::class )->getMock();
		$this->under_test = new class( $loader, 'Mock Title', 'mock_post_type' ) extends AbstractConcertMetaBox {
			public function configurePostMetadata() {}
		};
	}

	public function testConstructorShouldSetPostTypeToConcert() {

		$this->assertEquals( $this->under_test->getPostType(), 'concert' );
	}
}
