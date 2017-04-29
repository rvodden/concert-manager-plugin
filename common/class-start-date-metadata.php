<?php
namespace uk\org\brentso\concertmanagement\admin;
require_once 'abstract-post-metadata.php';

class StartDateMetaData extends AbstractPostMetadata {
    public function __construct() {
        parent::__construct('concert-start-date');
    }
}
?>