<dl>
    <dt>
        <label for="concert-start-date"> <?php _e('Date:', 'Concert Start Date'); ?></label>
    </dt>
    <dd>
        <input type="text" name="concert-start-date" id="concert-start-date"
            value="<?php echo isset($metadata['concert-start-date']) ? $metadata['concert-start-date'] : ''; ?>" size="30" />
    </dd>
    <dt>
        <label for="concert-start-time"> <?php _e('Date:', 'Concert Start Time'); ?></label>
    </dt>
    <dd>
        <input type="text" name="concert-start-time" id="concert-start-time"
            value="<?php echo isset($metadata['concert-start-date']) ? $metadata['concert-start-date'] : ''; ?>" size="30" />
    </dd>
</dl>
