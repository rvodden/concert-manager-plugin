<?php

namespace uk\org\brentso\concertmanagement\common;

require_once 'class-abstract-post-metadata.php';

class Start_Time_Metadata extends Abstract_Post_Metadata {

	public function __construct() {
		parent::__construct( 'concert-start-time' );
	}
}
