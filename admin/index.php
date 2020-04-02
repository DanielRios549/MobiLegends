<?php

function mobi_register_custom_menu() {
    add_menu_page(
        'MobiLegends',
        'MobiLegends',
        'mobi_admin',
        'mobi',
        'mobi_start_page',
        //__FILE__ . '/images/icon.png'
    );
}

add_action('admin_menu', 'mobi_register_custom_menu');


function mobi_start_page() {
    echo '<h1>Hello, World!</h1>';
}
