<?php

namespace uk\org\brentso\concertmanagement\common\fields;

class CustomTextField extends AbstractCustomField {
    function display($post)
    {
        echo '<div class="form-field form-required>';
        echo '<label for="' . $this->name .'"><b>' . $this->title . '</b></label>';
        echo '<input type="text" name="' . $this->name . '" id="' . $this->name . '" value="' . htmlspecialchars( get_post_meta( $post->ID, $this->name, true ) ) . '" class="form-control" />';                            
        echo '</div>';
    }
}