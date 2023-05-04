<?php

namespace uk\org\brentso\concertmanagement\common\fields;

use uk\org\brentso\concertmanagement\common;


abstract class AbstractCustomField implements CustomFieldInterface {

    protected common\Loader $loader;
    protected string $name;
    protected string $title;
    protected string $description;
    protected array $scope;
    protected $capability = NULL;
    protected $displayInAdminTables = false;

    function __construct(
        common\Loader $loader
    ) {
        $this->loader = $loader;
        $loader->addAction('admin_enqueue_scripts', $this, 'enqueueScriptsAndStyles');
    }

    public function enqueueScriptsAndStyles() {

    }

    function getValue($post) {
        // TODO: this should probably consistently require the post_id
        if ($post instanceof \WP_Post) {
            $post_id = $post->ID;
        } else {
            $post_id = $post;
        }

        $value = get_post_meta($post_id, $this->name, true);
        return $value;
    }
    
    function setName(string $name) {
        $this->name = $name;
        return $this;
    }

    function getName() : string {
        return $this->name;
    }

    function setTitle(string $title) {
        $this->title = $title;
        return $this;
    }

    function getTitle() : string {
        return $this->title;
    }

    function setDescription(string $description) {
        $this->description = $description;
        return $this;
    }

    function setCapability(string $capability) {
        $this->capability = $capability;
        return $this;
    }

    function setDisplayInAdminTables(bool $displayInAdminTables) {
        $this->displayInAdminTables = $displayInAdminTables;
        return $this;
    }

    function getDisplayInAdminTables() : bool {
        return $this->displayInAdminTables;
    }

    abstract function display($post);
    
    public function addColumnHeader( $columns ) {
        $columns[$this->name] = $this->title;
        return $columns;
    }

    public function generateColumnContent( $column_name, $post_id ) {
        if ($column_name == $this->name) {
            echo $this->getValue($post_id);
        }
    }

    protected function isPermitted($post_id) : bool {
        return ! isset($this->capability) ||  current_user_can($this->capability, $post_id );
    }

    function save($post_id, $post) {
        if (! $this->isPermitted($post_id) ) return; // TODO: log this
        if (isset($_POST[$this->name])) {
            $value = $_POST[$this->name];
            update_post_meta($post_id, $this->name, $value);
        } else {
            delete_post_meta($post_id, $this->name);
        }
    }
}