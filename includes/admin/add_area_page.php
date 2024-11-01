<?php

if( !function_exists( 'wui_add_area_page' ) ):
function wui_add_area_page() {
	add_submenu_page(
		null,
        __( 'Add widget area', 'wui' ),
        __( 'Add widget area', 'wui' ),
        'manage_options',
        'wui-add-area',
        'wui_add_area_page_callback'
	);
}
add_action( 'admin_menu', 'wui_add_area_page', 10 );
endif;

function wui_add_area_page_callback() {
	global $wui_plugin_dir_url;
	wp_enqueue_style( 'wui_admin', $wui_plugin_dir_url . 'includes/admin/css/wui_admin.css', array(), '1', 'all' );
	wp_enqueue_script( 'wui_add_type', $wui_plugin_dir_url . 'includes/admin/js/wui_admin.js', array( 'jquery'), '1', false );
	$id=''; $wui_name=''; $wui_id=''; $wui_description=''; $wui_widget_class=''; $wui_before_widget=''; $wui_after_widget=''; $wui_before_title=''; $wui_after_title='';
	if ($_GET['id']) {
		global $wpdb;
		$table_area = $wpdb->prefix.'wui_areas';
		$idtime = $_GET['id'];
		$areaold = $wpdb->get_row("SELECT * FROM $table_area WHERE id = '$idtime'");
		if ($areaold) {
			$id=$areaold->id; $wui_name=$areaold->wui_name; $wui_id=$areaold->wui_id; $wui_description=$areaold->wui_description; $wui_widget_class=$areaold->wui_widget_class; $wui_before_widget=$areaold->wui_before_widget; $wui_after_widget=$areaold->wui_after_widget; $wui_before_title=$areaold->wui_before_title; $wui_after_title=$areaold->wui_after_title;
		}
	}

	?>
		<h2><?php _e( 'Add widget area', 'wui' ); ?></h2>
		<a href="<?php echo admin_url();?>themes.php?page=wui-areas" class="wui_btn wui_btn_primary"><?php _e( 'Widget areas', 'wui' ); ?></a>
		<form class="wui_form" method="post" action="<?php echo admin_url();?>themes.php?page=wui-areas" id="wui_form_add_area">
			<input type="hidden" name="id" value="<?php echo $id; ?>">
			<div class="wui_form_row">
				<label class="wui-form-label" for="wui_name"><?php _e( 'Widget area name', 'wui' ); ?> <b>*</b></label>
				<input type="text" id="wui_name" name="wui_name" value="<?php echo $wui_name; ?>">
				<span class="wui_form_message"></span>
			</div>
			<div class="wui_form_row">
				<label class="wui-form-label" for="wui_id"><?php _e( 'Widget area ID', 'wui' ); ?> <b>*</b></label>
				<?php if ($wui_id) { ?>
					<input type="text" id="wui_id" name="wui_id" value="<?php echo $wui_id; ?>" disabled="disabled">
				<?php } else { ?>
					<input type="text" id="wui_id" name="wui_id" value="<?php echo $wui_id; ?>">
				<?php } ?>
				<span class="wui_form_message"></span>
			</div>
			<div class="wui_form_row">
				<label class="wui-form-label" for="wui_description"><?php _e( 'Widget area description', 'wui' ); ?></label>
				<input type="text" id="wui_description" name="wui_description" value="<?php echo $wui_description; ?>">
				<span class="wui_form_message"></span>
			</div>
			<div class="wui_form_row">
				<label class="wui-form-label" for="wui_widget_class"><?php _e( 'Widget class', 'wui' ); ?></label>
				<input type="text" id="wui_widget_class" name="wui_widget_class" value="<?php echo $wui_widget_class; ?>">
				<span class="wui_form_message"></span>
			</div>
			<div class="wui_form_row">
				<label class="wui-form-label" for="wui_before_widget"><?php _e( 'HTML before widget', 'wui' ); ?></label>
				<input type="text" id="wui_before_widget" name="wui_before_widget" value="<?php echo $wui_before_widget; ?>">
				<span class="wui_form_message"></span>
			</div>
			<div class="wui_form_row">
				<label class="wui-form-label" for="wui_after_widget"><?php _e( 'HTML after widget', 'wui' ); ?></label>
				<input type="text" id="wui_after_widget" name="wui_after_widget" value="<?php echo $wui_after_widget; ?>">
				<span class="wui_form_message"></span>
			</div>
			<div class="wui_form_row">
				<label class="wui-form-label" for="wui_before_title"><?php _e( 'HTML before title', 'wui' ); ?></label>
				<input type="text" id="wui_before_title" name="wui_before_title" value="<?php echo $wui_before_title; ?>">
				<span class="wui_form_message"></span>
			</div>
			<div class="wui_form_row">
				<label class="wui-form-label" for="wui_after_title"><?php _e( 'HTML after title', 'wui' ); ?></label>
				<input type="text" id="wui_after_title" name="wui_after_title" value="<?php echo $wui_after_title; ?>">
				<span class="wui_form_message"></span>
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