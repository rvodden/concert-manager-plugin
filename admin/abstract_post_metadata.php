<?php

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
        $new_value = sanitize_html_class($_POST[$this->key]);
        update_post_meta($post_id, $this->key, $new_value);
    }

    /**
     * 
     * @param unknown $post_id
     * @return mixed|boolean|string|unknown
     */
    public function read ($post_id)
    {
        return get_post_meta($post_id, $this->key);
    }
    
    public function get_key () {
        return $this->key;
    }
}
?>