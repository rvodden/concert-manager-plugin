/**
 * TODO: most of this needs refactoring because the code duplication is evil
 */
"use strict";
var pieces_number = 0;

function populatePiecesTable() {
	var table = jQuery("#pieces-table");
	console.log("Concert Pieces value:" + jQuery("#concert-pieces").val());
	var data = JSON.parse(jQuery("#concert-pieces").val());
	
	jQuery.each(data, function(rowIndex, r) {
		var row = jQuery("<tr/>");
		
		jQuery.each(r, function(colIndex, c) {
			row.append(jQuery("<td>").
					append(jQuery("<div>")).addClass("editable").
					text(c));
		});
		
		row = append_navigation_links(row);
		
		table.append(row);
		pieces_number++;
	});
	
	jQuery(".piece-delete").on("click", delete_piece);
	
	return table;
}

function delete_piece() {
    var tr = jQuery(this).closest('tr');
    tr.css("background-color","#FF3700");
    tr.fadeOut(400, function(){
        tr.remove();
    });
    pieces_number--;
    return false;
}

function appendTableRow(table, rowData) {
	var lastRow = jQuery('<tr/>').appendTo(table.find('tbody:last'));
	
	jQuery.each(rowData, function(colIndex, c) {
		lastRow.append(jQuery('<td/>').
				append(jQuery("<div>")).addClass("editable").
				text(c));
	});

	lastRow = append_navigation_links(lastRow);
	
	jQuery(".piece-delete").on("click", function() {
        var tr = jQuery(this).closest('tr');
        tr.css("background-color","#FF3700");
        tr.fadeOut(400, function(){
            tr.remove();
        });
        pieces_number--;
        return false;
    });
	
	return lastRow;
}

function append_navigation_links(row) {
	row.append(jQuery("<td>").append(
			jQuery("<span>").addClass("ui-icon ui-icon-arrowthick-1-n").addClass("piece-up")));
	row.append(jQuery("<td>").append(
			jQuery("<span>").addClass("ui-icon ui-icon-arrowthick-1-s").addClass("piece-down")));
	row.append(jQuery("<td>").append(
			jQuery("<span>").addClass("ui-icon ui-icon-closethick").addClass("piece-delete")));
	
	return row;
}

jQuery(document).ready(function() {
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

	jQuery("#open-dialog").click(function() {
		jQuery('#dialog').dialog('open');
	});

	jQuery(".piece-up").click(function() {
		jQuery("#pieces-table");
	});
	
	jQuery( '#post' ).submit( function() {
		var json_pieces = JSON.stringify(generatePiecesData());
		console.log(json_pieces);
		jQuery("#concert-pieces").val(json_pieces);
	});

	populatePiecesTable();
});

function generatePiecesData() {
	console.log("Generating Pieces Data");
	var data = [];
	var table = jQuery("#pieces-table");
    
	var body = table.find('tbody');
	body.find('tr').each(function (rowIndex, r) {
        var cols = [];
        cols.push(rowIndex+1);
        console.log("Row Number : " + (rowIndex + 1));
        jQuery(this).find('td').each(function (colIndex, c) {
        	if (colIndex == 1 || colIndex == 2) {
        		console.log(c.textContent);
        		cols.push(c.textContent);
        	}
        });
        data.push(cols);
    });
    
    return data;
}