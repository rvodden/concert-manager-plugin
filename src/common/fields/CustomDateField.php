<?php 
 
namespace uk\org\brentso\concertmanagement\common\fields;

use uk\org\brentso\concertmanagement\common;

class CustomDateField extends AbstractCustomField {

    public function enqueueScriptsAndStyles() {
        parent::enqueueScriptsAndStyles();
        wp_enqueue_script('jquery-ui-core');
        wp_enqueue_script('jquery-ui-datepicker');
        wp_enqueue_script('custom_date_field', constant('CONCERT_PLUGIN_URL') . '/common/fields/custom-date-field/custom-date-field.js', array('jquery-ui-datepicker'));
        
        wp_enqueue_style('jquery-ui-style', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/themes/smoothness/jquery-ui.css');
        wp_enqueue_style('custom_date_field', constant('CONCERT_PLUGIN_URL') . '/common/fields/custom-date-field/custom-date-field.css');
    }

    function display($post) {
        include dirname(constant('CONCERT_PLUGIN_PATH')) . '/src/common/fields/custom-date-field/custom-date-field.php';
    }
}