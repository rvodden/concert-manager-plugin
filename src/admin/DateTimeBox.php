<?php

namespace uk\org\brentso\concertmanagement\admin;

use uk\org\brentso\concertmanagement\common;

class DateTimeBox extends AbstractAutoDisplayMetaBox
{

    protected common\PostMetadataInterface $metadata;

    public function __construct( 
        common\Loader $loader, 
        string $title,
        string $post_type,
        common\PostMetadataInterface $metadata
    
    )
    {
        parent::__construct($loader, $title, $post_type);
        $this->metadata = $metadata;
    }

    protected function configurePostMetadata()
    {
        
    }

    public function enqueueScripts($hook_suffix)
    {
        wp_enqueue_script(
            'jquery-ui-timepicker',
            '//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js'
        );
        parent::enqueueScripts($hook_suffix);
    }

    public function enqueueStyles($hook_suffix)
    {
        wp_enqueue_style(
            'jquery-ui-timepicker-style',
            '//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css'
        );
        parent::enqueueStyles($hook_suffix);
    }
}
