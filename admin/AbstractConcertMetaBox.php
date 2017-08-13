<?php

namespace uk\org\brentso\concertmanagement\admin;

require_once constant( 'CONCERT_PLUGIN_PATH' ) . 'vendor/autoload.php';

/*
 * Abstract class which implements a Metabox associated with the
 * concert post type.
 */
abstract class AbstractConcertMetaBox extends AbstractAutoDisplayMetaBox {

	function __construct( $loader, $title ) {
		parent::__construct( $loader, $title, 'concert' );
	}

}
