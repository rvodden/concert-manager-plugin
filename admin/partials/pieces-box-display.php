<?php

namespace uk\org\brentso\concertmanagement\admin;

$pieces = isset($metadata['concert-pieces']) ? $metadata['concert-pieces'] : null;

$concert_pieces_table = new PiecesTable($_GET['post']);
$concert_pieces_table->prepare_items();
$concert_pieces_table->display();

?>