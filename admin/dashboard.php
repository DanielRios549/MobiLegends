<?php
function mobi_start_page() {
    mobi_get_header();

    if(mobi_get_option('default_data_installed') == false) {
?>
<section class="mobi-overview">
    <button id="mobi_install_default_data" class="button button-primary"><span><?php echo __('Install Default Data', 'mobilegends');?></span></button>
    <button id="mobi_install_default_data_skip" class="button"><span><?php echo __('Skip', 'mobilegends');?></span></button>
</section>
<?php } else { ?>
<section class="mobi-overview">
    <div class="item"<?php $divData = 'season'?>>
        <a href="<?php echo 'admin.php?page=mobi-' . mobi_get_plural($divData);?>" class="itemLink">
            <span>
                <?php mobi_get_dash_count($divData); echo __(ucfirst(mobi_get_plural($divData)), 'mobilegends');?>
            </span>
        </a>
    </div>
    <div class="item"<?php $divData = 'match'?>>
        <a href="<?php echo 'admin.php?page=mobi-' . mobi_get_plural($divData);?>" class="itemLink">
            <span>
                <?php mobi_get_dash_count($divData); echo __(ucfirst(mobi_get_plural($divData)), 'mobilegends');?>
            </span>
        </a>
    </div>
    <div class="item"<?php $divData = 'team'?>>
        <a href="<?php echo 'admin.php?page=mobi-' . mobi_get_plural($divData);?>" class="itemLink">
            <span>
                <?php mobi_get_dash_count($divData); echo __(ucfirst(mobi_get_plural($divData)), 'mobilegends');?>
            </span>
        </a>
    </div>
    <div class="item"<?php $divData = 'player'?>>
        <a href="<?php echo 'admin.php?page=mobi-' . mobi_get_plural($divData);?>" class="itemLink">
            <span>
                <?php mobi_get_dash_count($divData); echo __(ucfirst(mobi_get_plural($divData)), 'mobilegends');?>
            </span>
        </a>
    </div>
</section>
<div id="mobi_dash_details">
    
</div>
<?php }}?>