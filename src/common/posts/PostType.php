<?php

namespace uk\org\brentso\concertmanagement\common\posts;

use PHPUnit\Metadata\Metadata;
use uk\org\brentso\concertmanagement\common\posts;
use uk\org\brentso\concertmanagement\common;
use uk\org\brentso\concertmanagement\admin;

/**
 * Register the concert custom type for the plugin.
 *
 * TODO: write a description here if we need to
 *
 * @package    concert_management
 * @subpackage concert_management/common
 * @author     Richard Vodden <richard@vodden.com>
 */
class PostType implements posts\PostTypeInterface
{

    /**
     * The loader that's responsible for maintaining and registering all hooks
     * that power
     * the plugin.
     *
     * @since  0.0.1
     * @access protected
     * @var    Loader $loader Maintains and registers all hooks
     *      for the plugin.
     */
    
    protected common\Loader $loader;
    protected PostLabels $postLabels;
    protected string $description;
    protected bool $isPublic = true;
    protected bool $isHierachical = false;
    protected bool $showInMenu = true;
    protected admin\AdminMenu $adminMenu;
    protected array $supports = array("title", "editor", "revisions", "author", "excerpt", "thumbnail");
    protected $menu_icon;

    protected array $customFields;

    const SUPPORTS = array(
        'title', 
        'editor', 
        'comments', 
        'revisions', 
        'trackbacks', 
        'author', 
        'excerpt', 
        'page-attributes', 
        'thumbnail', 
        'custom-fields',
        'post-formats');

    public function __construct(common\Loader $loader)
    {
        $this->loader = $loader;
        $this->customFields = array();
        $this->defineHooks($loader);
        $this->defineAdminHooks($loader);
    }

    private function defineHooks($loader)
    {
        $loader->addAction('init', $this, 'createPostType');
    }

    private function defineAdminHooks($loader)
    {
        $loader->addAction('save_post', $this, 'saveCustomFields', 10, 2);
        $loader->addAction('admin_menu', $this, 'createCustomFields');
    }

    public function createPostType()
    {
        $args = array();
        $args['labels'] = $this->postLabels->getLabelArray();
        if (isset($this->isPublic)) $args['public'] = $this->isPublic;
        if (isset($this->isHierachical)) $args['hierarchical'] = $this->isHierachical;
        $args['show_ui'] = true;
        if ( isset($this->showInMenu) ) {
            if ($this->showInMenu && isset($this->adminMenu))
                $args['show_in_menu'] = $this->adminMenu->getSlug();
            else
                $args['show_in_menu'] = $this->showInMenu;
        }
        $args['show_in_rest'] = true;
        $args['exclude_from_search'] = false;
        if (isset($this->supports)) $args['support'] = $this->supports;
        $args['rewrite'] = array('slug' => $this->getSlug());

        if (isset($this->menu_icon)) {
            $args["menu_icon"] = $this->menu_icon;
        };

        register_post_type($this->getSlug(), $args);

        foreach(array_diff(self::SUPPORTS, $this->supports) as $support) {
            remove_post_type_support($this->getSlug(), $support);
        }
    }

    function getSlug() : string {
        return strtolower($this->postLabels->getSingularName());
    }

    function addCustomField(
        common\fields\CustomFieldInterface $customField
    ) {
        array_push($this->customFields, $customField);
        $this->addCustomColumn($customField);
        return $this;
    }

    protected function addCustomColumn(
        common\fields\CustomFieldInterface $customField
    ) {
        if ($customField->getDisplayInAdminTables()) {
            $this->loader->addAction('manage_' . $this->getSlug() . '_posts_columns', $customField, 'addColumnHeader' );
            $this->loader->addAction('manage_' . $this->getSlug() . '_posts_custom_column', $customField, 'generateColumnContent', 10, 2 );
        }
    }

    function createCustomFields() {
        add_meta_box(
            $this->getSlug() . '-custom-fields',
            'Attributes', 
            array( $this, 'displayCustomFields' ), 
            $this->getSlug(), 
            'normal', 
            'high' );
    }

    function saveCustomFields( $post_id, $post ) {
        // TODO: check nonce
        // TOOD: check permissions
        foreach($this->customFields as $customField) {
            $customField->save($post_id, $post);
        }
    }

    function displayCustomFields() {
        global $post;
        echo '<div class="form-wrap" >';
        foreach ($this->customFields as $customField) {
            $customField->display($post);
        }
        echo '</div>';
    }
   
    /**
     * An array of labels for this post type. If not set, post labels are 
     * inherited for non-hierarchical types and page labels for hierarchical 
     * ones. See get_post_type_labels() for a full list of supported labels.
     * 
     * @param PostLabels $postLabels;
     *  */ 
    function setLabels(PostLabels $postLabels) {
        $this->postLabels = $postLabels;
        return $this;
    }

    function getLabels() : PostLabels {
        return $this->postLabels;
    }

    function setDescription(string $description) {
        $this->description = $description;
        return $this;
    }

    function setIsPublic(bool $isPublic) {
        $this->isPublic = $isPublic;
        return $this;
    }

    function setShowInMenu(bool $showInMenu) {
        $this->showInMenu = $showInMenu;
        return $this;
    }

    function setAdminMenu(admin\AdminMenu $adminMenu) {
        $this->adminMenu = $adminMenu;
        $this->showInMenu = true;
        return $this;
    }

    function addSupport(string $support) {
        if (! in_array($support, self::SUPPORTS, true ) )
            throw new \Exception($support . "is not supported.");
        
        if (! in_array($support, $this->supports, true))
            $this->supports[] = $support;
        return $this;
    }

    function supports(string $support) : bool {
        $position = array_search($support, $this->supports);
        return $position !== false;
    }

    function removeSupport(string $support) {
        $position = array_search($support, $this->supports);
        if ($position !== false) {
            unset($this->supports[$position]);
            $this->supports = array_values($this->supports);
        }
        return $this;
    }

    function getAdminColumns() : array {
        $columns = array();

        if ( $this->supports('title') ) {
            $columns[] = 'title';
        }

        foreach($this->customFields as $customField) {
            if ($customField->getDisplayInAdminTables() ) {
                $columns[] = $customField;
            }
        }

        return $columns;
    }
}
