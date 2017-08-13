<?php

namespace uk\org\brentso\concertmanagement\admin;
use uk\org\brentso\concertmanagement\common;

require_once constant( 'CONCERT_PLUGIN_PATH' ) . 'vendor/autoload.php';

class StartEndTimeBox extends AbstractConcertMetaBox {

	protected function configure_post_metadata() {
		$this->add_post_metadata( new common\StartTimeMetadata() );
		$this->add_post_metadata( new common\EndTimeMetadata() );
		$this->add_post_metadata( new common\StartDateMetadata() );
	}

	public function enqueue_scripts( $hook_suffix ) {
		error_log( 'Scripts are being enqueued' );

		wp_enqueue_script( 'jquery-ui-datepicker' );
		wp_enqueue_script(
			'jquery-ui-timepicker',
			'//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js'
		);
		parent::enqueue_scripts( $hook_suffix );
	}

	public function enqueue_styles( $hook_suffix ) {
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
		parent::enqueue_styles( $hook_suffix );
	}
}
