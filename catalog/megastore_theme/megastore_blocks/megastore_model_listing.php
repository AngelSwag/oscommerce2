<?php
ob_start();
?>

<div class="<?php echo (LISTING_IMAGES_SIZE == 'small') ? 'span2' : 'span3'; ?> product count_3cols_col_<?php echo $column3; ?> count_2cols_col_<?php echo $column2; ?> count_4cols_col_<?php echo $column4; ?> count_6cols_col_<?php echo $column6; ?>">
        <div class="product-image-wrapper">
            <!-- stickers -->
            <?php echo $product['sticker_sale'].$product['sticker_options'].$sticker_new; ?>
            <!-- stickers -->

            <a href="<?php echo $product['name_url'] ?>">
                <?php echo $product['image'] ?>
            </a>
        </div>
    <div class="wrapper-hover">
        <div class="product-name">
            <a href="<?php echo $product['name_url'] ?>">
                <?php echo trimmed_text($product['name'], 50) ?>
            </a>
        </div>
        <div class="wrapper">
            <div class="product-price"><?php echo $product['price'] ?></div>
            <div class="product-tocart"><a href="<?php echo $product['cart_url'] ?>"><i class="icon-basket"></i></a></div>
        </div>
    </div>

</div>

    <div class="preview <?php echo (LISTING_IMAGES_SIZE == 'small') ? 'small' : 'big_original'; ?> hidden-tablet hidden-phone">
            <div class="wrapper">
                <!-- more than one additional images -->
                <?php
                $products_new_added_big_img_query = tep_db_query("select distinct pi.image, pi.products_id from " . TABLE_PRODUCTS_IMAGES . " pi where pi.products_id = '$current_product' order by pi.id ASC ");

                if (ROLLOVER_EFFECT !== 'simple') {
                    if (tep_db_num_rows($products_new_added_big_img_query) > 1) { ?>
                        <div class="col-1">
                            <?php echo $product['sticker_sale'].$product['sticker_options']; ?>

                            <?php
                                while ($products_new_added_big_img = tep_db_fetch_array($products_new_added_big_img_query)) { ?>
                                    <a class="image" data-rel="<?php echo tep_href_link(DIR_WS_IMAGES . $products_new_added_big_img['image'], $products_new_added_big_img['products_name']); ?>">
                                        <?php echo tep_image(DIR_WS_IMAGES . $products_new_added_big_img['image'], $products_new_added_big_img['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT, 'class="thumb"'); ?>
                                    </a>
                                <?php
                                }
                            ?>

                        </div>
                <?php }
                }
                    ?>
                <!-- end more than one additional images -->

                <?php echo $product['sticker_sale'].$product['sticker_options'].$sticker_new; ?>
                <?php
                $products_new_added_big_img_query1 = tep_db_query("select distinct pi.image, pi.products_id from " . TABLE_PRODUCTS_IMAGES . " pi where pi.products_id = '$current_product' order by pi.id ASC ");
                $products_new_added_big_img1 = tep_db_fetch_array($products_new_added_big_img_query1);
                ?>


                <!-- rollover image -->
                <div class="col-2">
                    <div class="big_image">
                        <a href="<?php echo $product['name_url'] ?>">
                            <?php
                            if (tep_db_num_rows($products_new_added_big_img_query1) > 0) {

                                echo tep_image(DIR_WS_IMAGES . $products_new_added_big_img1['image'], $products_new_added_big_img1['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT, 'class="thumb"');

                            } else {
                                echo $product['image'];
                            }
                            ?>
                        </a>
                    </div>

                    <div class="wrapper-hover">
                        <div class="product-name">
                            <a href="<?php echo $product['name_url'] ?>">
                                <?php echo trimmed_text($product['name'], 50) ?>
                            </a>
                        </div>
                        <div class="wrapper">
                            <div class="product-price"><?php echo $product['price'] ?></div>
                            <div class="product-tocart"><a href="<?php echo $product['cart_url'] ?>"><i class="icon-basket"></i></a></div>
                        </div>

                        <?php echo $product['review']; ?>
                    </div>

                </div>
                <!-- rollover image -->

            </div>
        </div>




<?php
$megastore_listing_output = ob_get_contents();
ob_end_clean();
?>