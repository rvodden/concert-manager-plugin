<?php

namespace uk\org\brentso\concertmanagement\common;

use uk\org\brentso\concertmanagement;
use uk\org\brentso\concertmanagement\admin;
use WP_Widget;

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link  http://brentso.org.uk/
 * @since 0.0.1
 *
 * @package    concert_management
 * @subpackage concert_management/common
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      0.0.1
 * @package    concert_management
 * @subpackage concert_management/includes
 * @author     Your Name <email@example.com>
 */
class ConcertManagementPlugin
{

    /**
     * The unique identifier of this plugin.
     *
     * @since  0.0.1
     * @access protected
     * @var    string    $plugin_name    The string used to uniquely identify this plugin.
     */
    protected $plugin_name;

    /**
     * The current version of the plugin.
     *
     * @since  1.0.0
     * @access protected
     * @var    string    $version    The current version of the plugin.
     */
    protected $version;

    protected $plugin_concert_post_type;

    /*
    *
    */
    protected $loader;
    protected $concertManagementPublic;
    protected $settingsPage;
    protected $i18n;
    protected $postTypes;
    protected $widgets;
    protected $blocks;

    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     *
     * @since 0.0.1
     */
    public function __construct(
        Loader $loader,
        concertmanagement\ConcertManagementPublic $concertManagementPublic,
        admin\SettingsPage $settingsPage,
        I18n $i18n,
        array $postTypes,
        array $blocks
    ) {
        $this->loader = $loader;
        $this->concertManagementPublic = $concertManagementPublic;
        $this->settingsPage = $settingsPage;
        $this->i18n = $i18n;
        $this->postTypes = $postTypes;
        $this->blocks = $blocks;
    }

    public function init()
    {
        $this->setLocale();
        $this->definePostTypes();
        $this->defineBlocks();
        $this->defineAdminHooks();
        $this->definePublicHooks();
    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the I18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since  0.0.1
     * @access private
     */
    private function setLocale()
    {
        $this->loader->addAction('plugins_loaded', $this->i18n, 'loadPluginTextdomain');
    }

    /**
     * Register all of the hooks related to concert post type.
     *
     * @since  0.0.1
     * @access private
     */
    private function definePostTypes()
    {
        // TODO : call the init function when it exists
        //$this->plugin_concert_post_type = new ConcertPostType( $this->loader );
    }

    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     *
     * @since  0.0.1
     * @access private
     */
    private function defineAdminHooks()
    {
        $this->loader->addAction('admin_enqueue_scripts', $this->settingsPage, 'enqueueStyles');
        $this->loader->addAction('admin_enqueue_scripts', $this->settingsPage, 'enqueueScripts');
        $this->loader->addAction('admin_menu', $this->settingsPage, 'addOptionsPage');
    }

    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @since  0.0.1
     * @access private
     */
    private function definePublicHooks()
    {
        $this->loader->addAction('wp_enqueue_scripts', $this->concertManagementPublic, 'enqueueStyles');
        $this->loader->addAction('wp_enqueue_scripts', $this->concertManagementPublic, 'enqueueScripts');
    }

    /**
     * 
     */
    private function defineBlocks()
    {
        foreach($this->blocks as &$block) {
            $this->loader->addAction('init', $block, 'register');
        }        
    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since 0.0.1
     */
    public function run()
    {
        $this->loader->run();
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @since  0.0.1
     * @return string    The name of the plugin.
     */
    public function getPluginName()
    {
        return $this->plugin_name;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @since  0.0.1
     * @return Loader    Orchestrates the hooks of the plugin.
     */
    public function getLoader()
    {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @since  0.0.1
     * @return string    The version number of the plugin.
     */
    public function getVersion()
    {
        return $this->version;
    }
}