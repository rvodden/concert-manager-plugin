<?php
require 'interface_meta_box.php';
require 'interface_post_metadata.php';

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
abstract class AbstractMetaBox implements MetaBox
{

    /**
     * The loader that's responsible for maintaining and registering all hooks
     * that power
     * the plugin.
     *
     * @since 0.0.1
     * @access protected
     * @var ConcertManagementLoader $loader Maintains and registers all hooks
     *      for the plugin.
     */
    protected $loader;

    /**
     * This is the title of the metabox used at the top of the metabox display
     * and when the metabox is folded.
     *
     * @since 0.0.1
     * @access protected
     * @var ConcertManagementLoader $loader Maintains and registers all hooks
     *      for the plugin.
     */
    protected $title;

    /**
     * Collection of metadata belonging to the box
     *
     * @var array
     */
    protected $post_metadata = array();

    /**
     *
     * @param unknown $loader            
     * @param unknown $title            
     */
    function __construct ($loader, $title)
    {
        $this->set_title($title);
        $this->loader = $loader;
        $this->configure_post_metadata();
        $this->define_admin_hooks();
    }

    protected abstract function configure_post_metadata ();

    protected function define_admin_hooks ()
    {
        $this->loader->add_action('add_meta_boxes', $this, 'add');
        $this->loader->add_action('save_post', $this, 'save');
        
        $this->loader->add_action('admin_enqueue_scripts', $this, 
                'enqueue_scripts');
        $this->loader->add_action('admin_enqueue_scripts', $this, 
                'enqueue_styles');
    }

    public function add ()
    {
        // TODO: the post type shouldn't be hardcoded here
        add_meta_box($this->get_tag(), $this->get_title(), 
                array(
                        $this,
                        'display'
                ), 'concert', 'normal', 'default');
    }

    function display ($post, $args)
    {
        $post_metadata = $this->load_post_metadata($post->id);
        wp_nonce_field(plugin_basename(__FILE__), $this->get_nonce_name());
        require $this->get_display_file_path();
    }

    function save ($post_id)
    {
        error_log("Saving post");
        // do nothing if autosaving
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }
        
        // do nothing if nonce saved
        if (! wp_verify_nonce($_POST[$this->get_nonce_name()], 
                plugin_basename(__FILE__))) {
            error_log("Nonce verification failed");
            return;
        }
        
        if (! current_user_can('edit_post', $post_id)) {
            error_log("Current user doesn't have edit concert features");
            return;
        }
        
        $this->save_post_metadata($post_id, $_POST);
    }

    public function enqueue_scripts ()
    {
        wp_enqueue_script($this->get_script_tag(), $this->get_script_url());
    }

    public function enqueue_styles ()
    {
        wp_enqueue_script($this->get_style_tag(), $this->get_style_url());
    }

    protected function get_style_url ()
    {
        $concert_plugin_path = constant('CONCERT_PLUGIN_URL');
        $underscored_class_name = $this->convert_from_camel_case_to_dashes(
                static::class);
        return $concert_plugin_path . 'admin/css/' . $underscored_class_name .
                 '.css';
    }

    protected function get_style_tag ()
    {
        return $this->convert_from_camel_case_to_dashes(static::class) . '-style';
    }

    protected function get_tag ()
    {
        return $this->convert_from_camel_case_to_dashes(static::class);
    }

    protected function set_title ($title)
    {
        $this->title = $title;
    }

    protected function get_title ()
    {
        return $this->title;
    }

    protected function get_script_url ()
    {
        $concert_plugin_path = constant('CONCERT_PLUGIN_URL');
        $underscored_class_name = $this->convert_from_camel_case_to_dashes(
                static::class);
        return $concert_plugin_path . 'admin/js/' . $underscored_class_name .
                 '.js';
    }

    protected function get_script_tag ()
    {
        return $this->convert_from_camel_case_to_dashes(static::class);
    }

    protected function get_nonce_name ()
    {
        return $this->convert_from_camel_case_to_dashes(static::class) . '-nonce';
    }

    protected function get_display_file_path ()
    {
        $concert_plugin_path = constant('CONCERT_PLUGIN_PATH');
        return $concert_plugin_path . 'admin/partials/' .
                 $this->convert_from_camel_case_to_dashes(static::class) .
                 '-display.php';
    }

    public function add_post_metadata (PostMetadata $post_metadatum)
    {
        $this->post_metadata[] = $post_metadatum; // this is horrid PHP notation
                                                      // for "add post_metadatum on
                                                      // the end of post_metadata
    }

    public function load_post_metadata ($post_id)
    {
        error_log("Loading post metadata");
        foreach ($this->post_metadata as $post_metadatum) {
            $key = $post_metadatum->get_key();
            $value = $post_metadatum->read($post_id);
            error_log("Loading post metadata for " . $key ." : " . $value);
            $metadata_array[$key] = $value;
        }
        
        return $metadata_array;
    }

    public function save_post_metadata ($matadata_array)
    {
        foreach ($this->post_metadata as $post_metadatum) {
            $post_metadatum->update_from_array($post_metadatum);
        }
    }

    /* TODO: this lot should be shunted out to a helper class */
    private static function convert_from_camel_case_to_dashes ($input)
    {
        return self::convert_from_camel_case_to_padding($input, '-');
    }

    private static function convert_from_camel_case_to_padding ($input, $pad)
    {
        preg_match_all(
                '!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', 
                $input, $matches);
        $ret = $matches[0];
        foreach ($ret as &$match) {
            $match = $match == strtoupper($match) ? strtolower($match) : lcfirst(
                    $match);
        }
        return implode($pad, $ret);
    }
}
?>