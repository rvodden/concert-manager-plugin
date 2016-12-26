<?php
namespace org\eu\brentso\concertmanagement\admin;
require_once 'abstract-meta-box.php';
require_once 'abstract-post-metadata.php';
require_once 'class-end-time-metadata.php';
require_once 'class-start-time-metadata.php';
require_once 'class-start-date-metadata.php';

class StartEndTimeBox extends AbstractMetaBox
{

    protected function configure_post_metadata() {
        $this->add_post_metadata(new StartTimeMetaData());
        $this->add_post_metadata(new EndTimeMetaData());
        $this->add_post_metadata(new StartDateMetaData());
    }
    
    public function enqueue_scripts ()
    {
        error_log("Scripts are being enqueued");
        
        wp_enqueue_script('jquery-ui-datepicker');
        wp_enqueue_script('jquery-ui-timepicker', 
                '//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js');
        parent::enqueue_scripts();
    }

    public function enqueue_styles ()
    {
        error_log("Styles are being enqueued");
        wp_enqueue_style('jquery-ui-style', 
                '//ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css', 
                true);
        wp_enqueue_style('jquery-ui-timepicker-style', 
                '//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css');
        parent::enqueue_styles();
    }
}
?>