<?php
namespace uk\org\brentso\concertmanagement\common;

use uk\org\brentso\concertmanagement\tests\helpers\ConcertTestCase;
use uk\org\brentso\concertmanagement\admin\Admin;
use uk\org\brentso\concertmanagement\ConcertManagementPublic;

/**
 * ConcertManagementPlugin test case.
 */
class ConcertManagementPluginTest extends ConcertTestCase {

	/**
	 *
	 * @var ConcertManagementPlugin
	 */
	private $concertManagementPlugin;
	
	public function setUp() : void {
		\WP_Mock::setUp();
	}

	/**
	 * Tests ConcertManagementPlugin->init()
	 */
	public function testInit() {
		$loader = $this->getMockBuilder( Loader::class )->onlyMethods( [ 'addAction' ] )->getMock();
		$admin = $this->getMockBuilder( Admin::class )->setConstructorArgs( [ 'Mock Plugin', '0.0.1' ] )->getMock();
		$concertManagementPublic = $this
			->getMockBuilder( ConcertManagementPublic::class )
			->setConstructorArgs( [ 'Mock Plugin', '0.0.1' ] )
			->getMock();
		$i18n = $this->getMockBuilder( i18n::class )->getMock();
		$postType = $this->getMockBuilder( PostTypeInterface::class )->getMock();
		
		$this->concertManagementPlugin = new ConcertManagementPlugin(
			$loader,
			$concertManagementPublic,
			$admin,
			$i18n,
			$postType
		);
		
		$loader->expects( $this->exactly( 6 ) )->method( 'addAction' )->willReturnCallback( fn( $arg1, $arg2, $arg3) =>
			match([$arg1, $arg2, $arg3]) {
				[ 'plugins_loaded', $i18n, 'loadPluginTextdomain' ] => null,
				[ 'admin_enqueue_scripts', $admin, 'enqueueStyles' ] => null,
				[ 'admin_enqueue_scripts', $admin, 'enqueueScripts' ] => null,
				[ 'admin_menu', $admin, 'addOptionsPage' ] => null,
				[ 'wp_enqueue_scripts', $concertManagementPublic, 'enqueueStyles' ] => null,
				[ 'wp_enqueue_scripts', $concertManagementPublic, 'enqueueScripts' ] => null
			}
		);
		
		$this->concertManagementPlugin->init();
	}

	/**
	 * Tests ConcertManagementPlugin->run()
	 */
	public function testRun() {
		$loader = $this->getMockBuilder( Loader::class )->onlyMethods( [ 'run' ] )->getMock();
		$admin = $this->getMockBuilder( Admin::class )->setConstructorArgs( [ 'Mock Plugin', '0.0.1' ] )->getMock();
		$concertManagementPublic = $this
			->getMockBuilder( ConcertManagementPublic::class )
			->setConstructorArgs( [ 'Mock Plugin', '0.0.1' ] )->getMock();
		$i18n = $this->getMockBuilder( i18n::class )->getMock();
		$postType = $this->getMockBuilder( PostTypeInterface::class )->getMock();
		
		$this->concertManagementPlugin = new ConcertManagementPlugin(
			$loader,
			$concertManagementPublic,
			$admin,
			$i18n,
			$postType
		);
		
		$loader->expects( $this->exactly( 1 ) )->method( 'run' );
		
		$this->concertManagementPlugin->run();
	}
	
	public function tearDown() : void {
		\WP_Mock::tearDown();
	}
}
