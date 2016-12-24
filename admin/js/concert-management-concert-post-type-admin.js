jQuery(document).ready(function() {
	jQuery('#concert_start_date').datepicker({
		dateFormat : 'dd/m/yy'
	});
	
	jQuery('#concert_start_time').timepicker({
	    timeFormat: 'h:mm p',
	    interval: 15,
	    minTime: '12:00am',
	    maxTime: '11:45pm',
	    defaultTime: '19:30',
	    startTime: '12:00am',
	    dynamic: false,
	    dropdown: true,
	    scrollbar: true
	});
	
	jQuery('#concert_end_time').timepicker({
	    timeFormat: 'h:mm p',
	    interval: 15,
	    minTime: '12:00am',
	    maxTime: '11:45pm',
	    defaultTime: '9:45pm',
	    startTime: '12:00am',
	    dynamic: false,
	    dropdown: true,
	    scrollbar: true
	});
});