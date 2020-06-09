<div class="wrap">
    <form id="posts-filter" method="get">
        <p class="search-box">
            <label class="screen-reader-text" for="post-search-input"><?php echo __('Pesquisar ' . $mobi_page_type, 'mobilegends');?></label>
            <input type="search" id="post-search-input" name="s" value="">
            <input type="submit" id="search-submit" class="button" value="<?php echo 'Pesquisar ' . $mobi_page_type;?>">
        </p>
        <div class="tablenav top">
        <div class="alignleft actions bulkactions">
			<label for="bulk-action-selector-top" class="screen-reader-text"><?php echo __('Bulk Select', 'mobilegends');?></label>
            <select name="action" id="bulk-action-selector-top">
                <option value="-1"><?php echo __('Bulk Select', 'default');?></option>
                <option value="edit" class="hide-if-no-js"><?php echo __('Edit', 'default');?></option>
                <option value="trash" class="hide-if-no-js"><?php echo __('Move to Trash', 'default');?></option>
            </select>
            <input type="submit" id="doaction" class="button action" value="<?php echo __('Apply', 'default');?>">
        </div>
        </div>
        <table class="wp-list-table widefat fixed striped pages">
            <thead>
                <tr>
                    <td id="cb" class="manage-column column-cb check-column">
                        <label class="screen-reader-text" for="cb-select-all-1"><?php echo __('Select All', 'mobilegends');?></label>
                        <input id="cb-select-all-1" type="checkbox">
                    </td>
                    <th id="name" class="manage-column column-title column-primary sortable desc" scope="col">
                        <a href="<?php '&orderby=title&order=asc'?>">
                            <span><?php echo __('Title', 'mobilegends');?></span>
                            <span class="sorting-indicator"></span>
                        </a>
                    </th>
                    <?php foreach($mobi_page_column as $key => $data) {?>
                    <th id="<?php echo $key?>" class="manage-column column-<?php echo $key?> sortable desc" scope="col">
                        <a href="<?php '&orderby=' . $key . '&order=asc'?>">
                            <span><?php echo __(ucfirst($key), 'mobilegends');?></span>
                            <span class="sorting-indicator"></span>
                        </a>
                    </th>
                    <?php }?>
                </tr>
            </thead>
            <tbody id="the-list">
                <?php foreach($mobi_page_data as $key => $data) {
                    $row_id = $data[$mobi_page_type . '_id'];
                ?>
                <tr id="post-<?php echo $row_id;?>" class="post-<?php echo $row_id;?> iedit author-self level-0 type-page status-publish hentry">
                    <th class="check-column" scope="row">
                        <label class="screen-reader-text" for="cb-select-<?php echo $row_id;?>">
                            <?php __('Select', 'mobilegends');?>
                        </label>
                        <input id="cb-select-<?php echo $row_id;?>" type="checkbox" name="post[]" value="<?php echo $row_id;?>">
                    </th>
                    <td class="title column-title"><?php echo $data[$mobi_page_type . '_display_name'];?></td>
                    <?php foreach($mobi_page_column as $item => $column) {?> 
                    <td class="">
                        <?php echo $data[$column];?>
                    </td>
                    <?php }?>
                </tr>
                <?php }?>
            </tbody>
        </table>
    </form>
    <div><pre><?php print_r($mobi_page_data);?></pre></div>
</div>