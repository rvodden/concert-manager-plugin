<?php
namespace org\eu\brentso\concertmanagement\admin;
require_once 'abstract-concert-meta-box.php';
require_once 'class-pieces-metadata.php';


class PiecesBox extends AbstractConcertMetaBox
{

    protected function configure_post_metadata ()
    {
        $this->add_post_metadata(new PiecesMetaData());
    }

    public function enqueue_scripts ($hook_suffix)
    {
        error_log("Scripts are being enqueued");
        wp_enqueue_script('jquery-ui-dialog');
        parent::enqueue_scripts($hook_suffix);
    }

    public function enqueue_styles ($hook_suffix)
    {
        error_log("Styles are being enqueued");
        wp_enqueue_style('jquery-ui-style', 
                '//ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css', 
                true);
        parent::enqueue_styles($hook_suffix);
    }
}
?>