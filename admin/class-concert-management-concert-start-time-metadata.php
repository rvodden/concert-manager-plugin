<?php
require_once 'abstract_post_metadata.php';

class ConcertStartTimeMetaData extends AbstractPostMetadata {
    public function __construct() {
        parent::__construct('concert-start-time');
    }
}
?>