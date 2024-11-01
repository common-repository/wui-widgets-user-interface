<?php
	 
	function wui_register_widget_types() {
		global $wpdb, $wui_widget_types, $wui_plugin_dir_path;
		$table_name = $wpdb->prefix . "wui_widget_types";
		$sql = "SELECT * FROM $table_name";
		$wui_widget_types_new = array();
		$wui_widget_types_time = $wpdb->get_results( $sql, 'ARRAY_A');
		foreach ($wui_widget_types_time as $row) {
			$wui_widget_types_new[$row['wui_system_name']] = $row;
		}
		$wui_widget_types = $wui_widget_types_new;
		foreach ($wui_widget_types_new as $key => $value) {
			if (file_exists(WP_CONTENT_DIR.'/wui/'.$key.'.php')) {
				require_once WP_CONTENT_DIR.'/wui/'.$key.'.php';
				register_widget( $key );
			}
		}
		
	}
	add_action( 'widgets_init', 'wui_register_widget_types' );

?>