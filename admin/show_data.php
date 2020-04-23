<div class="wrap">
    <form id="posts-filter" method="get">
        <p class="search-box">
            <label class="screen-reader-text" for="post-search-input">Pesquisar páginas:</label>
            <input type="search" id="post-search-input" name="s" value="">
            <input type="submit" id="search-submit" class="button" value="Pesquisar páginas">
        </p>
        <div class="tablenav top">
        <div class="alignleft actions bulkactions">
			<label for="bulk-action-selector-top" class="screen-reader-text">Selecionar ação em massa</label><select name="action" id="bulk-action-selector-top">
            <option value="-1">Ações em massa</option>
                <option value="edit" class="hide-if-no-js">Editar</option>
                <option value="trash">Mover para lixeira</option>
            </select>
            <input type="submit" id="doaction" class="button action" value="Aplicar">
        </div>
        </div>
        <table class="wp-list-table widefat fixed striped pages">
            <thead>
                <tr>
                    <td id="cb" class="manage-column column-cb check-column">
                        <label class="screen-reader-text" for="cb-select-all-1">Selecionar todos</label>
                        <input id="cb-select-all-1" type="checkbox">
                    </td>
                    <th scope="col" id="title" class="manage-column column-title column-primary sortable desc">
                        <a href="<?php get_permalink() . '&orderby=title&order=asc'?>">
                            <span>Título</span>
                            <span class="sorting-indicator"></span>
                        </a>
                    </th>
                </tr>
            </thead>
            <tbody id="the-list">
                <?php foreach($mobi_page_data as $key => $data) {
                    $row_id = $data[$mobi_page_type . '_id'];
                ?>
                <tr id="post-<?php echo $row_id;?>" class="post-<?php echo $row_id;?> iedit author-self level-0 type-page status-publish hentry">
                    <th class="check-column" scope="row">
                        <label class="screen-reader-text" for="cb-select-<?php echo $row_id;?>">Selecionar Test</label>
                        <input id="cb-select-<?php echo $row_id;?>" type="checkbox" name="post[]" value="<?php echo $row_id;?>">
                    </th>
                    <td class="title column-title"><?php echo $data['display_name'];?></td>
                </tr>
                <?php }?>
            </tbody>
        </table>
    </form>
</div>