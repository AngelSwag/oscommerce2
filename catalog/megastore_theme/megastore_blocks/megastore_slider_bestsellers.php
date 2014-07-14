<?php
$products_bestsellers_query = tep_db_query("select distinct pd.products_id, .pd.products_name, pd.products_description, p.products_id, p.products_image, p.products_price, p.products_tax_class_id, p.products_date_available from " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_PRODUCTS . " p where p.products_ordered > 0 and p.products_status = '1' and p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "' order by p.products_ordered desc, pd.products_name limit ".MAX_DISPLAY_BESTSELLERS."");
if (tep_db_num_rows($products_bestsellers_query) > 0) {
?>



<div class="container main_product_slider slider_bestsellers">
    <h2><?php echo TAB_TEXT_BEST_SELLERS; ?></h2>
    <div class="carousel es-carousel-wrapper style0">
        <div class="es-carousel">
            <div class="row">
                <div class="product_outer">

                    <!-- products output cycle -->
                    <?php
                    while ($best_viewed = tep_db_fetch_array($products_bestsellers_query)) {

                        $best_viewed['specials_new_products_price'] = tep_get_products_special_price($best_viewed['products_id']);
                        if (tep_not_null($best_viewed['specials_new_products_price'])) {
                            $best_viewed_price = '<span class="old">' . $currencies->display_price($best_viewed['products_price'], tep_get_tax_rate($best_viewed['products_tax_class_id'])) . '</span><span class="new">' .$currencies->display_price($best_viewed['specials_new_products_price'], tep_get_tax_rate($best_viewed['products_tax_class_id'])).'</span>';
                            $sticker_sale = STICKER_SALE;
                        } else {
                            $best_viewed_price = $currencies->display_price($best_viewed['products_price'], tep_get_tax_rate($best_viewed['products_tax_class_id']));
                            $sticker_sale = '';
                        }

                        $best_viewed_price = '<div class="product-price">'.$best_viewed_price.'</div>';

                        $realpath = DIR_FS_CATALOG.'/images/'. $best_viewed['products_image'];

                        /* if product has options */
                        $current_product =  $best_viewed['products_id'];
                        $products_attributes_query = tep_db_query("select count(*) as total from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_ATTRIBUTES . " patrib where patrib.products_id='" . (int)$current_product . "' and patrib.options_id = popt.products_options_id and popt.language_id = '" . (int)$languages_id . "'");
                        $products_attributes = tep_db_fetch_array($products_attributes_query);
                        if ($products_attributes['total'] > 0) {
                            $sticker_options = STICKER_OPTION;
                        }  else {
                            $sticker_options = '';
                        }
                        $rating	= rating_output($current_product);
                        /* if product has options */

                        /* if product has big img */
                        $products_new_added_big_img_query = tep_db_query("select distinct pi.image, pi.products_id from " . TABLE_PRODUCTS_IMAGES . " pi where pi.products_id = '$current_product' order by pi.id ASC ");
                        /* if product has big img */

                        if (tep_not_null($best_viewed['products_date_available'])) {
                            //if ($best_viewed['products_date_available'] <= date('Y-m-d H:i:s')) {
                                $sticker_new = STICKER_NEW;
                           // }
                        } else {
                            $sticker_new = '';
                        }


                        ?>
                        <!-- original product view -->
                        <div class="span3 product">


                            <div class="product-image-wrapper">

                                <!-- stickers -->
                                <?php echo $sticker_sale.$sticker_options.$sticker_new; ?>
                                <!-- stickers -->

                                <a href="<?php echo tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $best_viewed["products_id"]) ;?>">
                                    <?php
                                    if(file_exists($realpath)) {
                                        echo tep_image(DIR_WS_IMAGES . $best_viewed['products_image'], $best_viewed['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT);
                                    } else { ?>
                                        <img src="<?php echo DC_IMAGES.'empty.gif'; ?>" alt="">
                                    <?php } ?>

                                </a>
                            </div>
                            <div class="wrapper-hover">
                                <div class="product-name">
                                    <a href="<?php echo tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $best_viewed["products_id"]) ;?>">
                                        <?php echo trimmed_text($best_viewed['products_name'] , 50) ?>
                                    </a>
                                </div>
                                <div class="wrapper">
                                    <?php echo $best_viewed_price; ?>
                                    <div class="product-tocart">
                                        <a href="<?php echo tep_href_link(basename($PHP_SELF), tep_get_all_get_params(array('action')) . 'action=buy_now&products_id=' . $best_viewed['products_id']) ?>"><i class="icon-basket"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- original product view -->

                        <!-- rollover product view -->
                            <div class="preview hidden-tablet hidden-phone">

                                <div class="wrapper">

                                    <!-- product has some previews -->
                                    <?php
                                     if (ROLLOVER_EFFECT !== 'simple') {
                                        if (tep_db_num_rows($products_new_added_big_img_query) > 1) { ?>
                                            <div class="col-1">
                                            <!--  previews output -->

                                            <!-- stickers -->
                                            <?php echo $sticker_sale.$sticker_options.$sticker_new; ?>
                                            <!-- stickers -->

                                            <?php while ($products_new_added_big_img = tep_db_fetch_array($products_new_added_big_img_query)) { ?>
                                                <a href="<?php echo tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $best_viewed["products_id"]) ;?>" class="image" data-rel="<?php echo tep_href_link(DIR_WS_IMAGES . $products_new_added_big_img['image'], $products_new_added_big_img['products_name']); ?>">
                                                    <?php echo tep_image(DIR_WS_IMAGES . $products_new_added_big_img['image'], $products_new_added_big_img['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT, 'class="thumb"'); ?>
                                                </a>
                                            <?php } ?>
                                            <!--  previews output -->
                                        </div>
                                    <?php
                                        }
                                     }
                                    ?>
                                    <!-- product has some previews -->



                                     <?php
                                        $products_new_added_big_img_query1 = tep_db_query("select distinct pi.image, pi.products_id from " . TABLE_PRODUCTS_IMAGES . " pi where pi.products_id = '$current_product' order by pi.id ASC ");
                                        $products_new_added_big_img = tep_db_fetch_array($products_new_added_big_img_query1);
                                    ?>
                                    <!-- stickers -->
                                    <?php echo $sticker_sale.$sticker_options.$sticker_new; ?>
                                    <!-- stickers -->

                                    <div class="col-2">

                                        <div class="big_image">
                                            <a href="<?php echo tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $best_viewed["products_id"]) ;?>">
                                                <?php
                                                if (tep_db_num_rows($products_new_added_big_img_query) > 0) {
                                                    echo tep_image(DIR_WS_IMAGES . $products_new_added_big_img['image'], $products_new_added_big_img['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT);
                                                } else {

                                                        echo tep_image(DIR_WS_IMAGES . $best_viewed['products_image'], $best_viewed['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT);


                                                }
                                                ?>
                                            </a>
                                        </div>




                                        <div class="wrapper-hover">
                                            <div class="product-name">
                                                <a href="<?php echo tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $best_viewed["products_id"]) ;?>">
                                                    <?php echo trimmed_text($best_viewed['products_name'] , 50) ?>
                                                </a>
                                            </div>
                                            <div class="wrapper">
                                                <?php echo $best_viewed_price; ?>
                                                <div class="product-tocart">
                                                    <a href="<?php echo tep_href_link(basename($PHP_SELF), tep_get_all_get_params(array('action')) . 'action=buy_now&products_id=' . $best_viewed['products_id']) ?>"><i class="icon-basket"></i></a>
                                                </div>
                                            </div>
                                            <?php echo $rating; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <!-- rollover product view -->


                    <?php } ?>
                    <!-- products output cycle -->

                </div>
            </div>
        </div>
    </div>
</div>


<div class="line"></div>

<?php
}
?>
