<?php

namespace uk\org\brentso\concertmanagement\admin;

require_once 'class-abstract-concert-meta-box.php';
require_once constant( 'CONCERT_PLUGIN_PATH' ) . 'common/class-pieces-metadata.php';

class Pieces_Box extends Abstract_Concert_Meta_Box {

	protected function configure_post_metadata() {
		$this->add_post_metadata( new Pieces_Metadata() );
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
