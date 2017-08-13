<?php

namespace uk\org\brentso\concertmanagement\admin;

use WP_Scripts;
use uk\org\brentso\concertmanagement\common;
use uk\org\brentso\concertmanagement\tests\helpers;

class AbstractMetaBoxTest extends helpers\ConcertTestCase {

	private $under_test;

	public function setUp() {
		\WP_Mock::setUp();
	}

	public function testDefineAdminHooks() {
		$loader = $this->getMockBuilder( common\Loader::class )->setMethods( [ 'addAction' ] )->getMock();

		$this->under_test = $this->getMockForAbstractClass(
			AbstractMetaBox::class,
			array( $loader, 'Mock Title', 'mock_post_type' )
		);

		$this->under_test->expects( $this->once() )->method( 'configurePostMetadata' );

		$loader->expects( $this->exactly( 4 ) )->method( 'addAction' )->withConsecutive(
			[ 'add_meta_boxes_mock_post_type', $this->under_test, 'add', 10, 1 ],
			[ 'save_post_mock_post_type', $this->under_test, 'save', 10, 2 ],
			[ 'admin_enqueue_scripts', $this->under_test, 'enqueueScripts', 10, 1 ],
			[ 'admin_enqueue_scripts', $this->under_test, 'enqueueStyles', 10, 1 ]
		);

		$this->under_test->init();
	}

	public function testAdd() {
		$loader = $this->getMockBuilder( common\Loader::class )->setMethods( [ 'getTag' ] )->getMock();

		$this->under_test = $this->getMockForAbstractClass(
			AbstractMetaBox::class,
			array( $loader, 'Mock Title', 'mock_post_type' )
		);
		$this->under_test->method( 'getTag' )->willReturn( 'mock_tag' );

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

	public function testStylesAreEnqueuedIfOnPostTypeEditPage() {
		$loader = $this->getMockBuilder( common\Loader::class )->setMethods( [ 'getTag' ] )->getMock();

		$this->under_test = $this->getMockForAbstractClass(
			AbstractMetaBox::class,
			array( $loader, 'Mock Title', 'mock_post_type' )
		);
		$this->under_test->method( 'getStyleTag' )->willReturn( 'mock_post_type' );

		$screen = $this->getMockBuilder( WP_Scripts::class )->getMock();
		$screen->post_type = 'mock_post_type';

		\WP_Mock::userFunction('get_current_screen', array(
			'return' => $screen,
		));

		\WP_Mock::userFunction('wp_enqueue_style', array(
			'times' => '1',
		));

		$this->under_test->enqueueStyles( 'post.php' );
	}

	public function testStylesAreNotEnqueuedIfNotOnPostTypeEditPage() {
		$loader = $this->getMockBuilder( common\Loader::class )->setMethods( [ 'getTag' ] )->getMock();

		$this->under_test = $this->getMockForAbstractClass(
			AbstractMetaBox::class,
			array( $loader, 'Mock Title', 'mock_post_type' )
		);
		$this->under_test->method( 'getStyleTag' )->willReturn( 'wrong_post_type' );

		$screen = $this->getMockBuilder( WP_Scripts::class )->getMock();
		$screen->post_type = 'wrong_post_type';

		\WP_Mock::userFunction('get_current_screen', array(
			'return' => $screen,
		));

		\WP_Mock::userFunction('wp_enqueue_style', array(
			'times' => '0',
		));

		$this->under_test->enqueueStyles( 'post.php' );
	}

	public function testScriptsAreEnqueuedIfOnPostTypeEditPage() {
		$loader = $this->getMockBuilder( common\Loader::class )->setMethods( [ 'getTag' ] )->getMock();

		$this->under_test = $this->getMockForAbstractClass(
			AbstractMetaBox::class,
			array( $loader, 'Mock Title', 'mock_post_type' )
		);
		$this->under_test->method( 'getStyleTag' )->willReturn( 'mock_post_type' );

		$screen = $this->getMockBuilder( WP_Scripts::class )->getMock();
		$screen->post_type = 'mock_post_type';

		\WP_Mock::userFunction('get_current_screen', array(
			'return' => $screen,
		));

		\WP_Mock::userFunction('wp_enqueue_script', array(
			'times' => '1',
		));

		$this->under_test->enqueueScripts( 'post.php' );
	}

	public function testThatAddedPostMetadataIsLoaded() {
		$loader = $this->getMockBuilder( common\Loader::class )->setMethods( [ 'getTag' ] )->getMock();

		$this->under_test = $this->getMockForAbstractClass(
			AbstractMetaBox::class,
			array( $loader, 'Mock Title', 'mock_post_type' )
		);

		$metadata_mock = $this->getMockForAbstractClass( common\PostMetadataInterface::class );
		$metadata_mock->method( 'getKey' )->willReturn( 'mock_key' );
		$metadata_mock->method( 'read' )->willReturn( 'mock_value' );

		$metadata_array = array(
			'mock_key' => 'mock_value',
		);

		$this->under_test->addPostMetadata( $metadata_mock );

		$metadata_return = $this->under_test->loadPostMetadata( 1 );

		$this->assertEquals( $metadata_array, $metadata_return );
	}

	public function testThatSavedPostMetadataHasNewValueWhenLoaded() {
		$loader = $this->getMockBuilder( common\Loader::class )->setMethods( [ 'get_tag' ] )->getMock();

		$this->under_test = $this->getMockForAbstractClass(
			AbstractMetaBox::class,
			array( $loader, 'Mock Title', 'mock_post_type' )
		);

		$metadata_mock = $this->getMockForAbstractClass( common\PostMetadataInterface::class );
		$metadata_mock->method( 'getKey' )->willReturn( 'mock_key' );
		$metadata_mock->method( 'read' )->willReturn( 'mock_value' );
		$metadata_mock->expects( $this->once() )
			->method( 'updateFromArray' )
			->willReturn( 'mock_value' );

		$metadata_array = array(
			'mock_key' => 'mock_value_2',
		);

		$this->under_test->addPostMetadata( $metadata_mock );

		$this->under_test->savePostMetadata( 1, $metadata_array );

		$metadata_return = $this->under_test->loadPostMetadata( 1 );
	}


	public function tearDown() {
		\WP_Mock::tearDown();
	}
}
