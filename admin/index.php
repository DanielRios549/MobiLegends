<?php

function mobilegends_register_custom_menu() {
    add_menu_page(
        'MobiLegends',
        'MobiLegends',
        'mobi_admin',
        'mobi',
        'mobilegends_start_page',
        //__FILE__ . '/images/icon.png'
    );
}

add_action('admin_menu', 'mobilegends_register_custom_menu');


function mobilegends_start_page() {
    echo '<h1>Hello, World!</h1>';
}
