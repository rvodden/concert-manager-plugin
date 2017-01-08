<table id="pieces-table">
	<thead>
		<tr>
			<td>Order</td>
			<td>Composer</td>
			<td>Piece</td>
		</tr>
	</thead>
	<tbody>
	</tbody>
</table>
<input name="concert-pieces" id="concert-pieces" type="hidden" value='<?php echo isset($post_metadata['concert-pieces']) ? $post_metadata['concert-pieces'] : ''; ?>'/>
<a id="open-dialog">add piece...</a>

<div id="dialog" title="Add a piece to the concert...">
	<dl>
		<dt>
			<label for="composer">Composer: </label>
		</dt>
		<dd>
			<input name="composer" id="composer"/>
		</dd>
		<dt>
			<label for="piece">Piece: </label>
		</dt>
		<dd>
			<input name="piece" id="piece"/>
		</dd>
	</dl>
</div>