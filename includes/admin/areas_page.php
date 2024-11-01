<?php

if( !function_exists( 'wui_areas_page' ) ):
function wui_areas_page() {
	add_submenu_page(
		'themes.php',
        __( 'Widget areas', 'wui' ),
        __( 'Widget areas', 'wui' ),
        'manage_options',
        'wui-areas',
        'wui_areas_page_callback'
	);
}
add_action( 'admin_menu', 'wui_areas_page', 10 );
endif;

function wui_areas_page_callback() {
	global $wui_plugin_dir_url;
	wp_enqueue_style( 'wui_admin', $wui_plugin_dir_url . 'includes/admin/css/wui_admin.css', array(), '1', 'all' );
	wp_enqueue_script( 'wui_add_type', $wui_plugin_dir_url . 'includes/admin/js/wui_admin.js', array( 'jquery'), '1', false );
	global $wpdb;
	$table_name = $wpdb->prefix . "wui_areas";
	$sql = "SELECT * FROM $table_name";
	$areas = $wpdb->get_results( $sql, 'OBJECT');
	?>
		<h2><?php _e( 'Widget areas', 'wui' ); ?></h2>
		<a href="<?php echo admin_url();?>themes.php?page=wui-add-area" class="wui_btn wui_btn_primary"><?php _e( 'Add widget area', 'wui' ); ?></a>
		<div class="wui_reks_desc">
			<?php _e('You can find out more about this plugin by clicking this','wui'); ?> <a href="http://inconver.com/wui/" target="blank"><?php _e('link','wui'); ?></a>
		</div>
		<table class="wui_table">
			<thead>
				<tr>
					<th><?php _e( 'Sn', 'wui' ); ?></th>
					<th><?php _e( 'Name', 'wui' ); ?></th>
					<th><?php _e( 'Id', 'wui' ); ?></th>
					<th><?php _e( 'Description', 'wui' ); ?></th>
					<th><?php _e( 'Widget class', 'wui' ); ?></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($areas as $row) { ?>
					<tr>
						<td><?php echo $row->id; ?></td>
						<td><?php echo $row->wui_name; ?></td>
						<td><?php echo $row->wui_id; ?></td>
						<td><?php echo $row->wui_description; ?></td>
						<td><?php echo $row->wui_widget_class; ?></td>
						<td><a href="#" data-id="<?php echo $row->wui_id; ?>" class="get_code_area">Get code</a> / <a href="<?php echo admin_url();?>themes.php?page=wui-add-area&id=<?php echo $row->id; ?>">Edit</a> / <a href="#" data-id="<?php echo $row->id; ?>" class="wui_delete_area">Delete</a></td>
					</tr>
				<?php } ?>
				<?php if (!$areas) { echo '<td colspan="6" class="wui_table_empty">'.__('The list is empty','wui').'</td>'; } ?>
			</tbody>
		</table>
	<?php
}

?>