<?php
namespace uk\org\brentso\concertmanagement\admin;
require_once 'abstract-post-metadata.php';

class StartTimeMetaData extends AbstractPostMetadata {
    public function __construct() {
        parent::__construct('concert-start-time');
    }
}
?>