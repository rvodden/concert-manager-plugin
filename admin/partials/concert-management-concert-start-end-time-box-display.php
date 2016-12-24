<dl>
	<dt>
		<label for="concert_start_date"><?php _e( "Date:", 'Concert Start Date' ); ?></label>
	</dt>
	<dd>
		<input type="text" name="concert_start_date" id="concert_start_date" value="<?php echo $default_start_date; ?>" size="30" />
	</dd>
	<dt>
		<label for="concert_start_time"><?php _e( "Start Time:", 'Concert Start Time' ); ?></label>
	</dt>
	<dd>
		<input type="text" name="concert_start_time" id="concert_start_time" value="<?php echo $default_start_time; ?>" size="30" />
	</dd>
	<dt>
		<label for="concert_end_time"><?php _e( "End Time:", 'Concert End Time' ); ?></label>
	</dt>
	<dd>
		<input type="text" name="concert_end_time" id="concert_end_time" value="<?php echo $default_end_time; ?>" size="30" />
	</dd>
</dl>