<?php

require_once __DIR__ . '/header.php';
require_once __DIR__ . '/../includes/seasons.php';
require_once __DIR__ . '/../includes/matches.php';
require_once __DIR__ . '/../includes/teams.php';
require_once __DIR__ . '/../includes/players.php';

function mobi_register_custom_pages() {
    add_menu_page(
        'mobi',
        __('MobiLegends', 'mobilegends'),
        'mobi_admin',
        'mobi-dashboard',
        'mobi_start_page',
        plugins_url( '/images/menu.png', __FILE__ )
    );
    $pages = array(
        'mobi-seasons' => array (
            'parent'     => 'mobi-dashboard',
            'name'       => __('Season', 'mobilegends'),
            'permission' => 'mobi_admin',
            'link'       => 'mobi-seasons',
            'function'   => 'mobi_page_seasons',
            'icon'       => ''
        ),
        'mobi-matches' => array (
            'parent'     => 'mobi-matches',
            'name'       => __('Matches', 'mobilegends'),
            'permission' => 'mobi_admin',
            'link'       => 'mobi-matches',
            'function'   => 'mobi_page_matches',
            'icon'       => ''
        ),
        'mobi-teams' => array (
            'parent'     => 'mobi-dashboard',
            'name'       => __('Teams', 'mobilegends'),
            'permission' => 'mobi_admin',
            'link'       => 'mobi-teams',
            'function'   => 'mobi_page_teams',
            'icon'       => ''
        ),
        'mobi-players' => array (
            'parent'     => 'mobi-dashboard',
            'name'       => __('Players', 'mobilegends'),
            'permission' => 'mobi_admin',
            'link'       => 'mobi-players',
            'function'   => 'mobi_page_players',
            'icon'       => ''
        )
    );
    foreach($pages as $key => $page) {
        add_submenu_page(
            $page['parent'],
            $page[$key],
            $page['name'],
            $page['permission'],
            $page['link'],
            $page['function'],
            $page['icon']
        );
    }
}

add_action('admin_menu', 'mobi_register_custom_pages');


function mobi_start_page() {
    mobi_get_header();
}
