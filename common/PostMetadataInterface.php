<?php

namespace uk\org\brentso\concertmanagement\common;

require_once constant( 'CONCERT_PLUGIN_PATH' ) . 'vendor/autoload.php';

interface PostMetadataInterface {

	public function update_from_array( $post_id, $array_of_values );

	public function read( $post_id );

	public function get_key();
}
