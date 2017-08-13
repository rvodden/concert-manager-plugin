<?php

namespace uk\org\brentso\concertmanagement\common;

require_once constant( 'CONCERT_PLUGIN_PATH' ) . 'vendor/autoload.php';

class StartTimeMetadata extends AbstractPostMetadata {

	public function __construct() {
		parent::__construct( 'concert-start-time' );
	}
}
