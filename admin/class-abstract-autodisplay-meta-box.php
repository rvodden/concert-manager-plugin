<?php

namespace uk\org\brentso\concertmanagement\admin;

use ReflectionClass;

require_once 'class-abstract-meta-box.php';

abstract class Abstract_Autodisplay_Meta_Box extends Abstract_Meta_Box {



	protected function get_style_url() {
		$concert_plugin_path = constant( 'CONCERT_PLUGIN_URL' );
		$underscored_class_name = $this->convert_from_camel_case_to_dashes( $this->get_unqualified_class_name() );
		return $concert_plugin_path . 'admin/css/' . $underscored_class_name . '.css';
	}

	protected function get_style_tag() {
		return $this->convert_from_camel_case_to_dashes( $this->get_unqualified_class_name() ) . '-style';
	}

	protected function get_tag() {
		return $this->convert_from_camel_case_to_dashes( $this->get_unqualified_class_name() );
	}

	protected function get_unqualified_class_name() {
		$reflect = new ReflectionClass( $this );
		return $reflect->getShortName();
	}

	protected function get_script_url() {
		$concert_plugin_path = constant( 'CONCERT_PLUGIN_URL' );
		$underscored_class_name = $this->convert_from_camel_case_to_dashes( $this->get_unqualified_class_name() );
		return $concert_plugin_path . 'admin/js/' . $underscored_class_name . '.js';
	}

	protected function get_script_tag() {
		return $this->convert_from_camel_case_to_dashes( $this->get_unqualified_class_name() );
	}

	protected function get_nonce_name() {
		return $this->convert_from_camel_case_to_dashes( $this->get_unqualified_class_name() ) . '-nonce';
	}

	protected function get_display_file_path() {
		$concert_plugin_path = constant( 'CONCERT_PLUGIN_PATH' );
		return $concert_plugin_path . 'admin/partials/' . $this->convert_from_camel_case_to_dashes(
			$this->get_unqualified_class_name()
		) . '-display.php';
	}

	/* TODO: this lot should be shunted out to a helper class */
	private static function convert_from_camel_case_to_dashes( $input ) {
		return self::convert_from_camel_case_to_padding( $input, '-' );
	}

	private static function convert_from_camel_case_to_padding( $input, $pad ) {
		preg_match_all( '!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $input, $matches );
		$ret = $matches[0];
		foreach ( $ret as &$match ) {
			$match = strtoupper( $match ) ? strtolower( $match ) : lcfirst( $match ) == $match;
		}
		return implode( $pad, $ret );
	}

}
