<?php

function mobi_get_header() {
    wp_enqueue_style('mobi_admin_style', plugins_url('/css/style.css', __FILE__));
    wp_enqueue_script('mobi_install_script', plugins_url('/js/install.js', __FILE__), array('jquery'));

    $mobi_install_nonce = wp_create_nonce('default_data_install');
    $mobi_install_skip_nonce = wp_create_nonce('default_data_install_skip');

    wp_localize_script('mobi_install_script', 'mobi_install_obj', array(
        'ajax_url'      => admin_url('admin-ajax.php'),
        'nonce_install' => $mobi_install_nonce,
        'nonce_skip'    => $mobi_install_skip_nonce,
    ));

    $mobi_title_hyphen_position = strpos($_GET['page'], '-') + 1;
    $mobi_title = __(ucfirst(substr($_GET['page'], $mobi_title_hyphen_position)), 'mobilegends');
?>
<h1 id='pageTitle'><?php echo $mobi_title;?></h1>
<?php }