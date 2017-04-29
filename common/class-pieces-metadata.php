<?php
namespace uk\org\brentso\concertmanagement\admin;
require_once 'abstract-post-metadata.php';

class PiecesMetaData extends AbstractPostMetadata {
    public function __construct() {
        parent::__construct('concert-pieces');
    }
}
?>