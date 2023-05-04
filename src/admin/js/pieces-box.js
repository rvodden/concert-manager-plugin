/**
 * TODO: most of this needs refactoring because the code duplication is evil
 */
"use strict";



jQuery(document).ready(function($) {


    function getPiecesDataFromInputControl() {
        return JSON.parse($('#concert-pieces').val());
    }

    function populatePiecesTable() {
        const tbody = $('#the-list'); //TODO: need to consider supporting multiple list tables on a single page
        
    }

    jQuery("#dialog").dialog({
		autoOpen : false,
		buttons : [ {
			text : "add",
			icons : {
				primary : "ui-icon-plus"
			},
			click : function() {
				appendTableRow(jQuery("#pieces-table"),
						[++pieces_number, jQuery("#composer").val(),jQuery("#piece").val()]);
				jQuery(this).dialog("close");
			}
		} ]
	});


    // Add piece dialog
    function updateConcertPieces() {
        var pieces = [];
        $('table.custom-concert-table tbody tr').each(function() {
            var title = $(this).find('input[name="title"]').val();
            var composer = $(this).find('input[name="composer"]').val();
            pieces.push({title: title, composer: composer});
        });
        $('input[name="concert-pieces"]').val(JSON.stringify(pieces));
    }

    $('table.custom-concert-table').on('click', '.delete-row', function() {
        $(this).closest('tr').remove();
        updateConcertPieces();
    });

    $('.add-piece-button').on('click', function() {
        var $table = $('table.custom-concert-table');
        var $tbody = $table.find('tbody');
        var count = $tbody.find('tr').length;
        var $row = $('<tr>').appendTo($tbody);
        $('<td>').appendTo($row).html('<input type="text" name="title">');
        $('<td>').appendTo($row).html('<input type="text" name="composer">');
        $('<td>').appendTo($row).html('<a href="#" class="delete-row">Delete</a>');
        updateConcertPieces();
        return false;
    });

});