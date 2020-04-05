<?php

function mobi_get_plural($str) {
    if($str == 'match') {
        $plural = $str . 'es';
    }
    else {
        $plural = $str . 's';
    }
    return $plural;
}

function mobi_get_tables_sufixes() {
    $tables = array(
        'option',
        'player',
        'team',
        'match',
        'season'
    );
    return $tables;
}

function mobi_get_tables() {
    global $wpdb;
    $databases = array();
    $databases_sufixes = mobi_get_tables_sufixes();

    foreach($databases_sufixes as $database) {
        if ($database == 'match') {
            $database = $database . 'e';
        }
        array_push($databases, $wpdb -> prefix . 'mobi_' . $database . 's');
    }
    return $databases;
}

function mobi_get_option_table() {
    global $wpdb;
    return $wpdb -> prefix . 'mobi_options';
}

function mobi_get_option($option) {
    global $wpdb;
    $table = mobi_get_option_table();
    
    $result = $wpdb -> prepare("SELECT option_value FROM {$table} WHERE option_name = %d", $option);
    return $wpdb -> get_col($result)[0];
}

function mobi_default_data_install() {
    check_ajax_referer('default_data_install');
    global $wpdb;
    $table = mobi_get_tables();

    //Season is only one by default, so a foreach is not necessary

    $wpdb -> insert($table[4],
        array(
            'season_name'  => 'Champions',
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
                'match_name'         => $match[0],
                'display_name' => $match[1],
                'match_date'   => $match[2],
                'season'       => $match[3]
            )
        );
    }
    foreach($teams as $key => $team) {
        $wpdb -> insert($table[2],
            array(
                'team_name'         => $team[0],
                'display_name' => $team[1],
                'year'         => $team[2],
                'next_match'   => $team[3]
            )
        );
    }
    foreach($players as $key => $player) {
        $wpdb -> insert($table[1],
            array(
                'player_name'         => $player[0],
                'display_name' => $player[1],
                'date'         => $player[2],
                'current_team' => $player[3]
            )
        );
    }

    $option_table = mobi_get_option_table();
    
    $wpdb -> update(
        $option_table,
        array(
            'option_value' => 1
        ),
        array(
            'option_name' => 'default_data_installed'
        )
    );
    wp_die();
}

add_action('wp_ajax_mobi_install_action', 'mobi_default_data_install');

function mobi_default_data_install_skipped() {
    check_ajax_referer('default_data_install_skip');
    $option_table = mobi_get_option_table();

    $wpdb -> update(
        $option_table,
        array(
            'option_value' => 1
        ),
        array(
            'option_name' => 'default_data_installed'
        )
    );
    wp_die();
}

add_action('wp_ajax_mobi_install_action_skip', 'mobi_default_data_install_skipped');