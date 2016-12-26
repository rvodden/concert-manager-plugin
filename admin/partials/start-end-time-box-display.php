<dl>
	<dt>
		<label for="concert-start-date"><?php _e( "Date:", 'Concert Start Date' ); ?></label>
	</dt>
	<dd>
		<input type="text" name="concert-start-date" id="concert-start-date" value="<?php echo isset($post_metadata['concert-start-date']) ? $post_metadata['concert-start-date'] : ''; ?>" size="30" />
	</dd>
	<dt>
		<label for="concert-start-time"><?php _e( "Start Time:", 'Concert Start Time' ); ?></label>
	</dt>
	<dd>
		<input type="text" name="concert-start-time" id="concert-start-time" value="<?php echo isset($post_metadata['concert-start-time']) ? $post_metadata['concert-start-time'] : ''; ?>" size="30" />
	</dd>
	<dt>
		<label for="concert-end-time"><?php _e( "End Time:", 'Concert End Time' ); ?></label>
	</dt>
	<dd>
		<input type="text" name="concert-end-time" id="concert-end-time" value="<?php echo isset($post_metadata['concert-end-time']) ? $post_metadata['concert-end-time'] : ''; ?>" size="30" />
	</dd>
</dl>