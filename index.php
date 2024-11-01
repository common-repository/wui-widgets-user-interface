<?php

/**
 * Plugin Name: WUI: Widgets User Interface
 * Plugin URI: https://inconver.com/
 * Description: Create custom widget areas (sidebars) and custom widget types.
 * Version: 1.0
 * Author: Inconver
 * Author URI: https://inconver.com/
 * Text Domain: wui
 * Domain Path: languages
 *
 * @category Widgets
 * @author Alex Ivanov
 * @version 1.0
 */

$wui_plugin_dir_path = plugin_dir_path( __FILE__ );
$wui_plugin_dir_url = plugin_dir_url( __FILE__ );
$wui_widget_types = '';

require_once $wui_plugin_dir_path . 'includes/wui_activator.php';

require_once $wui_plugin_dir_path . 'includes/admin/areas_page.php';
require_once $wui_plugin_dir_path . 'includes/admin/add_area_page.php';
require_once $wui_plugin_dir_path . 'includes/admin/area_functions.php';
require_once $wui_plugin_dir_path . 'includes/register_areas.php';

require_once $wui_plugin_dir_path . 'includes/admin/types_page.php';
require_once $wui_plugin_dir_path . 'includes/admin/add_type_page.php';
require_once $wui_plugin_dir_path . 'includes/admin/type_functions.php';
require_once $wui_plugin_dir_path . 'includes/register_widget_types.php';

register_activation_hook( __FILE__, 'wui_create_plugin_database_tables' );

?>