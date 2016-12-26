<?php
namespace org\eu\brentso\concertmanagement\admin;

abstract class AbstractPostMetadata implements PostMetadata
{
    private $key;

    public function __construct ($key)
    {
        $this->key = $key;
    }

    /**
     * Takes an array ($key->$value) ostensibly directly from a 
     * for in a metabox. It checks to see if there is a value
     * associated with the instance's key and if so, updates accordingly.
     * 
     * @param unknown $array_of_values
     */
    public function update_from_array ( $post_id, $array_of_values )
    {
        $new_value = sanitize_text_field($array_of_values[$this->key]);
        error_log("Saving post-metadata: " . $this->key . ":" . $new_value);
        update_post_meta( $post_id, $this->key, $new_value);
        
        $parent = wp_is_post_revision($post_id);
        if ( $parent ) {
            $original_value = get_post_meta($parent->ID, $this->key, true);
            
            if ( false !== $original_value ) {
                add_metadata($post_id, $this->key, $new_value);
            }
        }
    }

    /**
     * 
     * @param unknown $post_id
     * @return mixed|boolean|string|unknown
     */
    public function read ($post_id)
    {
        error_log("Getting post metadata for : " . $this->key);
        return get_post_meta($post_id, $this->key, true);
    }
    
    public function get_key () {
        return $this->key;
    }
}
?>