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

function mobilegends_add_role() {
    $roles = new WP_Roles();
    $apply = array();

    // Ensure mobilegends role exists and is not locked out

    if( $role = $roles -> get_role( 'mobilegends' ) ) {
        $role -> has_cap('read') || $role -> add_cap('read');
    }

    // Else absence of mobilegends role indicates first run
    // By default allow full access for those who can manage_options

    else {
        $apply['mobilegends'] = $roles -> add_role(
            'mobilegends', 'MobiLegends', array(
            'read'       => true,
            'mobi_admin' => true
        ));
        foreach( $roles -> role_objects as $id => $role ) {
            if( $role -> has_cap('manage_options') ) {
                $apply[$id] = $role;
            }
        }
    }
}

function mobilegends_install() {
    //Add the option talbe in database

    global $wpdb;
    $wpdb -> query("CREATE TABLE IF NOT EXISTS {$wpdb -> prefix}mobilegends (options varchar(255))");

    //Add post types for custom pages and posts

    mobilegends_add_post_types();
    flush_rewrite_rules();

    //Add role and capabilyties to access the plugin

    mobilegends_add_role();
}
register_activation_hook( __FILE__, 'mobilegends_install' );

function mobilegends_deactivation() {
    unregister_post_type( 'team' );
    unregister_post_type( 'player' );
    unregister_post_type( 'camp' );
    unregister_post_type( 'season' );
    flush_rewrite_rules();

    mobilegends_uninstall();
}
register_deactivation_hook( __FILE__, 'mobilegends_deactivation' );

function mobilegends_uninstall() {
    global $wpdb;
    $wpdb -> query("DROP TABLE IF EXISTS {$wpdb -> prefix}mobilegends");

    $roles = new WP_Roles();
    $roles -> remove_role('mobilegends');
}
register_uninstall_hook( __FILE__, 'mobilegends_uninstall' );

require_once __DIR__ . '/admin/index.php';
