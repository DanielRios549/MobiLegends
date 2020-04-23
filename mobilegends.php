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

require_once __DIR__ . '/includes/functions.php';

function mobi_load_textdomain() {
    load_plugin_textdomain(
        'mobilegends',
        false,
        dirname(plugin_basename(__FILE__)) . '/languages'
    );
}

add_action( 'init', 'mobi_load_textdomain' );

function mobi_add_post_types() {
    register_post_type( 'mobi_team', array('labels' => array(
        'name'          => __('Teams', 'mobilegends'),
        'singular_name' => __('Team', 'mobilegends'),
    ), 'public'         => 'true') );
    register_post_type( 'mobi_player', array('labels' => array(
        'name'          => __('Players', 'mobilegends'),
        'singular_name' => __('Player', 'mobilegends'),
    ), 'public'         => 'true') );
    register_post_type( 'mobi_match', array('labels' => array(
        'name'          => __('Matches', 'mobilegends'),
        'singular_name' => __('Match', 'mobilegends'),
    ), 'public'         => 'true') );
    register_post_type( 'mobi_season', array('labels' => array(
        'name'          => __('Seasons', 'mobilegends'),
        'singular_name' => __('Season', 'mobilegends'),
    ), 'public'         => 'true') );
    register_post_type( 'mobi_camp', array('labels' => array(
        'name'          => __('Camps', 'mobilegends'),
        'singular_name' => __('Camp', 'mobilegends'),
    ), 'public'         => 'true') );
}

//add_action( 'init', 'mobi_add_post_types' );

function mobi_register_taxonomies() {
    $labels = [
        'name'              => __('Seasons', 'mobilegends'),
        'singular_name'     => __('Season', 'mobilegends'),
        'search_items'      => __('Search Seasons', 'mobilegends'),
        'all_items'         => __('All Seasons', 'mobilegends'),
        'parent_item'       => __('Parent Season', 'mobilegends'),
        'parent_item_colon' => __('Parent Season:', 'mobilegends'),
        'edit_item'         => __('Edit Season', 'mobilegends'),
        'update_item'       => __('Update Season', 'mobilegends'),
        'add_new_item'      => __('Add New Season', 'mobilegends'),
        'new_item_name'     => __('New Season Name', 'mobilegends'),
        'menu_name'         => __('Season', 'mobilegends'),
    ];
    $args = [
        'hierarchical'      => false,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => ['slug' => 'season'],
    ];
    register_taxonomy('mobi_season', ['mobi_camp'], $args);
}

//add_action( 'init', 'mobi_register_taxonomies' );

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

function mobi_install() {
    //Add the option talbe in database
    global $wpdb;
    $databases_sufixes = mobi_get_tables_sufixes();

    // Add table and commun columns

    foreach ($databases_sufixes as $database) {
        $primary_key = $database . '_id';
        $name = $database . '_name';
        $value = 'display_name';

        if ($database == 'option') {
            $value = 'option_value';
        }
        if ($database == 'match') {
            $database = $database . 'e';
        }

        $wpdb -> query(
            "CREATE TABLE IF NOT EXISTS {$wpdb -> prefix}mobi_{$database}s (
                {$primary_key} int AUTO_INCREMENT primary key NOT NULL,
                {$name} varchar(255),
                {$value} varchar(255)
            )"
        );
    }

    //Add columns especific to each table

    $wpdb -> query(
        "ALTER TABLE {$wpdb -> prefix}mobi_seasons ADD (
            season_year YEAR NOT NULL,
            camp int,
            FOREIGN KEY (camp) REFERENCES {$wpdb -> prefix}mobi_camps(camp_id)
        )"
    );
    $wpdb -> query(
        "ALTER TABLE {$wpdb -> prefix}mobi_matches ADD (
            match_date DATE,
            season int,
            FOREIGN KEY (season) REFERENCES {$wpdb -> prefix}mobi_seasons(season_id)
        )"
    );
    $wpdb -> query(
        "ALTER TABLE {$wpdb -> prefix}mobi_teams ADD (
            year YEAR,
            next_match int,
            FOREIGN KEY (next_match) REFERENCES {$wpdb -> prefix}mobi_matches(match_id)
        )"
    );
    $wpdb -> query(
        "ALTER TABLE {$wpdb -> prefix}mobi_players ADD (
            date DATE,
            current_team int,
            FOREIGN KEY (current_team) REFERENCES {$wpdb -> prefix}mobi_teams(team_id)
        )"
    );

    $wpdb -> insert(mobi_get_option_table(), array(
        'option_name'  => 'default_data_installed',
        'option_value' => 0
    ));

    //Add post types for custom pages and posts

    mobi_add_post_types();
    flush_rewrite_rules();

    //Add role and capabilyties to access the plugin

    mobi_add_role();
}
register_activation_hook( __FILE__, 'mobi_install' );

function mobi_activation_redirect($plugin) {
    if($plugin == plugin_basename(__FILE__)) {
        exit(wp_redirect(admin_url('admin.php?page=mobi-dashboard')));
    }
}

//add_action( 'activated_plugin', 'mobi_activation_redirect' );

function mobi_deactivation() {
    unregister_post_type('team');
    unregister_post_type('player');
    unregister_post_type('match');
    unregister_post_type('season');
    flush_rewrite_rules();

    mobi_uninstall();
}
register_deactivation_hook( __FILE__, 'mobi_deactivation' );

function mobi_uninstall() {
    global $wpdb;
    $databases = mobi_get_tables_sufixes();

    foreach ($databases as $database) {
        if ($database == 'match') {
            $database = $database . 'e';
        }
        $wpdb -> query("DROP TABLE IF EXISTS {$wpdb -> prefix}mobi_{$database}s");
    }

    $roles = new WP_Roles();
    $roles -> remove_role('mobilegends');
}
register_uninstall_hook( __FILE__, 'mobi_uninstall' );

require_once __DIR__ . '/includes/dash_data.php';
require_once __DIR__ . '/admin/pages.php';

function mobi_save_error( $plugin, $network_wide ) {
    file_put_contents(
        WP_CONTENT_DIR. '/error_activation.html',
        $plugin . ob_get_contents()
    );
    //update_option( 'plugin_error',  ob_get_contents() );
}

add_action( 'activated_plugin', 'mobi_save_error', 10, 2 );