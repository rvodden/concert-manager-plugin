<?php

namespace uk\org\brentso\concertmanagement\common\taxonomy;

class TaxonomyLabels {

    protected $singular_name;
    protected $plural_name;
    
    function __construct(
        $singular_name,
        $plural_name = NULL
    ) {
        $this->singular_name = $singular_name;
        $this->plural_name = isset($plural_name) ? $plural_name : $singular_name . "s";
    }
    
    function getPluralName() : string {
        return $this->plural_name;
    }

    function getSingularName() : string {
        return $this->singular_name;
    }

    function getLabelArray() : array {
        return array(
            'name' => $this->plural_name,
            'singular_name' => $this->singular_name,
            'add_new_item' => "Add New " . $this->singular_name,
            'edit_item' => 'Edit ' . $this->singular_name,
            'update_item' => 'Update ' . $this->singular_name,
            'search_items' => 'Search ' . $this->plural_name
        );
    }
}