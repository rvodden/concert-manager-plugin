<?php

namespace uk\org\brentso\concertmanagement\admin;

require_once 'class-abstract-post-metadata.php';

class Start_Date_Metadata extends Abstract_Post_Metadata {

	public function __construct() {
		parent::__construct( 'concert-start-date' );
	}
}
