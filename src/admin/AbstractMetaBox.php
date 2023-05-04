<?php

namespace uk\org\brentso\concertmanagement\admin;

use uk\org\brentso\concertmanagement\common;

/**
 * This abstract meta box class implements sensible defaults for location of
 * css and js files and loads them.
 * By default a class with name
 *
 * ExampleMetaBox
 *
 * will automatically load:
 *
 * - admin/js/example_meta_box.js
 * - admin/css/example_meta_box.css
 *
 * @since 0.0.1
 */
abstract class AbstractMetaBox implements MetaBoxInterface
{

    /**
     * The loader that's responsible for maintaining and registering all hooks
     * that power
     * the plugin.
     *
     * @since  0.0.1
     * @access protected
     * @var    common\Loader $loader Maintains and registers all hooks
     *      for the plugin.
     */
    protected $loader;

    /**
     * This is the title of the metabox used at the top of the metabox display
     * and when the metabox is folded.
     *
     * @since  0.0.1
     * @access protected
     * @var    common\Loader $loader Maintains and registers all hooks
     *      for the plugin.
     */
    protected $title;

    /**
     * This is the post type to which the meta box pertains.
     * This field is
     * used to ensure that the box specific style and scripts are only loaded
     * on the appropriate post type.
     *
     * @since  0.0.1
     * @access protected
     * @var    common\Loader $loader Maintains and registers all hooks
     *      for the plugin.
     */
    protected $post_type;

    /**
     * Collection of metadata belonging to the box
     *
     * @var array
     */
    protected $post_metadata = array();

    /**
     *
     * @param common\Loader $loader
     * @param string        $title
     */
    public function __construct( $loader, $title, $post_type )
    {
        $this->setTitle($title);
        $this->loader = $loader;
        $this->post_type = $post_type;
    }

    public function init()
    {
        $this->configurePostMetadata();
        $this->defineAdminHooks();
    }

    abstract protected function configurePostMetadata();

    /* returns the url for the style sheets for this display box */
    abstract protected function getStyleUrl();

    /* returns the tags for the style sheets for this display box */
    abstract protected function getStyleTag();

    /* returns the url for the javascript for this display box */
    abstract protected function getScriptUrl();

    /* returns the tags for the javascript for this display box */
    abstract protected function getScriptTag();

    /* returns the tags for the javascript for this post type box */
    abstract protected function getTag();

    /* returns the nonce name for this meta box */
    abstract protected function getNonceName();

    /* returns the nonce name for this meta box */
    abstract protected function getDisplayFilePath();

    protected function defineAdminHooks()
    {
        $this->loader->addAction("add_meta_boxes_{$this->post_type}", $this, 'add');
        $this->loader->addAction("save_post_{$this->post_type}", $this, 'save', 10, 2);

        $this->loader->addAction('admin_enqueue_scripts', $this, 'enqueueScripts');
        $this->loader->addAction('admin_enqueue_scripts', $this, 'enqueueStyles');
    }

    public function add()
    {
        add_meta_box(
            $this->getTag(),
            $this->getTitle(),
            array( $this, 'display' ),
            $this->getPostType(),
            'normal',
            'default'
        );
    }

    /*
    * Displays the metabox, with the associated data from the post supplied
    */
    public function display( $post )
    {
        error_log('Displaying post number : ' . $post->ID);
        $metadata = $this->loadPostMetadata($post->ID);
        isset($metadata) ? error_log(implode('|', $metadata)) : error_log('No metadata');
        //wp_nonce_field( plugin_basename( __FILE__ ), $this->get_nonce_name() );
        include $this->getDisplayFilePath();
    }

    /*
    * Checks that the admin page which is being saved is the appropriate post
    * type and if so enqueues the necessary scripts to save this metabox
    */
    public function save( $post_id, $post )
    {
        error_log('Saving post');
        // do nothing if autosaving
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
            return;
        }

        /*
        if ( ! wp_verify_nonce( $_POST[ $this->get_nonce_name() ], plugin_basename( __FILE__ ) ) ) {
        error_log( 'Nonce verification failed' );
        return;
        }
        */

        if (! current_user_can('edit_post', $post_id) ) {
            error_log('Current user doesn\'t have edit concert features');
            return;
        }

        $this->savePostMetadata($post_id, $_POST);
    }

    /*
    * Checks that the admin page which is being laoded is appropriate
    * and if so enqueues the necessary scripts for this metabox
    */
    public function enqueueScripts( $hook_suffix )
    {
        if ($this->onPostTypeEditPage($hook_suffix) ) {
            wp_enqueue_script($this->getScriptTag(), $this->getScriptUrl());
        }
    }

    /*
    * Checks that the admin page which is being laoded is appropriate
    * and if so enqueues the necessary styles for this metabox
    */
    public function enqueueStyles( $hook_suffix )
    {
        if ($this->onPostTypeEditPage($hook_suffix) ) {
            wp_enqueue_style($this->getStyleTag(), $this->getStyleUrl());
        }
    }

    /*
    * Check that we are on the edit page which pertains to the post type
    * which this meta box is associated with.
    */
    private function onPostTypeEditPage( $hook_suffix )
    {
        if ('post.php' == $hook_suffix || 'post-new.php' == $hook_suffix ) {
            $screen = get_current_screen();
            if (is_object($screen) && ( $this->getPostType() == $screen->post_type ) ) {
                return true;
            }
        }

        return false;
    }

    public function setTitle( $title )
    {
        $this->title = $title;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getPostType()
    {
        return $this->post_type;
    }

    public function addPostMetadata( common\PostMetadataInterface $post_metadatum )
    {
        // this is horrid PHP notation for "add post_metadatum on the end of post_metadata
        $this->post_metadata[] = $post_metadatum;
    }

    public function loadPostMetadata( $post_id )
    {
        error_log('Loading post metadata from ' . $post_id);
        foreach ( $this->post_metadata as $post_metadatum ) {
            $key = $post_metadatum->getKey();
            $value = $post_metadatum->read($post_id);
            error_log('Loading post (' . $post_id . ') metadata for ' . $key . ' : ' . $value);
            $metadata_array[ $key ] = $value;
        }

        return isset($metadata_array) ? $metadata_array : null;
    }

    public function savePostMetadata( $post_id, $metadata_array )
    {
        error_log('Received metadata : ' . json_encode($metadata_array));
        foreach ( $this->post_metadata as $post_metadatum ) {
            $post_metadatum->updateFromArray($post_id, $metadata_array);
        }
    }
}
