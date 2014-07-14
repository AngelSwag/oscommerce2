<?php
    $categories_query = tep_db_query("select distinct c.categories_id, c.parent_id, cd.categories_id, cd.categories_name from " . TABLE_CATEGORIES . " c, ".TABLE_CATEGORIES_DESCRIPTION . " cd where c.categories_id = cd.categories_id and c.parent_id = '0' and cd.language_id='" . (int)$languages_id ."' order by sort_order, cd.categories_name ");
    if (tep_db_num_rows($categories_query) > 0) {
        $nav_count = 0;

?>

        <ul id="nav">

            <li class="home-link"><a href="<?php echo tep_href_link(FILENAME_DEFAULT); ?>"><i class="icon-home"></i></a></li>


        <?php

            while ($cat = tep_db_fetch_array($categories_query)) {
                $cPath_new = 'cPath=' .$cat['categories_id'];
                /* check category name for current language */
                if ($cat['categories_name'] !== "") {
                    $nav_count ++;
                    $current_cat_id = $cat['categories_id'];
                    $categories_query_sub = tep_db_query("select c.categories_id, cd.categories_name, c.parent_id from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.parent_id = '" . (int)$current_cat_id . "' and c.categories_id = cd.categories_id and cd.language_id = '" . (int)$languages_id . "' order by sort_order, cd.categories_name");

        ?>
                   <!-- TOP CATEGORY OUTPUT -->
                    <li class="level0 nav-<?php echo $nav_count; ?> level-top first parent">
                        <a href="<?php echo tep_href_link(FILENAME_DEFAULT, $cPath_new); ?>" class="level-top"><span><?php echo$cat['categories_name']; ?></span></a>
                        <?php
                            if (tep_db_num_rows($categories_query_sub) > 0) {
                                $sub_nav_count = 0;
                        ?>

                        <ul class="level0">
                            <li>
                            <!-- subcategories output 1 level -->
                                <ul class="shadow">

                                    <!-- subcategories wrapper -->
                                    <li class="list_column">
                                        <ul class="list_in_column">
                                            <?php
                                                    while ($sub_cat = tep_db_fetch_array($categories_query_sub)) {
                                                        if ($sub_cat['categories_name'] !== "") {
                                                            $sub_nav_count ++;
                                                ?>

                                                            <li class="level1 nav-<?php echo $nav_count; ?>-<?php echo $sub_nav_count; ?>">
                                                                <a href="<?php echo tep_href_link(FILENAME_DEFAULT, 'cPath='.$cat['categories_id'].'_'.$sub_cat['categories_id']); ?>">
                                                                    <span><?php echo $sub_cat['categories_name']; ?></span>
                                                                </a>


                                                                <!-- second level categories output -->
                                                                <?php
                                                                    $current_subcat_id = $sub_cat['categories_id'];
                                                                    $categories_query_second_level = tep_db_query("select c.categories_id, cd.categories_name, c.parent_id from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.parent_id = '" . (int)$current_subcat_id . "' and c.categories_id = cd.categories_id and cd.language_id = '" . (int)$languages_id . "' order by sort_order, cd.categories_name");
                                                                    if (tep_db_num_rows($categories_query_second_level) > 0) {
                                                                        $second_level_count = 0;
                                                                ?>
                                                                        <ul class="level1">
                                                                        <?php while ($second_level_cat = tep_db_fetch_array($categories_query_second_level)) {
                                                                            if ($second_level_cat['categories_name'] !== "") {
                                                                                $second_level_count ++;

                                                                        ?>
                                                                                <li class="level2 nav-<?php echo $nav_count; ?>-<?php echo $sub_nav_count; ?>-<?php echo $second_level_count; ?>">
                                                                                    <a href="<?php echo tep_href_link(FILENAME_DEFAULT, 'cPath='.$cat['categories_id'].'_'.$sub_cat['categories_id'].'_'.$second_level_cat['categories_id']); ?>">
                                                                                        <span><?php echo $second_level_cat['categories_name']; ?></span>
                                                                                    </a>
                                                                                </li>
                                                                        <?php
                                                                            }
                                                                        } ?>
                                                                        </ul>
                                                                <?php
                                                                    }
                                                                ?>
                                                                <!-- second level categories output -->


                                                            </li>

                                                <?php
                                                        }
                                                    }
                                                ?>
                                        </ul>

                                    </li>
                                    <!-- end subcategories wrapper -->



                                </ul>
                            <!-- subcategories output 1 level -->
                            </li>
                        </ul>

                        <?php } ?>



                    </li>
                    <!-- TOP CATEGORY OUTPUT -->


                    <?php
            }
                /* check category name for current language */

            }

        ?>

            <!-- CUSTOM MENU BLOCK -->
            <?php
             if (MENU_BLOCK_STATUS !== 'disable') {
                $custom_block_query = tep_db_query("SELECT menu_block_content FROM `custom_menu_block` where `menu_block_id` = '$languages_id' ");
                 if (tep_db_num_rows($custom_block_query) > 0) {
                     $custom_block_output = tep_db_fetch_array($custom_block_query);
                     if ($custom_block_output['menu_block_content'] !== '') {
                        echo '<li id="menu_custom_block" class="level0 parent level-top">
                                <a class="level-top"> <span>'.CUSTOM_BLOCK.'</span> </a>
                                <div class="menu_custom_block" style="right:0">
                                    <div class="shadow" style="width:530px">
                                        '.stripslashes($custom_block_output['menu_block_content']).'
                                    </div>
                                </div>
                            </li>';
                     } else {
                         echo '<li id="menu_custom_block" class="level0 parent level-top">
                    <a class="level-top"><span>'.CUSTOM_BLOCK.'</span> </a>
                    <div class="menu_custom_block" style="right:0">
                        <div class="shadow" style="width:530px">'.CUSTOM_MENU_BLOCK_CONTENT.'</div>
                    </div>
                    </li>';
                     }


                 } else {
                     echo '<li id="menu_custom_block" class="level0 parent level-top">
                    <a class="level-top"><span>'.CUSTOM_BLOCK.'</span> </a>
                    <div class="menu_custom_block" style="right:0">
                        <div class="shadow" style="width:530px">'.CUSTOM_MENU_BLOCK_CONTENT.'</div>
                    </div>
                    </li>';
                 }
             }
            ?>


            <!-- CUSTOM MENU BLOCK -->


        </ul>

<?php } ?>