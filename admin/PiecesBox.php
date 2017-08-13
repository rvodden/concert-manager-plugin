<?php

namespace uk\org\brentso\concertmanagement\admin;

use uk\org\brentso\concertmanagement\common;

class PiecesBox extends AbstractConcertMetaBox {

	protected function configurePostMetadata() {
		$this->addPostMetadata( new common\PiecesMetadata() );
	}

	public function enqueueScripts( $hook_suffix ) {
		error_log( 'Scripts are being enqueued' );
		wp_enqueue_script( 'jquery-ui-dialog' );
		parent::enqueueScripts( $hook_suffix );
	}

	public function enqueueStyles( $hook_suffix ) {
		error_log( 'Styles are being enqueued' );
		wp_enqueue_style(
			'jquery-ui-style',
			'//ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css',
			true
		);
		parent::enqueueStyles( $hook_suffix );
	}
}
