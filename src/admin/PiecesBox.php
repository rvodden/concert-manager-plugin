<?php

namespace uk\org\brentso\concertmanagement\admin;

use uk\org\brentso\concertmanagement\common;

if(!class_exists('WP_List_Table')){
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class PiecesTable extends \WP_List_Table {

    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct( array(
            'singular' => __( 'Piece', 'your_textdomain' ),
            'plural'   => __( 'Pieces', 'your_textdomain' ),
            'ajax'     => true
        ) );
    }
    
    /**
     * Get the table data
     *
     * @return array
     */
    public function get_data() {
        // post will only be defined if we're editing an existing concert
        if( ! isset($_GET['post']) ) {
            return array();
        }

        $post_id = $_GET['post'];

        $concert_pieces = get_post_meta( $post_id, 'concert-pieces', true );
        if ( empty( $concert_pieces ) ) {
            return array();
        }
        $pieces = json_decode( $concert_pieces, true );
        return $pieces;
    }

    public function get_columns() {
        $columns = array(
            'title' => 'Title',
            'composer' => 'Composer',
        );
        return $columns;
    }
    
    /**
     * Prepare the items for the table to process
     */
    public function prepare_items() {
        $columns = $this->get_columns();
        
        $hidden = array();
        $sortable = array();
        
        $this->_column_headers = array( $columns, $hidden, $sortable );
        
        $data = $this->get_data();
        $per_page = count( $data );
        $current_page = $this->get_pagenum();
        $total_items = count( $data );
        $this->items = $data;
    }
    
    /**
     * Render the "Add piece" button
     */
    public function add_piece_button() {
        ?>
        <div class="add-piece">
            <button id="add-piece-button" class="button"><?php _e( 'Add piece...', 'your_textdomain' ); ?></button>
            <div id="add-piece-dialog" title="<?php _e( 'Add a piece', 'your_textdomain' ); ?>">
                <form>
                    <label for="piece-title"><?php _e( 'Title:', 'your_textdomain' ); ?></label>
                    <input type="text" name="piece-title" id="piece-title" /><br />
                    <label for="piece-composer"><?php _e( 'Composer:', 'your_textdomain' ); ?></label>
                    <input type="text" name="piece-composer" id="piece-composer" /><br />
                </form>
            </div>
        </div>
        <?php
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

    /**
     * Render the table
     */
    public function display() {
        // echo '<input type="hidden" name="concert-pieces" value="' . esc_attr(get_post_meta(get_the_ID(), 'concert-pieces', true)) . '">';
        $this->add_piece_button();
        parent::display();
    }
    
    /**
     * Render the title column
     *
     * @param array $item The current item
     */
    public function column_title( $item ) {
        return $item['title'];
    }
    
    /**
     * Render the composer column
     *
     * @param array $item The current item
     */
    public function column_composer( $item ) {
        return $item['composer'];
    }

}


class PiecesBox extends AbstractConcertMetaBox
{

    protected function configurePostMetadata()
    {
        $this->addPostMetadata(new common\PiecesMetadata());
    }

    public function enqueueScripts( $hook_suffix )
    {
        error_log('Scripts are being enqueued');
        wp_enqueue_script('jquery-ui-dialog');
        parent::enqueueScripts($hook_suffix);
    }

    public function enqueueStyles( $hook_suffix )
    {
        error_log('Styles are being enqueued');
        wp_enqueue_style(
            'jquery-ui-style',
            '//ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css',
            true
        );
        parent::enqueueStyles($hook_suffix);
    }
}


