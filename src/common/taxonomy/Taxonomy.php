<?php

namespace uk\org\brentso\concertmanagement\common\taxonomy;

use function Patchwork\CodeManipulation\register;

class Taxonomy {

    protected $labels;
    protected $postTypes;

    function __construct(
        $loader,
        $labels
    )
    {
        $this->labels = $labels;
        $this->postTypes = array();
        $loader->addAction('init', $this, 'createTaxonomy');
    }

    function createTaxonomy() {
        register_taxonomy(
            $this->getSlug(),
            $this->postTypes,
            array(
                'hierarchical' => false,
                'labels' => $this->labels->getLabelArray(),
                'show_in_rest' => true,
                'show_admin_column' => true,
                'rewrite' => array(
                    'slug' => $this->getSlug(),
                    'with_front' => false,
                    'hierarchical' => false,
                ),
                'capabilities' => array(
                    'manage_terms' => 'edit_posts',
                    'edit_terms' => 'edit_posts',
                    'delete_terms' => 'edit_posts',
                    'assign_terms' => 'edit_posts'
                )
            )
        );
    }
    
    function getSlug() : string {
        return strtolower($this->labels->getSingularName());
    }

    function registerPostType($postType) {
        $this->postTypes[] = $postType;
    }

    function addTerm($term, $description = NULL) {
        $args = array();
        if ( isset($description) ) {
            $args['description'] = $description;
        }
        wp_insert_term($term, $this->getSlug(), $args);
    }

}