<?php
require_once 'abstract_post_metadata.php';

class ConcertStartDateMetaData extends AbstractPostMetadata {
    public function __construct() {
        parent::__construct('concert-start-date');
    }
}
?>