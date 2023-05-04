<?php

namespace uk\org\brentso\concertmanagement\common\posts;

interface ColumnInterface {
    public function manageColumns($column);
    public function manageCustomColumn($column, $post_id);
}