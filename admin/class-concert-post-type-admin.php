<?php
namespace org\eu\brentso\concertmanagement\admin;
require_once 'class-start-end-time-box.php';
require_once 'class-pieces-box.php';

/**
 * Admin specific code for the concert post type.
 *
 * @link http://brentso.org.uk
 * @since 0.0.1
 *       
 * @package concert_management
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
class ConcertPostTypeAdmin
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

    protected $start_end_time_box;

    protected $pieces_box;

    function __construct ($loader)
    {
        $this->loader = $loader;
        $this->load_dependencies();
    }

    private function load_dependencies ()
    {   
        $this->start_end_time_box = new StartEndTimeBox($this->loader, 
                "Concert Time and Date");
        $this->pieces_box = new PiecesBox($this->loader, "Concert Pieces");
    }
}
?>