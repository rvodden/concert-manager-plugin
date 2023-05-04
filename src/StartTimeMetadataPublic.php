<?php

namespace uk\org\brentso\concertmanagement;

use uk\org\brentso\concertmanagement\common;

class StartTimeMetadataPublic {

	protected $loader;

	protected $start_date_metadata;

	protected $key;

	public function __construct( common\Loader $loader ) {
		$this->loader = $loader;
		$this->key = 'concert-start-time';
		$this->start_date_metadata = new common\StartDateMetadata();
		$this->defineHooks();
	}

	public function defineHooks() {
		$this->loader->addShortcode( $this->key, $this, 'shortcodeConcertStartTime' );
	}

	public function display() {
		$metadata[ $this->key ] = $this->value();
		require 'partials/start-time-meta-data-public-display.php';
	}

	public function value() {
		return $this->start_date_metadata->read();
	}

	public function shortcodeConcertStartTime( $attributes, $content = null ) {
		$processed_attributes = shortcode_atts( array(
			'id' => 'latest',
		), $attributes );

		$response = get_post_meta( $processed_attributes['id'], 'concert-start-time', true );
		error_log( serialize( $response ) );
		return $response;
	}
}
