<?php

namespace uk\org\brentso\concertmanagement\common\fields;

class CustomWysiwygField extends AbstractCustomField {
    function display($post)
    {
        $value =  get_post_meta( $post->ID, $this->name, true );
        wp_editor(
            $value,
            $this->name,
            array(
                'wpautop' => true,
                'media_buttons' => false,
                'textarea_name' => $this->name,
                'textarea_rows' => 10,
                "teeny" => true
            )
        );
    }
}
