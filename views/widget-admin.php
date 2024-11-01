<p>
	<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title','wui'); ?></label> 
	<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $instance[ 'title' ] ); ?>" />
</p>
<?php foreach ($fields as $key => $value) { ?>
	<p>
		<label for="<?php echo $this->get_field_id( $key ); ?>"><?php echo $value['label']; ?>:</label> 
		<?php if ($value['type']=='text'){ ?>
			<input class="widefat" id="<?php echo $this->get_field_id( $key ); ?>" name="<?php echo $this->get_field_name( 'fields['.$key.'][value]' ); ?>" type="text" value="<?php echo $instance['fields'][$key]['value']; ?>" />
		<?php } elseif ($value['type']=='textarea') { ?>
			<textarea name="<?php echo $this->get_field_name( 'fields['.$key.'][value]' ); ?>" class="widefat text wp-editor-area" cols="30" rows="10"><?php echo $instance['fields'][$key]['value']; ?></textarea>
		<?php } ?>
		
		<input type="hidden" name="<?php echo $this->get_field_name( 'fields['.$key.'][type]' ); ?>" value="<?php echo $value['type']; ?>">
	</p>
<?php } ?>
<p><?php _e('You can find out more about this plugin by clicking this','wui'); ?> <a href="http://inconver.com/wui/" target="blank"><?php _e('link','wui'); ?></a></p>