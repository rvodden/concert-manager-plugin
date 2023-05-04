function populateCustomPostsList() {
	var data = {
		'action': 'get_posts',
        '_wpnonce': ajax_object.nonce
	};
    jQuery.post(ajax_object.ajax_url, data, function(posts) {
        const sel = jQuery("select#" + ajax_object.select_id);
        sel.find('option').remove().end();
        jQuery.each(posts, function(i, post) {  
            sel.append(jQuery('<option>', {
                value: post.ID,
                text: post.post_title,
            }))
        });
	}, 'json');
}

function addCustomPostToTable(post_id) {
    var data = {
        'action': 'get_post',
        'post_id': post_id
    }
    let input = jQuery("input#" + ajax_object.input_id);
    let values = JSON.parse(input.val());
    values.push(post_id);
    input.val(JSON.stringify(values));
}

jQuery(document).ready(function($) {
    // initalise the dialog
    $('#concert-pieces-dialog').dialog({
        title: 'Please Select',
        dialogClass: 'concert-pieces-dialog',
        autoOpen: false,
        draggable: false,
        width: 'auto',
        modal: true,
        resizable: false,
        closeOnEscape: true,
        position: {
        my: "center",
        at: "center",
        of: window
        },
        open: function () {
            populateCustomPostsList();
            // close dialog by clicking the overlay behind it
            $('.ui-widget-overlay').bind('click', function(){
                $('#concert-pieces-dialog').dialog('close');
            })
        },
        create: function () {
            // style fix for WordPress admin
            $('.ui-dialog-titlebar-close').addClass('ui-button');
        },
    });

    // bind a button or a link to open the dialog
    $('button.open-pieces-dialog').click(function(e) {
        e.preventDefault();
        $('#concert-pieces-dialog').dialog('open');
    });

    $('button#concert-pieces-select-button').click(function(e) {
        e.preventDefault();
        addCustomPostToTable(jQuery('select#concert-pieces-select').find(":selected").val());
        $('#concert-pieces-dialog').dialog('close');
    });

});