<?php

namespace uk\org\brentso\concertmanagement\common\fields;

use uk\org\brentso\concertmanagement\common;

class CustomPostTypeField extends AbstractCustomField {

    protected common\posts\PostType $postType;

    function setPostType(common\posts\PostType $postType) : self {
        $this->postType = $postType;
        return $this;
    }

    protected function getPosts() : array {
        $items = array();
        $args = array(
            'post_type' => $this->postType->getSlug(),
            'posts_per_page' => -1,
            'order' => 'ASC',
            'orderby' => 'title'
        );
        $results = new \WP_Query( $args );
        if ( $results->have_posts() ) {
            while ( $results->have_posts() ) {
                $items[] = $results->next_post();
            }
        }
        return $items;
    }

    function display($post)
    {
        $posts = $this->getPosts();
        $current_value = (int) get_post_meta( $post->ID, $this->name, true );
        echo '<div class="form-field form-required>\n';
        echo '<label for="' . $this->name .'"><b>' . $this->title . '</b></label>';
        echo '<select name="' . $this->name . '" id="' . $this->name . '">';
        foreach($posts as $post) {
            echo '<option ';
            echo 'value="' . $post->ID . '" ';
            echo ($post->ID == $current_value ? 'selected' : '');
            echo ' >';
            echo $post->post_title;
            echo '</option>';
        }
        echo '</select>';                            
        echo '</div>';
    }

    function getValue($postId) {
        $foreign_post_id = parent::getValue($postId);
        return get_the_title($foreign_post_id);
    }
}        