<?php

namespace uk\org\brentso\concertmanagement\admin;

use uk\org\brentso\concertmanagement\common;

require_once constant( 'CONCERT_PLUGIN_PATH' ) . 'vendor/autoload.php';

class PiecesBox extends AbstractConcertMetaBox {

	protected function configure_post_metadata() {
		$this->add_post_metadata( new common\PiecesMetadata() );
	}

	public function enqueue_scripts( $hook_suffix ) {
		error_log( 'Scripts are being enqueued' );
		wp_enqueue_script( 'jquery-ui-dialog' );
		parent::enqueue_scripts( $hook_suffix );
	}

	public function enqueue_styles( $hook_suffix ) {
		error_log( 'Styles are being enqueued' );
		wp_enqueue_style(
			'jquery-ui-style',
			'//ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css',
			true
		);
		parent::enqueue_styles( $hook_suffix );
	}
}
