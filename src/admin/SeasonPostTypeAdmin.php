<?php

namespace uk\org\brentso\concertmanagement\admin;

use uk\org\brentso\concertmanagement\common;

/**
 * Admin specific code for the season post type.
 *
 * @link  http://brentso.org.uk
 * @since 0.0.1
 *
 * @package    concert_management
 * @subpackage concert_management/common
 */

class SeasonPostTypeAdmin
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


    public function __construct($loader)
    {
        $this->loader = $loader;
        $this->loadDependencies();
    }

    private function loadDependencies()
    {
    
    }
}