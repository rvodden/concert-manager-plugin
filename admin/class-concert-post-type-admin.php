<?php

/**
 * Admin specific code for the concert post type.
 *
 * @link       http://brentso.org.uk
 * @since      0.0.1
 *
 * @package    concert_management
 * @subpackage concert_management/includes
 */

/**
 * Admin specific code for the concert post type.
 *
 * @package concert_management
 * @subpackage concert_management/includes
 * @author Richard Vodden <richard@vodden.com>
 *        
 */
class ConcertManagementConcertPostTypeAdmin
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
    
    protected $concert_management_concert_start_end_time_box;

    function __construct ($loader)
    {
        $this->loader = $loader;
        $this->load_dependencies();
    }

    private function load_dependencies ()
    {
        $concert_plugin_path = constant('CONCERT_PLUGIN_PATH');
        require_once $concert_plugin_path . 'admin/class-concert-management-concert-start-end-time-box.php';
        $this->concert_management_concert_start_end_time_box = new ConcertManagementConcertStartEndTimeBox(
                $this->loader,
                "Concert Time and Date"
                );
    }
    
}
?>