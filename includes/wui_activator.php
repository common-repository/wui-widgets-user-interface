<?php

function wui_create_plugin_database_tables()
{
    global $wpdb;

    $charset_collate = '';
    if ( ! empty( $wpdb->charset ) ) {
      $charset_collate = "DEFAULT CHARACTER SET {$wpdb->charset}";
    }
    if ( ! empty( $wpdb->collate ) ) {
      $charset_collate .= " COLLATE {$wpdb->collate}";
    }

    $wp_track_table = $wpdb->prefix . "wui_areas";
    if($wpdb->get_var( "show tables like '$wp_track_table'" ) != $wp_track_table) 
    {

        $sql = "CREATE TABLE $wp_track_table (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            wui_name tinytext NOT NULL,
            wui_id varchar(100) NOT NULL ,
            wui_description text NOT NULL,
            wui_widget_class varchar(100),
            wui_before_widget text,
            wui_after_widget text,
            wui_before_title text,
            wui_after_title text,
            wui_title_hide varchar(1),
            UNIQUE KEY id (id)
        ) $charset_collate;";

        require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );
        dbDelta($sql);

    }

    $wp_track_table = $wpdb->prefix . "wui_widget_types";
    if($wpdb->get_var( "show tables like '$wp_track_table'" ) != $wp_track_table) 
    {

        $sql = "CREATE TABLE $wp_track_table (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            wui_name tinytext NOT NULL,
            wui_system_name varchar(100) NOT NULL ,
            wui_description text,
            wui_fields text,
            UNIQUE KEY id (id)
        ) $charset_collate;";

        require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );
        dbDelta($sql);

    }
}

?>