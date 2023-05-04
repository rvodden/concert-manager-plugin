<?php

namespace uk\org\brentso\concertmanagement\common\posts;

class PostLabels {
    protected string $singular_name;
    protected string $plural_name;

    function getPluralName() : string {
        if (isset($this->plural_name)) return $this->plural_name;
        return $this->getSingularName() . "s";
    }
    
    function getName() : string {
        return $this->getPluralName();
    }
    
    function setPluralName(string $plural_name) : PostLabels {
        $this->plural_name = $plural_name;
        return $this;
    }

    function getSingularName() : string {
        return $this->singular_name;
    }
    
    function setSingularName(string $singular_name) : PostLabels {
        $this->singular_name = $singular_name;
        return $this;
    }
    
    function getLabelArray() : array {
        $singular_name = $this->getSingularName();
        $plural_name = $this->getPluralName();
        return array(
            'name' => $plural_name,
            'singular_name' => $singular_name,
            'add_new_item' => "Add New " . $singular_name,
            'update_item' => 'Update ' . $singular_name,
            'edit_item' => 'Edit ' . $singular_name,
            'new_item' => 'New ' . $singular_name,
            'view_item' => 'View ' . $singular_name,
            'view_items' => 'View ' . $plural_name,
            'search_items' => 'Search ' . $plural_name,
            'not_found' => "No " . $plural_name . " found.",
            'not_found_in_trash' => "No " . $plural_name . " found in trash.",
            'all_items' => 'All ' . $plural_name,
            'archives' => $singular_name . " Archives.",
            'attributes' => $singular_name . " Attributes",
            'insert_into_item' => "Insert into " . $singular_name,
            'uploaded_to_this_item' => "Uploaded to this " . $singular_name,
            'fiter_items_list' => "Filter " . $plural_name . " List",
            'items_list_navigation' => $plural_name . " List Navigation",
            'items_list' => $plural_name . "List",
            'item_published' => $singular_name. " Published",
            'item_published_privately' => $singular_name. " Published Privately",
            'item_reverted_to_draft' => $singular_name . " reverted to draft",
            'item_scheduled' => $singular_name . " scheduled",
            'item_updated' => $singular_name . " updated",
            'item_link' => $singular_name . " Link",
            'item_link_description' => "A link to a " . $singular_name,  
        );
    }
}