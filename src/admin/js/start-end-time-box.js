"use strict";
jQuery(document).ready(
    function () {
        jQuery('#concert-start-date').datepicker(
            {
                dateFormat : 'dd/m/yy'
            }
        );

        jQuery('#concert-start-time').timepicker(
            {
                timeFormat: 'h:mm p',
                interval: 15,
                minTime: '12:00am',
                maxTime: '11:45pm',
                startTime: '12:00am',
                dynamic: false,
                dropdown: true,
                scrollbar: true
            }
        );

        jQuery('#concert-end-time').timepicker(
            {
                timeFormat: 'h:mm p',
                interval: 15,
                minTime: '12:00am',
                maxTime: '11:45pm',
                startTime: '12:00am',
                dynamic: false,
                dropdown: true,
                scrollbar: true
            }
        );
    }
);
