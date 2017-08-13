<?php

namespace uk\org\brentso\concertmanagement;

require_once constant( 'CONCERT_PLUGIN_PATH' ) . 'vendor/autoload.php';

class StartTimeMetadataPublic {

	protected $loader;

	protected $start_date_metadata;

	protected $key;

	function __construct( common\Loader $loader ) {
		$this->loader = $loader;
		$this->key = 'concert-start-time';
		$this->start_date_metadata = new common\StartDateMetadata();
		$this->define_hooks();
	}

	public function define_hooks() {
		$this->loader->add_shortcode( $this->key, $this, 'shortcode_concert_start_time' );
	}

	public function display() {
		$metadata[ $this->key ] = $this->value();
		require 'partials/start-time-meta-data-public-display.php';
	}

	public function value() {
		return $this->start_date_metadata->read();
	}

	public function shortcode_concert_start_time( $attributes, $content = null ) {
		$processed_attributes = shortcode_atts( array(
			'id' => 'latest',
		), $attributes );

		$response = get_post_meta( $processed_attributes['id'], 'concert-start-time', true );
		error_log( serialize( $response ) );
		return $response;
	}
}
