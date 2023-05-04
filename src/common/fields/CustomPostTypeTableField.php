<?php

namespace uk\org\brentso\concertmanagement\common\fields;

use uk\org\brentso\concertmanagement\common;

class CustomPostTypeTableField extends AbstractJsonEncodedCustomField {
    
    protected common\posts\PostType $postType;
    protected CustomPostTypeTable $customPostTypeTable;

    function __construct(common\Loader $loader)
    {
        parent::__construct($loader);
        $this->loader->addAction('admin_init', $this, 'addAjaxActions');
    }

    function addAjaxActions() {
        add_action('wp_ajax_get_posts', array($this, 'getCustomPosts'));
        add_action('wp_ajax_get_post', array($this, 'getCustomPost'));
        // add_action('wp_ajax_fetch_custom_list', array($this, 'getTableContents'));
    }

    function enqueueScriptsAndStyles()
    {
        parent::enqueueScriptsAndStyles();

        wp_enqueue_script('jquery-ui-dialog');
        wp_enqueue_script('ajax_script', plugins_url( '/custom-post-type-table-field/custom-post-type-table-field.js', __FILE__ ), array('jquery-ui-dialog'));
        wp_localize_script( 'ajax_script', 'ajax_object', array( 
            'ajax_url' => admin_url('admin-ajax.php'),
            'select_id' => $this->name . '-select',
            'input_id' => $this->name
        ));
        
        wp_enqueue_style('wp-jquery-ui-dialog');
    }

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

    protected function getPost($post) : \WP_Post {
        return get_post($post);
    }


    function display($post) {
        $this->customPostTypeTable = new CustomPostTypeTable($this->postType);
        $labels = get_post_type_labels(get_post_type_object($this->postType->getSlug()));
        $values = $this->getValue($post);
        $this->customPostTypeTable->setPostIds($values);
        if ( isset($values) ) {
            $posts = array();
            foreach($values as $value) {
                $posts[] = get_post($value);
            }
        }
        $this->customPostTypeTable->prepare_items();

        include dirname(constant('CONCERT_PLUGIN_PATH')) . '/src/common/fields/custom-post-type-table-field/custom-post-type-table-field.php';
    }

    function getCustomPosts() {
        header("Content-type: application/json");
        $posts = $this->getPosts();
        print(json_encode($posts));
        wp_die();
    }

    function getCustomPost() {
        header("Content-type: application/json");
        $post = $this->getPost($_POST['post_id']);
        print(json_encode($post));
        wp_die();
    }

    function getTableContents() {
        return $this->customPostTypeTable->ajax_response();
    }
}