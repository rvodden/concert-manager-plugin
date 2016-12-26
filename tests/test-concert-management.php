<?php
/**
 * Class SampleTest
 *
 * @package Concert_Management
 */

/**
 * Sample test case.
 */
class ConcertManagementTest extends WP_UnitTestCase {

	/**
	 * A single example test.
	 */
	function test_sample() {
		// Replace this with some actual testing code.
		$this->assertTrue( true );
	}
	
	function test_sample_string() {
	
	    $string = 'Unit tests are sweet';
	
	    $this->assertEquals( 'Unit gays are sweet', $string );
	}
}
