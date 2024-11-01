<?php

if( !function_exists( 'wui_add_type_page' ) ):
function wui_add_type_page() {
	add_submenu_page(
		null,
        __( 'Add widget type', 'wui' ),
        __( 'Add widget type', 'wui' ),
        'manage_options',
        'wui-add-type',
        'wui_add_type_page_callback'
	);
}
add_action( 'admin_menu', 'wui_add_type_page', 10 );
endif;

function wui_add_type_page_callback() {
	global $wui_plugin_dir_url;
	wp_enqueue_style( 'wui_admin', $wui_plugin_dir_url . 'includes/admin/css/wui_admin.css', array(), '1', 'all' );
	wp_enqueue_script( 'wui_add_type', $wui_plugin_dir_url . 'includes/admin/js/wui_admin.js', array( 'jquery'), '1', false );
	$id=''; $wui_name=''; $wui_system_name=''; $wui_description=''; $fields='';
	if ($_GET['id']) {
		global $wpdb;
		$table_widget_types = $wpdb->prefix.'wui_widget_types';
		$idtime = $_GET['id'];
		$typeold = $wpdb->get_row("SELECT * FROM $table_widget_types WHERE id = '$idtime'");
		if ($typeold) {
			$id=$typeold->id; $wui_name=$typeold->wui_name; $wui_system_name=$typeold->wui_system_name; $wui_description=$typeold->wui_description;
			if ($typeold->wui_fields) {
				$fields = json_decode($typeold->wui_fields,true);
			}
		}
	}
	?>
		<h2><?php _e( 'Add widget type', 'wui' ); ?></h2>
		<a href="<?php echo admin_url();?>themes.php?page=wui-types" class="wui_btn wui_btn_primary"><?php _e( 'Widget types', 'wui' ); ?></a>
		<form class="wui_form" method="post" action="<?php echo admin_url();?>themes.php?page=wui-types" id="wui_form_add_type">
			<input type="hidden" name="id" value="<?php echo $id; ?>">
			<div class="wui_form_row">
				<label class="wui-form-label" for="wui_name"><?php _e( 'Widget type name', 'wui' ); ?> <b>*</b></label>
				<input type="text" id="wui_name" name="wui_name" value="<?php echo $wui_name; ?>">
				<span class="wui_form_message"></span>
			</div>
			<div class="wui_form_row">
				<label class="wui-form-label" for="wui_system_name"><?php _e( 'Widget system name', 'wui' ); ?> <b>*</b></label>
				<?php if ($wui_system_name) { ?>
					<input type="text" id="wui_system_name" name="wui_system_name" value="<?php echo $wui_system_name; ?>" disabled="disabled">
				<?php } else { ?>
					<input type="text" id="wui_system_name" name="wui_system_name" value="<?php echo $wui_system_name; ?>">
				<?php } ?>
				<span class="wui_form_message"></span>
			</div>
			<div class="wui_form_row">
				<label class="wui-form-label" for="wui_description"><?php _e( 'Widget type description', 'wui' ); ?></label>
				<input type="text" id="wui_description" name="wui_description" value="<?php echo $wui_description; ?>">
				<span class="wui_form_message"></span>
			</div>
			<?php if ($fields) {
				foreach ($fields as $key => $value) {
			?>
				<div class="wui_form_row wui_field_row">
					<input type="hidden" name="wui_fields[<?php echo $key; ?>][type]" value="<?php echo $value['type']; ?>">
					<input type="hidden" name="wui_fields[<?php echo $key; ?>][label]" value="<?php echo $value['label']; ?>">
					Type: <?php echo $value['type']; ?>, label: <?php echo $value['label']; ?>, system name: <?php echo $key; ?> <a href="#" class="wui_remove_field">Remove</a>
				</div>
			<?php
				}
			} ?>
			<div class="wui_form_row wui_add_field_row">
				<select class="wui_field_type_select">
					<option value="text"><?php _e('text','wui'); ?></option>
					<option value="textarea"><?php _e('textarea','wui'); ?></option>
				</select>
				<input type="text" placeholder="Field label" class="wui_field_label_input">
				<input type="text" placeholder="Field system name" class="wui_field_system_name_input">
				<a href="#" class="wui_add_field"><?php _e('Add field','wui'); ?></a>
			</div>
			<div class="wui_form_row">
				<?php if ($id) { ?>
					<input type="submit" value="<?php _e( 'Save', 'wui' ); ?>" class="wui_btn wui_btn_primary">
				<?php } else { ?>
					<input type="submit" value="<?php _e( 'Create', 'wui' ); ?>" class="wui_btn wui_btn_primary">
				<?php } ?>
			</div>
		</form>
	<?php
}

?>