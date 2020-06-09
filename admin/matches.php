<?php
function mobi_page_matches() {
    mobi_get_header();
    $mobi_page_type = 'match';
    $mobi_page_additional = 'season';
    $mobi_page_data = mobi_show_data($mobi_page_type, $mobi_page_additional);
    $mobi_page_column = array(
        'date'   => 'match_date',
        'season' => 'season_display_name'
    );

    require_once __DIR__ . '/show_data.php';
}