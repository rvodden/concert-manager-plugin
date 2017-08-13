<?php

namespace uk\org\brentso\concertmanagement\common;

interface PostMetadataInterface {

	public function updateFromArray( $post_id, $array_of_values );

	public function read( $post_id );

	public function getKey();
}
