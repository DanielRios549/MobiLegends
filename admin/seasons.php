<?php
function mobi_page_seasons() {
    mobi_get_header();
    $mobi_page_type = 'season';
    $mobi_page_additional = 'camp';
    $mobi_page_data = mobi_show_data($mobi_page_type, $mobi_page_additional);
    $mobi_page_column = array(
        'year'  => 'season_year',
        'camp'  => 'camp_display_name'
    );

    require_once __DIR__ . '/show_data.php';
}