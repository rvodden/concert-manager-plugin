<?php

namespace uk\org\brentso\concertmanagement\common\fields;
use uk\org\brentso\concertmanagement\common\posts;

class CustomPostTypeTable extends \WP_List_Table {
   
    protected array $postIds;
    protected posts\PostType $postType;

    function __construct(posts\PostType $postType) {
        parent::__construct(
            array(
                'singular' => $postType->getLabels()->getSingularName(),
                'plural' => $postType->getLabels()->getPluralName(),
                'ajax' => 'true'
            )
        );
        $this->postType = $postType;
        $this->postIds = array();
    }

    function get_columns()
    {
        $columns = array();
        foreach($this->postType->getAdminColumns() as $column) {
            if ($column === 'title') {
                $columns[$column] = 'Title';
                continue;
            }
            $columns[$column->getName()] = $column->getTitle();
        }
        return $columns;
    }

    function setPostIds($postIds) {
        $this->postIds = isset($postIds) ? $postIds : array();
    }

    function prepare_items()
    {
        $columns = $this->get_columns();
        $hidden = array();
        $sortable = array();
        $this->_column_headers = array($columns, $hidden, $sortable);

        $this->items = array();
        foreach($this->postIds as $postId) {
            error_log($postId);
            $post = get_post($postId);
            $item = array();
            $item['id'] = $postId;
            foreach($this->postType->getAdminColumns() as $column) {
                if ($column === 'title') {
                    $item['title'] = get_the_title($postId);
                    continue;
                };
                $item[$column->getName()] = $column->getValue($postId);
            }
            $this->items[] = $item;
        }
    }

    function column_default($item, $column_name) {
        return $item[$column_name];
    }

    function column_cb($item)
    {
        return sprintf(
                '<input type="checkbox" name="element[]" value="%s" />',
                $item['id']
        );
    }

    /**
     * Override the default display_tablenav to remove the nonce field.
     */
    function display_tablenav( $which ) 
    {
        ?>
        <div class="tablenav <?php echo esc_attr( $which ); ?>">
    
            <div class="alignleft actions">
                <?php $this->bulk_actions(); ?>
            </div>
            <?php
            $this->extra_tablenav( $which );
            $this->pagination( $which );
            ?>
            <br class="clear" />
        </div>
        <?php
    }

    function ajax_response() {
        // check_ajax_referer( 'ajax-custom-list-nonce', '_ajax_custom_list_nonce' );
        $this->prepare_items();
    
        extract( $this->_args );
    
        ob_start();
        if ( ! empty( $_REQUEST['no_placeholder'] ) )
            $this->display_rows();
        else
            $this->display_rows_or_placeholder();
        $response = ob_get_clean();
    
        wp_die( json_encode( $response ) );
    }
}