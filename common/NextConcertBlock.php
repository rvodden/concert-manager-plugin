<?php

namespace uk\org\brentso\concertmanagement\common;

use DateTimeImmutable;

class NextConcertBlock extends AbstractDynamicBlock {

    function render($block_attributes) {
        $concerts = get_posts([
            'post_type' => 'concert',
        ]);

        $concert = $concerts[0];
        $metadata = get_post_meta($concert->ID);

        $concert_start_date = DateTimeImmutable::createFromFormat('j/m/Y', get_post_meta($concert->ID, 'concert-start-date', \true));
        $pretty_date = $concert_start_date->format('F j, Y');
        $concert_start_time = $metadata['concert-start-time'][0];

        $pieces = json_decode(get_post_meta($concert->ID, 'concert-pieces', \true));
        print_r($pieces);
       
        $render = "<p><a href=\"". get_permalink($concert->ID) ."\">" . $concert->post_title . "</a><br />";
        $render .= $pretty_date . ", ". $concert_start_time . "</p><br />";
        $render .= $pieces;
        return $render;
    }
}

?>