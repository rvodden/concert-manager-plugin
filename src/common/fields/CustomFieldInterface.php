<?php

namespace uk\org\brentso\concertmanagement\common\fields;

use uk\org\brentso\concertmanagement\common;

interface CustomFieldInterface {

    public function display($post);
    public function save($post_id, $post);

    public function getName();
    public function getTitle();
    public function getDisplayInAdminTables() : bool;
    
    public function addColumnHeader( $columns );
    public function generateColumnContent( $column_name, $post_id );

}