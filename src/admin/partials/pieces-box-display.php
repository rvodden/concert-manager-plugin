<?php

namespace uk\org\brentso\concertmanagement\admin;

$pieces = isset($metadata['concert-pieces']) ? $metadata['concert-pieces'] : null;

$concert_pieces_table = new PiecesTable();
$concert_pieces_table->prepare_items();
$concert_pieces_table->display();

?>