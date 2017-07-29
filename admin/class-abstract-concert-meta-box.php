<?php

namespace uk\org\brentso\concertmanagement\admin;

require_once 'class-abstract-meta-box.php';

/*
 * Abstract class which implements a Metabox associated with the
 * concert post type.
 */
abstract class Abstract_Concert_Meta_Box extends Abstract_Meta_Box {

	function __construct( $loader, $title ) {
		parent::__construct( $loader, $title, 'concert' );
	}
}
