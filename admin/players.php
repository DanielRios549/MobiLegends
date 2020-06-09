<?php
function mobi_page_players() {
    mobi_get_header();
    $mobi_page_type = 'player';
    $mobi_page_additional = 'team';
    $mobi_page_data = mobi_show_data($mobi_page_type, $mobi_page_additional);
    $mobi_page_column = array(
        'date' => 'date',
        'team' => 'team_display_name'
    );

    require_once __DIR__ . '/show_data.php';
} 