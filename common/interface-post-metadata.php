<?php

namespace uk\org\brentso\concertmanagement\admin;

interface Interface_Post_Metadata {

	public function update_from_array( $post_id, $array_of_values );

	public function read( $post_id );

	public function get_key();
}
