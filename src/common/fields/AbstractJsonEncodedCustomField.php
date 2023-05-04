<?php

namespace uk\org\brentso\concertmanagement\common\fields;

use uk\org\brentso\concertmanagement\common;


abstract class AbstractJsonEncodedCustomField extends AbstractCustomField {

    function save($post_id, $post) {
        if (! $this->isPermitted($post_id) ) {
            error_log("user is not permitted to save.");
            return;
        }
        
        if (isset($_POST[$this->name])) {
            $value = $_POST[$this->name];
            error_log("saving value: " . $value);
            update_post_meta($post_id, $this->name, $value);
        } else {
            error_log("deleting value.");
            delete_post_meta($post_id, $this->name);
        }
    }

    function getRawValue($post) {
        return parent::getValue($post);
    }

    function getValue($post) {
        return json_decode($this->getRawValue($post));
    }
    
    private function isJson($string) {
        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
    }
}
