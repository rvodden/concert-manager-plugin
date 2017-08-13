<?php
namespace uk\org\brentso\concertmanagement\admin;

use uk\org\brentso\concertmanagement\common;

class StartEndTimeBox extends AbstractConcertMetaBox {

	protected function configurePostMetadata() {
		$this->addPostMetadata( new common\StartTimeMetadata() );
		$this->addPostMetadata( new common\EndTimeMetadata() );
		$this->addPostMetadata( new common\StartDateMetadata() );
	}

	public function enqueueScripts( $hook_suffix ) {
		error_log( 'Scripts are being enqueued' );

		wp_enqueue_script( 'jquery-ui-datepicker' );
		wp_enqueue_script(
			'jquery-ui-timepicker',
			'//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js'
		);
		parent::enqueueScripts( $hook_suffix );
	}

	public function enqueueStyles( $hook_suffix ) {
		error_log( 'Styles are being enqueued' );
		wp_enqueue_style(
			'jquery-ui-style',
			'//ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css',
			true
		);
		wp_enqueue_style(
			'jquery-ui-timepicker-style',
			'//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css'
		);
		parent::enqueueStyles( $hook_suffix );
	}
}
