<?php

function mobi_start_page() {
    mobi_get_header();
?>
<section class="overview">
    <div class="item"><a href="#" class="itemLink"><span><?php mobi_get_dash_count('season'); echo __('Seasons', 'mobilegends');?></span></a></div>
    <div class="item"><a href="#" class="itemLink"><span><?php mobi_get_dash_count('match'); echo __('Matches', 'mobilegends');?></span></a></div>
    <div class="item"><a href="#" class="itemLink"><span><?php mobi_get_dash_count('team'); echo __('Teams', 'mobilegends');?></span></a></div>
    <div class="item"><a href="#" class="itemLink"><span><?php mobi_get_dash_count('player'); echo __('Players', 'mobilegends');?></span></a></div>
</section>
<?php }