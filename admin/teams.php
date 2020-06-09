<?php
function mobi_page_teams() {
    mobi_get_header();
    $mobi_page_type = 'team';
    $mobi_page_additional = 'match';
    $mobi_page_data = mobi_show_data($mobi_page_type, $mobi_page_additional);
    $mobi_page_column = array(
        'year' => 'year',
        'match' => 'match_display_name'
    );

    require_once __DIR__ . '/show_data.php';
}