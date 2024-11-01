<?php
	

	add_action( 'wp_ajax_wui_add_type', 'wui_add_type_callback' );
	function wui_add_type_callback() {
		
		global $wui_plugin_dir_path, $wpdb;
		$data = $_POST['data'];
		$params = array();
		parse_str($data, $params);
		$answer = array();
		$save = true;

		if ($params['wui_fields']) {
			$params['wui_fields'] = json_encode($params['wui_fields']);
		}

		$timeparams = array();
		foreach ($params as $key => $value) {
			$timeparams[sanitize_text_field($key)] = sanitize_text_field($value);	
		}
		$params = $timeparams;

		if (!trim($params['wui_name'])) {
			$answer['wui_name'] = __('This field is required','wui');
			$save = false;
		}

		if (!trim($params['wui_system_name'])) {
			$answer['wui_system_name'] = __('This field is required','wui');
			$save = false;
		} elseif (preg_match("/[^A-Za-z]/", $params['wui_system_name'])) {
			$answer['wui_system_name'] = __('Only Latin letters','wui');
			$save = false;
		} else {
			$table_widget_types = $wpdb->prefix.'wui_widget_types';
			$wui_system_name = $params['wui_system_name'];
			$typeold = $wpdb->get_row("SELECT * FROM $table_widget_types WHERE wui_system_name = '$wui_system_name'");
			if ($typeold && $typeold->id != $params['id'] ) {
				$answer['wui_system_name'] = __('The system name must be unique','wui');
				$save = false;
			}
		}
		if ($save) {
			$params['wui_name'] = trim($params['wui_name']);
			$params['wui_system_name'] = trim($params['wui_system_name']);
			if ($params['wui_name']&&$params['wui_system_name']) {
				$table_widget_types = $wpdb->prefix.'wui_widget_types';
				$newdata = array();
				foreach ($params as $key => $value) {
					$newdata[$key] = $value;
				}
				if (!$newdata['id']) {
					unset($newdata['id']);
				}
				$row = $wpdb->replace( $table_widget_types, $newdata ); 

				$dir = WP_CONTENT_DIR.'/wui';
				if (!is_dir($dir)){
					mkdir($dir, 0755);
				}

				$fileLocation = WP_CONTENT_DIR.'/wui/'.$newdata['wui_system_name'].'.php';

				if (file_exists($fileLocation)) {
					file_put_contents($fileLocation, '');
				}

				$file = fopen($fileLocation,"w");

				$content = "<?php
				class ".$newdata['wui_system_name']." extends WP_Widget {

					function __construct() {
						parent::__construct(
							'".$newdata['wui_system_name']."', 
							'".$newdata['wui_name']."',
							array( 'description' => '".$newdata['wui_description']."' )
						);
					}

					public function widget( \$args, \$instance ) {
						global \$wui_plugin_dir_path;
						if (isset(\$instance['fields'])) {
							\$fields = \$instance['fields'];
						} else {
							\$fields = '';
						}

						\$template_url = get_template_directory();
						if (file_exists(\$template_url.'/widget_types/".$newdata['wui_system_name'].".php')) {
							include \$template_url.'/widget_types/".$newdata['wui_system_name'].".php';
						} else {
							include \$wui_plugin_dir_path.'views/widget.php';
						}

					}

					public function form( \$instance ) {
						global \$wui_plugin_dir_path, \$wui_widget_types;
						\$fields_time = \$wui_widget_types['".$newdata['wui_system_name']."']['wui_fields'];
						if (\$fields_time) {
							\$fields = json_decode(\$fields_time, true);
						} else {
							\$fields = '';
						}
						include \$wui_plugin_dir_path.'views/widget-admin.php';
					}

					public function update( \$new_instance, \$old_instance ) {
						\$instance = array();
						\$instance['title'] = ( ! empty( \$new_instance['title'] ) ) ? strip_tags( \$new_instance['title'] ) : '';
						\$instance['fields'] = \$new_instance['fields'];
						return \$new_instance;
					}
				}";
				fwrite($file,$content);
				fclose($file);

			}
		}

		echo json_encode($answer);

		wp_die();

	}


	add_action( 'wp_ajax_wui_delete_type', 'wui_delete_type_callback' );
	function wui_delete_type_callback() {
		
		$id = intval($_POST['id']);
		if ($id) {
			global $wpdb, $wui_plugin_dir_path;
			$table_widget_types = $wpdb->prefix.'wui_widget_types';
			$widget_type = $wpdb->get_row("SELECT * FROM $table_widget_types WHERE id = '$id'");
			$fileLocation = WP_CONTENT_DIR.'/wui/'.$widget_type->wui_system_name.'.php';
			if (file_exists($fileLocation)) {
				unlink($fileLocation);
			}
			$wpdb->delete( $table_widget_types, array( 'ID' => $id ) );
		}

		wp_die();
			
	}

	add_action( 'wp_ajax_wui_type_create_template', 'wui_type_create_template_callback' );
	function wui_type_create_template_callback() {
		
		$id = intval($_POST['id']);
		if ($id) {
			global $wpdb, $wui_plugin_dir_path;
			$table_widget_types = $wpdb->prefix.'wui_widget_types';
			$widget_type = $wpdb->get_row("SELECT * FROM $table_widget_types WHERE id = '$id'");
			if ($widget_type->wui_fields) {
				$fields = json_decode($widget_type->wui_fields);
			}
			$fileLocation = get_template_directory().'/widget_types/'.$widget_type->wui_system_name.'.php';
			if (!file_exists($fileLocation)) {
				$dir = get_template_directory().'/widget_types';
				if (!is_dir($dir)){
					mkdir($dir, 0755);
				}
				$file = fopen($fileLocation,"w");
$content = "<?php
\$title = apply_filters( 'widget_title', \$instance['title'] );
\$args['before_widget'];
\$args['before_title'];
\$title;
\$args['after_title'];
";
foreach ($fields as $key => $value) {
	if ($value->type=='textarea') {
$content .= "nl2br(\$fields['$key']['value']);
\$fields['$key']['type'];
";
		} else {
$content .= "\$fields['$key']['value'];
\$fields['$key']['type'];
";
		}
}
$content .= "\$args['after_widget'];
?>";
				fwrite($file,$content);
				fclose($file);
				_e('The file was created in the following way: '.get_template_directory_uri().'/widget_types/'.$widget_type->wui_system_name.'.php','wui');
			} else {
				_e('The file already exists in the following way: '.get_template_directory_uri().'/widget_types/'.$widget_type->wui_system_name.'.php','wui');
			}
			
		}

		wp_die();			
	}
		

?>