<?php

namespace uk\org\brentso\concertmanagement\admin;

/*
 * Abstract class which implements a Metabox associated with the
 * concert post type.
 */
abstract class AbstractConcertMetaBox extends AbstractAutoDisplayMetaBox
{

    public function __construct( $loader, $title )
    {
        parent::__construct($loader, $title, 'concert');
    }
}
