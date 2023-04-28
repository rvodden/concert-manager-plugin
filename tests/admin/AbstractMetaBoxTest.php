<?php

declare(strict_types=1);

namespace uk\org\brentso\concertmanagement\admin;

use WP_Scripts;
use uk\org\brentso\concertmanagement\common;
use uk\org\brentso\concertmanagement\tests\helpers;

class MockMetaBox extends AbstractMetaBox {
	protected $calls;

	public function __construct($loader, $title, $post_type)
	{
		$this->calls = 0;
		parent::__construct($loader, $title, $post_type);
	}

	public function getCalls()
	{
		return $this->calls;
	}
	
	protected function configurePostMetadata()
	{
	}	
	
	protected function getStyleUrl()
	{
	}

	protected function getStyleTag()
	{
	}

	protected function getScriptUrl()
	{
	}

	protected function getScriptTag()
	{
	}

	protected function getTag()
	{
	}

	protected function getNonceName()
	{
	}

	protected function getDisplayFilePath()
	{
	}
}

class AbstractMetaBoxTest extends helpers\ConcertTestCase
{
	private $loader;


	public function setUp(): void
	{
		\WP_Mock::setUp();
		$this->loader = $this->getMockBuilder(common\Loader::class)->onlyMethods(['addAction'])->getMock();
	}

	public function testDefineAdminHooks()
	{
		$under_test = new class($this->loader, 'Mock Title', 'mock_post_type') extends MockMetaBox
		{

			protected function configurePostMetadata()
			{
				$this->calls++;
			}

		};

		$this->loader->expects($this->exactly(4))->method('addAction')->willReturnCallback(
			fn ($arg1, $arg2, $arg3, $arg4, $arg5) =>
			match ([$arg1, $arg2, $arg3, $arg4, $arg5]) {
				['add_meta_boxes_mock_post_type', $under_test, 'add', 10, 1] => null,
				['save_post_mock_post_type', $under_test, 'save', 10, 2] => null,
				['admin_enqueue_scripts', $under_test, 'enqueueScripts', 10, 1] => null,
				['admin_enqueue_scripts', $under_test, 'enqueueStyles', 10, 1] => null
			}
		);

		$under_test->init();
		$this->assertEquals($under_test->getCalls(), 1);
	}

	public function testAdd()
	{

		$under_test = new class($this->loader, 'Mock Title', 'mock_post_type') extends MockMetaBox {
			protected function getTag() {
				return 'mock_tag';
			}
		};

		\WP_Mock::userFunction('add_meta_box', array(
			'times' => 1,
			'args' => array(
				'mock_tag',
				'Mock Title',
				array($under_test, 'display'),
				'mock_post_type',
				'normal',
				'default',
			),
		));

		$under_test->add();
	}

	public function testStylesAreEnqueuedIfOnPostTypeEditPage()
	{
		$under_test = new class($this->loader, 'Mock Title', 'mock_post_type') extends MockMetaBox {
			protected function getStyleTag() {
				return 'mock_post_type';
			}			
		};

		$screen = $this->getMockBuilder(WP_Scripts::class)->getMock();
		$screen->post_type = 'mock_post_type';

		\WP_Mock::userFunction('get_current_screen', array(
			'return' => $screen,
		));

		\WP_Mock::userFunction('wp_enqueue_style', array(
			'times' => '1',
		));

		$under_test->enqueueStyles('post.php');
	}

	public function testStylesAreNotEnqueuedIfNotOnPostTypeEditPage()
	{
		$under_test = new class($this->loader, 'Mock Title', 'mock_post_type') extends MockMetaBox {
			protected function getStyleTag() {
				return 'wrong_post_type';
			}
		}; 

		$screen = $this->getMockBuilder(WP_Screen::class)->getMock();
		$screen->post_type = 'wrong_post_type';

		\WP_Mock::userFunction('get_current_screen', array(
			'return' => $screen,
		));

		\WP_Mock::userFunction('wp_enqueue_style', array(
			'times' => '0',
		));

		$under_test->enqueueStyles('post.php');
	}

	public function testScriptsAreEnqueuedIfOnPostTypeEditPage()
	{
		$under_test = new class($this->loader, 'Mock Title', 'mock_post_type') extends MockMetaBox {
			protected function getStyleTag() {
				return 'mock_post_type';
			}
		};

		$screen = $this->getMockBuilder(WP_Scrreen::class)->getMock();
		$screen->post_type = 'mock_post_type';

		\WP_Mock::userFunction('get_current_screen', array(
			'return' => $screen,
		));

		\WP_Mock::userFunction('wp_enqueue_script', array(
			'times' => '1',
		));

		$under_test->enqueueScripts('post.php');
	}

	public function testThatAddedPostMetadataIsLoaded()
	{
		$under_test = new MockMetaBox($this->loader, 'Mock Title', 'mock_post_type');

		$metadata_mock = $this->getMockBuilder(common\PostMetadataInterface::class)->getMock();
		$metadata_mock->method('getKey')->willReturn('mock_key');
		$metadata_mock->method('read')->willReturn('mock_value');

		$metadata_array = array(
			'mock_key' => 'mock_value',
		);

		$under_test->addPostMetadata($metadata_mock);

		$metadata_return = $under_test->loadPostMetadata(1);

		$this->assertEquals($metadata_array, $metadata_return);
	}

	public function testThatSavedPostMetadataHasNewValueWhenLoaded()
	{
		$under_test = new MockMetaBox($this->loader, 'Mock Title', 'mock_post_type');

		$metadata_mock = $this->getMockBuilder(common\PostMetadataInterface::class)->getMock();
		$metadata_mock->method('getKey')->willReturn('mock_key');
		$metadata_mock->method('read')->willReturn('mock_value');
		$metadata_mock->expects($this->once())
			->method('updateFromArray')
			->willReturn('mock_value');

		$metadata_array = array(
			'mock_key' => 'mock_value_2',
		);

		$under_test->addPostMetadata($metadata_mock);
		$under_test->savePostMetadata(1, $metadata_array);

		$metadata_return = $under_test->loadPostMetadata(1);
		// assert metadata is correct
	}


	public function tearDown(): void
	{
		\WP_Mock::tearDown();
	}
}
