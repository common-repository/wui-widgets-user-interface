<?php

if( !function_exists( 'wui_types_page' ) ):
function wui_types_page() {
	add_submenu_page(
		'themes.php',
        __( 'Widget types', 'wui' ),
        __( 'Widget types', 'wui' ),
        'manage_options',
        'wui-types',
        'wui_types_page_callback'
	);
}
add_action( 'admin_menu', 'wui_types_page', 10 );
endif;

function wui_types_page_callback() {
	global $wui_plugin_dir_url;
	wp_enqueue_style( 'wui_admin', $wui_plugin_dir_url . 'includes/admin/css/wui_admin.css', array(), '1', 'all' );
	wp_enqueue_script( 'wui_add_type', $wui_plugin_dir_url . 'includes/admin/js/wui_admin.js', array( 'jquery'), '1', false );

	if ($_POST) {
		require_once __DIR__ . '/add_type.php';
	}
	global $wpdb;
	$table_name = $wpdb->prefix . "wui_widget_types";
	$sql = "SELECT * FROM $table_name";
	$types = $wpdb->get_results( $sql, 'OBJECT');
	?>
		<h2><?php _e( 'Widget types', 'wui' ); ?></h2>
		<a href="<?php echo admin_url();?>themes.php?page=wui-add-type" class="wui_btn wui_btn_primary"><?php _e( 'Add widget type', 'wui' ); ?></a>
		<div class="wui_reks_desc">
			<?php _e('You can find out more about this plugin by clicking this','wui'); ?> <a href="http://inconver.com/wui/" target="blank"><?php _e('link','wui'); ?></a>
		</div>
		<table class="wui_table">
			<thead>
				<tr>
					<th><?php _e( 'Sn', 'wui' ); ?></th>
					<th><?php _e( 'Name', 'wui' ); ?></th>
					<th><?php _e( 'System name', 'wui' ); ?></th>
					<th><?php _e( 'Description', 'wui' ); ?></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($types as $row) { ?>
					<tr>
						<td><?php echo $row->id; ?></td>
						<td><?php echo $row->wui_name; ?></td>
						<td><?php echo $row->wui_system_name; ?></td>
						<td><?php echo $row->wui_description; ?></td>
						<td><a href="#" alt="<?php _e('Create a template file in the WUI folder of the active theme','wui'); ?>" data-id="<?php echo $row->id; ?>" class="wui_type_create_template"><?php _e('Create template file','wui'); ?></a> / <a href="<?php echo admin_url();?>themes.php?page=wui-add-type&id=<?php echo $row->id; ?>"><?php _e('Edit','wui'); ?></a> / <a href="#" data-id="<?php echo $row->id; ?>" class="wui_delete_type"><?php _e('Delete','wui'); ?></a></td>
					</tr>
				<?php } ?>
				<?php if (!$types) { echo '<td colspan="6" class="wui_table_empty">'.__('The list is empty','wui').'</td>'; } ?>
			</tbody>
		</table>
	<?php
}

?>