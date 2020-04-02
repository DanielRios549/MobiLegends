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

function mobi_add_post_types() {
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
add_action( 'init', 'mobi_add_post_types' );

function mobi_add_role() {
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

function mobi_db_tables() {
    $tables = array(
        'mobi_options',
        'mobi_seasons',
        'mobi_teams',
        'mobi_players',
        'mobi_matches'
    );
    return $tables;
}

function mobi_install() {
    //Add the option talbe in database
    global $wpdb;
    $databases = mobi_db_tables();

    foreach ($databases as $database) {
        $wpdb -> query("CREATE TABLE IF NOT EXISTS {$wpdb -> prefix}{$database} (options varchar(255))");
    }

    //Add post types for custom pages and posts

    mobi_add_post_types();
    flush_rewrite_rules();

    //Add role and capabilyties to access the plugin

    mobi_add_role();
}
register_activation_hook( __FILE__, 'mobi_install' );

function mobi_deactivation() {
    unregister_post_type('team');
    unregister_post_type('player');
    unregister_post_type('camp');
    unregister_post_type('season');
    flush_rewrite_rules();

    mobi_uninstall();
}
register_deactivation_hook( __FILE__, 'mobi_deactivation' );

function mobi_uninstall() {
    global $wpdb;
    $databases = mobi_db_tables();

    foreach ($databases as $database) {
        $wpdb -> query("DROP TABLE IF EXISTS {$wpdb -> prefix}{$database}");
    }

    $roles = new WP_Roles();
    $roles -> remove_role('mobilegends');
}
register_uninstall_hook( __FILE__, 'mobi_uninstall' );

require_once __DIR__ . '/admin/index.php';

add_action( 'activated_plugin', 'mobi_save_error', 10, 2 );

function mobi_save_error( $plugin, $network_wide ) {
    file_put_contents(
        WP_CONTENT_DIR. '/error_activation.html',
        $plugin . ob_get_contents()
    );
    //update_option( 'plugin_error',  ob_get_contents() );
}