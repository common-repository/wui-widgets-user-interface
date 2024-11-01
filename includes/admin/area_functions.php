<?php
	add_action( 'wp_ajax_wui_add_area', 'wui_add_area_callback' );
	function wui_add_area_callback() {
		global $wpdb;
		$data = $_POST['data'];
		$params = array();
		parse_str($data, $params);
		$answer = array();
		$save = true;


		$timeparams = array();

		foreach ($params as $key => $value) {
			$timeparams[sanitize_text_field($key)] = sanitize_text_field($value);
		}

		$params = $timeparams;

		if (!trim($params['wui_name'])) {
			$answer['wui_name'] = __('This field is required','wui');
			$save = false;
		}

		if (!trim($params['wui_id'])) {
			$answer['wui_id'] = __('This field is required','wui');
			$save = false;
		} elseif (preg_match("/[^A-Za-z][^A-Za-z0-9]/", $params['wui_id'])) {
			$answer['wui_id'] = __('Only Latin letters and numbers','wui');
			$save = false;
		} else {
			$table_area = $wpdb->prefix.'wui_areas';
			$wui_id = $params['wui_id'];
			$areaold = $wpdb->get_row("SELECT * FROM $table_area WHERE wui_id = '$wui_id'");
			if ($areaold && $areaold->id != $params['id'] ) {
				$answer['wui_id'] = __('The sidebar ID must be unique','wui');
				$save = false;
			}
		}


		if ($save) {
			$params['wui_name'] = trim($params['wui_name']);
			$params['wui_id'] = trim($params['wui_id']);
			if ($params['wui_name']&&$params['wui_id']) {
				$wp_track_table = $wpdb->prefix . "wui_areas";
				$newdata = array();
				foreach ($params as $key => $value) {
					$newdata[$key] = $value;
				}
				if (!$newdata['id']) {
					unset($newdata['id']);
				}
				$row = $wpdb->replace( $wp_track_table, $newdata ); 
			}
		}

		echo json_encode($answer);

		wp_die();
			
	}

	add_action( 'wp_ajax_wui_delete_area', 'wui_delete_area_callback' );
	function wui_delete_area_callback() {
		
		$id = intval($_POST['id']);
		if ($id) {
			global $wpdb;
			$table_area = $wpdb->prefix.'wui_areas';
			$wpdb->delete( $table_area, array( 'ID' => $id ) );
		}

		wp_die();
			
	}
		

?>