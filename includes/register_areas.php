<?php

	add_action( 'widgets_init', 'wui_register_areas' );
	function wui_register_areas(){

		global $wpdb;
		$table_name = $wpdb->prefix . "wui_areas";
		$sql = "SELECT * FROM $table_name";
		$areas = $wpdb->get_results( $sql, 'OBJECT');

		foreach ($areas as $area) {
			register_sidebar( array(
				'name'          => $area->wui_name,
				'id'            => $area->wui_id,
				'description'   => $area->wui_description,
				'class'         => $area->wui_widget_class,
				'before_widget' => $area->wui_before_widget,
				'after_widget'  => $area->wui_after_widget."\n",
				'before_title'  => $area->wui_before_title,
				'after_title'   => $area->wui_after_title."\n",
			) );

		}
	}

?>