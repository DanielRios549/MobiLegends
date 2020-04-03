<?php

function mobi_get_header() {
    wp_enqueue_style( 'mobi_admin_style', plugins_url( '/css/style.css', __FILE__ ) );
?>

<div class="mobiHeader">
    <h1 class="mobiTitle">Hello, World!</h1>
</div>

<?php }?>