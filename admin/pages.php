<?php

require_once __DIR__ . '/header.php';
require_once __DIR__ . '/dashboard.php';
require_once __DIR__ . '/seasons.php';
require_once __DIR__ . '/matches.php';
require_once __DIR__ . '/teams.php';
require_once __DIR__ . '/players.php';

function mobi_register_custom_pages() {
    add_menu_page(
        'mobi',
        __('MobiLegends', 'mobilegends'),
        'mobi_admin',
        'mobi-dashboard',
        '',
        plugins_url( '/images/menu.png', __FILE__ ),
        2
    );
    $pages = array(
        'mobi-dashboard' => array (
            'parent'     => 'mobi-dashboard',
            'name'       => __('Dashboard', 'mobilegends'),
            'permission' => 'mobi_admin',
            'link'       => 'mobi-dashboard',
            'function'   => 'mobi_start_page',
            'icon'       => ''
        ),
        'mobi-seasons' => array (
            'parent'     => 'mobi-dashboard',
            'name'       => __('Season', 'mobilegends'),
            'permission' => 'mobi_admin',
            'link'       => 'mobi-season',
            'function'   => 'mobi_page_seasons',
            'icon'       => ''
        ),
        'mobi-matches' => array (
            'parent'     => 'mobi-dashboard',
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
        ),
        'mobi-settings' => array (
            'parent'     => 'mobi-dashboard',
            'name'       => __('Settings', 'mobilegends'),
            'permission' => 'mobi_admin',
            'link'       => 'mobi-settings',
            'function'   => 'mobi_page_settigns',
            'icon'       => ''
        ),
    );
    foreach($pages as $page) {
        add_submenu_page(
            $page['parent'],
            $page['name'],
            $page['name'],
            $page['permission'],
            $page['link'],
            $page['function'],
            $page['icon']
        );
    }
}

add_action('admin_menu', 'mobi_register_custom_pages');
