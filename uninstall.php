<?php
/**
 * trigger uninstall of plugin
 * 
 * @package wp-pubg
*/


if ( ! defined('WP_UNINSTALL_PLUGIN') ) {
	die;
}


//access database via sql
global $wpdb;

$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}pubg_settings" );