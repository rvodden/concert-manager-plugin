<?php
require_once 'abstract_meta_box.php';
require_once 'abstract_post_metadata.php';
require_once 'class-concert-management-concert-end-time-metadata.php';
require_once 'class-concert-management-concert-start-time-metadata.php';
require_once 'class-concert-management-concert-start-date-metadata.php';

class ConcertManagementConcertStartEndTimeBox extends AbstractMetaBox
{

    protected function configure_post_metadata() {
        $this->add_post_metadata(new ConcertStartTimeMetaData());
        $this->add_post_metadata(new ConcertEndTimeMetaData());
        $this->add_post_metadata(new ConcertStartDateMetaData());
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