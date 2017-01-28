<?php
namespace uk\org\brentso\concertmanagement\admin;
require_once 'abstract-meta-box.php';

/*
 * Abstract class which implements a Metabox associated with the
 * concert post type.
 */
abstract class AbstractConcertMetaBox extends AbstractMetaBox {
    function __construct ($loader, $title)
    {
        parent::__construct($loader, $title, "concert");
    }
}