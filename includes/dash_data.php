<?php

function mobi_get_dash_count($data) {
    global $wpdb;
    $key = $data;

    if($data == 'match') {
        $data = $data . 'e';
    }

    $wpdb -> query("SELECT {$key}_id FROM {$wpdb -> prefix}mobi_{$data}s");

    echo $wpdb -> num_rows . ' ';
}