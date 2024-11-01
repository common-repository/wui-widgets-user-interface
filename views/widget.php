<?php

	$title = apply_filters( 'widget_title', $instance['title'] );

	echo $args['before_widget'];

	if ( ! empty( $title ) )
		echo $args['before_title'] . $title . $args['after_title'];
	foreach ($fields as $key => $value) {
		if ($value['type']=='textarea') {
			echo nl2br($value['value']);
		} else {
			echo $value['value'];
		}
	}

	echo $args['after_widget'];

?>