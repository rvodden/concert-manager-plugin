<?php
namespace org\eu\brentso\concertmanagement\admin;
require_once 'abstract-post-metadata.php';

class EndTimeMetaData extends AbstractPostMetadata {
    public function __construct() {
        parent::__construct('concert-end-time');
    }
}
?>