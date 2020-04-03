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
    register_post_type( 'match', array('labels' => array(
        'name'          => __('Matches', 'mobilegends'),
        'singular_name' => __('Match', 'mobilegends'),
    ), 'public'         => 'true') );
    register_post_type( 'season', array('labels' => array(
        'name'          => __('Seasons', 'mobilegends'),
        'singular_name' => __('Season', 'mobilegends'),
    ), 'public'         => 'true') );

    load_plugin_textdomain(
        'mobilegends',
        false,
        dirname(plugin_basename(__FILE__)) . '/languages'
    );
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
        'option',
        'player',
        'team',
        'match',
        'season'
    );
    return $tables;
}

function mobi_default_data($table) {
    global $wpdb;

    //Season is only one by default, so a foreach is not necessary

    $wpdb -> insert($table[4],
        array(
            'name'         => 'Champions',
            'display_name' => 'Champions Season',
            'season_year'  => 2020
        )
    );

    $matches = array(
        array(
            'First',
            'First',
            '2020-04-12',
            1
        ),
        array(
            'Second',
            'Second',
            '2020-04-13',
            1
        )
    );
    $teams = array(
        array(
            'Uranus',
            'Uranus',
            '2010',
            1
        ),
        array(
            'Cast',
            'Cast',
            '2005',
            1
        ),
        array(
            'Noobs Win',
            'Noobs Win',
            '2010',
            2
        ),
        array(
            'WP Togueter',
            'WP Togueter',
            '2019',
            2
        )
    );
    $players = array(
        array(
            'Daniel RV',
            'Daniel',
            '1995-12-09',
            1,
        ),
        array(
            'Carlos BC',
            'Carlos',
            '1993-04-12',
            1,
        ),
        array(
            'Denis ET',
            'Denis',
            '1996-04-12',
            1,
        ),
        array(
            'Santos PT',
            'Santos',
            '1997-06-12',
            1,
        ),
        array(
            'Carmo TT',
            'Carmo',
            '2000-06-03',
            2,
        ),
        array(
            'Santo INC',
            'Santinho',
            '1999-08-26',
            2,
        ),
        array(
            'Inacio do peixe',
            'Pixeiro',
            '1996-11-30',
            2,
        ),
        array(
            'GG Soares',
            'GSoares',
            '2201-07-12',
            2,
        ),
    );

    foreach($matches as $key => $match) {
        $wpdb -> insert($table[3],
            array(
                'name'         => $match[0],
                'display_name' => $match[1],
                'match_date'   => $match[2],
                'season'       => $match[3]
            )
        );
    }
    foreach($teams as $key => $team) {
        $wpdb -> insert($table[2],
            array(
                'name'         => $team[0],
                'display_name' => $team[1],
                'year'         => $team[2],
                'next_match'   => $team[3]
            )
        );
    }
    foreach($players as $key => $player) {
        $wpdb -> insert($table[1],
            array(
                'name'         => $player[0],
                'display_name' => $player[1],
                'date'         => $player[2],
                'current_team'         => $player[3]
            )
        );
    }
}

function mobi_install() {
    //Add the option talbe in database
    global $wpdb;
    $databases = array();
    $databases_sufixes = mobi_db_tables();

    // Add table and commun columns

    foreach ($databases_sufixes as $database) {
        $primary_key = $database . '_id';

        if ($database == 'match') {
            $database = $database . 'e';
        }

        $wpdb -> query(
            "CREATE TABLE IF NOT EXISTS {$wpdb -> prefix}mobi_{$database}s (
                {$primary_key} int AUTO_INCREMENT primary key NOT NULL,
                name varchar(255),
                display_name varchar(255)
            )"
        );
        array_push($databases, $wpdb -> prefix . 'mobi_' . $database . 's');
    }
    //print_r($databases);

    //Add columns especific to each table

    $wpdb -> query(
        "ALTER TABLE {$wpdb -> prefix}mobi_seasons ADD (
            season_year YEAR NOT NULL
        )"
    );
    $wpdb -> query(
        "ALTER TABLE {$wpdb -> prefix}mobi_matches ADD (
            match_date DATE NOT NULL,
            season int,
            FOREIGN KEY (season) REFERENCES {$wpdb -> prefix}mobi_seasons(season_id)
        )"
    );
    $wpdb -> query(
        "ALTER TABLE {$wpdb -> prefix}mobi_teams ADD (
            year YEAR NOT NULL,
            next_match int,
            FOREIGN KEY (next_match) REFERENCES {$wpdb -> prefix}mobi_matches(match_id)
        )"
    );
    $wpdb -> query(
        "ALTER TABLE {$wpdb -> prefix}mobi_players ADD (
            date DATE NOT NULL,
            current_team int,
            FOREIGN KEY (current_team) REFERENCES {$wpdb -> prefix}mobi_teams(team_id)
        )"
    );

    //Add default data to begin to test

    mobi_default_data($databases);

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
    unregister_post_type('match');
    unregister_post_type('season');
    flush_rewrite_rules();

    mobi_uninstall();
}
register_deactivation_hook( __FILE__, 'mobi_deactivation' );

function mobi_uninstall() {
    global $wpdb;
    $databases = mobi_db_tables();

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

add_action( 'activated_plugin', 'mobi_save_error', 10, 2 );

function mobi_save_error( $plugin, $network_wide ) {
    file_put_contents(
        WP_CONTENT_DIR. '/error_activation.html',
        $plugin . ob_get_contents()
    );
    //update_option( 'plugin_error',  ob_get_contents() );
}