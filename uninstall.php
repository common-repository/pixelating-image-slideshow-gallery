<?php
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit();
}

delete_option('pisg_title');
delete_option('pisg_maxsquare');
delete_option('pisg_duration');
delete_option('pisg_slidespeed');
delete_option('pisg_random');
delete_option('pisg_type');
 
// for site options in Multisite
delete_site_option('pisg_title');
delete_site_option('pisg_maxsquare');
delete_site_option('pisg_duration');
delete_site_option('pisg_slidespeed');
delete_site_option('pisg_random');
delete_site_option('pisg_type');

global $wpdb;
$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}pisg_superb_gallery");