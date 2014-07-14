<?php

    $categories_query = tep_db_query("select distinct c.categories_id, c.parent_id, cd.categories_id, cd.categories_name from " . TABLE_CATEGORIES . " c, ".TABLE_CATEGORIES_DESCRIPTION . " cd where c.categories_id = cd.categories_id and c.parent_id = '0' and cd.language_id='" . (int)$languages_id ."' order by sort_order, cd.categories_name ");
    if (tep_db_num_rows($categories_query) > 0) {
        $cat_count = 0;
?>

        <ul class="nav nav-list">
            <li class="nav-header">
                <a href="#level1" title="" data-toggle="collapse"><i class="icon-th"></i>&nbsp;&nbsp;<?php echo TEXT_MENU; ?>
                    <i class="icon-down pull-right"></i>
                </a>

                <ul class="collapse in" id="level1" >
                    <li class="home-link"><a href="<?php echo tep_href_link(FILENAME_DEFAULT); ?>"><?php echo MENU_TEXT_HOME; ?></a></li>

        <?php

            while ($cat = tep_db_fetch_array($categories_query)) {
                $cPath_new = 'cPath=' .$cat['categories_id'];

                /* check category name for current language */
                if ($cat['categories_name'] !== "") {
        ?>

                    <li>
                        <a href="<?php echo tep_href_link(FILENAME_DEFAULT, $cPath_new); ?>"><?php echo$cat['categories_name']; ?></a>
                        <?php
                            $current_cat_id = $cat['categories_id'];


                            $categories_query_sub = tep_db_query("select c.categories_id, cd.categories_name, c.parent_id from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.parent_id = '" . (int)$current_cat_id . "' and c.categories_id = cd.categories_id and cd.language_id = '" . (int)$languages_id . "' order by sort_order, cd.categories_name");

                            if (tep_db_num_rows($categories_query_sub) > 0) {

                        ?>

                        <a class="icon-collapse" href="#level2_<?php echo $current_cat_id; ?>" data-toggle="collapse" >
                            <i class="icon-down pull-right"></i>
                        </a>

                        <ul class="collapse in" id="level2_<?php echo $current_cat_id; ?>">
                            <!-- subcategories output 1 level -->
                            <?php
                                while ($sub_cat = tep_db_fetch_array($categories_query_sub)) {
                                    if ($sub_cat['categories_name'] !== "") {
                            ?>

                                        <li><a href="<?php echo tep_href_link(FILENAME_DEFAULT, 'cPath='.$cat['categories_id'].'_'.$sub_cat['categories_id']); ?>"><?php echo $sub_cat['categories_name']; ?></a> </li>

                            <?php
                                    }
                                }
                            ?>
                            <!-- subcategories output 1 level -->
                        </ul>

                        <?php } ?>



                    </li>


        <?php
            }
                /* check category name for current language */

            }

        ?>

                </ul>
            </li>
        </ul>

<?php } ?>