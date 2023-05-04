<?php

namespace uk\org\brentso\concertmanagement\common\fields;

use uk\org\brentso\concertmanagement\common\taxonomy;

class CustomPostTypeByTermField extends CustomPostTypeField {
    
    protected $taxonomy;
    protected $term;

    function setTaxonomy(taxonomy\Taxonomy $taxonomy) : self {
        $this->taxonomy = $taxonomy;
        return $this;
    } 

    function setTerm(string $term) : self {
        $this->term = $term;
        return $this;
    }
    
    protected function getPosts() : array {
        $items = array();
        $args = array(
            'post_type' => $this->postType->getSlug(),
            'posts_per_page' => -1,
            'tax_query' => array(
                array(
                    'taxonomy' => $this->taxonomy->getSlug(),
                    'field' => 'slug',
                    'terms' => $this->term
                )
                ),
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
}