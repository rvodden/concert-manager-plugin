<?php
namespace uk\org\brentso\concertmanagement\common;

use uk\org\brentso\concertmanagement\ConcertManagementPublic;
use uk\org\brentso\concertmanagement\admin\Admin;

/**
 *
 * @author voddenr
 *
 */
class ConcertManagementPluginFactory {

	public static function createPlugin() {
		
		$plugin_name = 'concert-management';
		$plugin_version = '0.0.1';
		
		$loader = new Loader();
		$concertManagementPublic = new ConcertManagementPublic( $plugin_name, $plugin_version );
		$admin = new Admin( $plugin_name, $plugin_version );
		$i18n = new I18n();
		$concertPostType = new ConcertPostType( $loader );
		
		$concertManagementPlugin = new ConcertManagementPlugin(
			$loader,
			$concertManagementPublic,
			$admin,
			$i18n,
			$concertPostType
		);
		
		return $concertManagementPlugin;
	}
}
