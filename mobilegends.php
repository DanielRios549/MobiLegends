<?php
/**
 * Plugin Name: MobiLegends
 * Description: This is a plugin made especially for Mobile Legends League
 * Version: 0.1
 * Author: Daniel Rios
 * Require at least: 5.4
 * Require PHP: 7.4
 * 
*/

function mobilegends_add_post_types() {
    register_post_type( 'team', array('labels' => array(
        'name'          => __('Teams', 'mobilegends'),
        'singular_name' => __('Team', 'mobilegends'),
    ), 'public'         => 'true') );
    register_post_type( 'player', array('labels' => array(
        'name'          => __('Players', 'mobilegends'),
        'singular_name' => __('Player', 'mobilegends'),
    ), 'public'         => 'true') );
    register_post_type( 'camp', array('labels' => array(
        'name'          => __('Camps', 'mobilegends'),
        'singular_name' => __('Camp', 'mobilegends'),
    ), 'public'         => 'true') );
    register_post_type( 'season', array('labels' => array(
        'name'          => __('Seasons', 'mobilegends'),
        'singular_name' => __('Season', 'mobilegends'),
    ), 'public'         => 'true') );
}
add_action( 'init', 'mobilegends_add_post_types' );

function mobilegends_install() {
    global $wpdb;
    $wpdb -> query("CREATE TABLE IF NOT EXISTS {$wpdb -> prefix}mobilegends (options varchar(255))");
    mobilegends_add_post_types();
    flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'mobilegends_install' );

function mobilegends_deactivation() {
    unregister_post_type( 'team' );
    unregister_post_type( 'player' );
    unregister_post_type( 'camp' );
    unregister_post_type( 'season' );
    flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, mobilegends_deactivation() );

function mobilegends_uninstall() {
    global $wpdb;
    $wpdb -> query("DROP TABLE IF EXISTS {$wpdb -> prefix}mobilegends");
}
register_uninstall_hook( __FILE__, 'mobilegends_uninstall' );
