<?php

function mobi_get_header() {
    wp_enqueue_style( 'mobi_admin_style', plugins_url( '/css/style.css', __FILE__ ) );
    $mobi_title = __(ucfirst(trim($_GET['page'], 'mobi-')), 'mobilegends');
?>
<h1 id='pageTitle'><?php echo $mobi_title;?></h1>
<?php }