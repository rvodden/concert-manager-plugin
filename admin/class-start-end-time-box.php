<?php

namespace uk\org\brentso\concertmanagement\admin;

require_once 'class-abstract-concert-meta-box.php';
require_once constant( 'CONCERT_PLUGIN_PATH' ) . 'common/class-end-time-metadata.php';
require_once constant( 'CONCERT_PLUGIN_PATH' ) . 'common/class-start-time-metadata.php';
require_once constant( 'CONCERT_PLUGIN_PATH' ) . 'common/class-start-date-metadata.php';

class Start_End_Time_Box extends Abstract_Concert_Meta_Box {

	protected function configure_post_metadata() {
		$this->add_post_metadata( new Start_Time_Metadata() );
		$this->add_post_metadata( new End_Time_Metadata() );
		$this->add_post_metadata( new Start_Date_Metadata() );
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
