<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/


  if (isset($HTTP_GET_VARS['products_id'])) {
    $orders_query = tep_db_query("select p.products_id, p.products_image, p.products_price, p.products_date_available from " . TABLE_ORDERS_PRODUCTS . " opa, " . TABLE_ORDERS_PRODUCTS . " opb, " . TABLE_ORDERS . " o, " . TABLE_PRODUCTS . " p where opa.products_id = '" . (int)$HTTP_GET_VARS['products_id'] . "' and opa.orders_id = opb.orders_id and opb.products_id != '" . (int)$HTTP_GET_VARS['products_id'] . "' and opb.products_id = p.products_id and opb.orders_id = o.orders_id and p.products_status = '1' group by p.products_id order by o.date_purchased desc limit " . MAX_DISPLAY_ALSO_PURCHASED);
    $num_products_ordered = tep_db_num_rows($orders_query);
    if ($num_products_ordered >= MIN_DISPLAY_ALSO_PURCHASED) {
      $counter = 0;
      $col = 0;


      ?>
            <div class="span12">
                <h2 class="also_pursh_title"><?php echo RELATED_PRODUCTS; ?></h2>


                <div class="carousel es-carousel-wrapper style0">
                    <div class="es-carousel">
                        <div class="row">
                            <div class="product_outer">


                        <?php
                            while ($orders = tep_db_fetch_array($orders_query)) {
                                $orders['products_name'] = tep_get_products_name($orders['products_id']);

                                $orders['specials_new_products_price'] = tep_get_products_special_price($orders['products_id']);

                                if (tep_not_null($orders['specials_new_products_price'])) {
                                    $products_new_added_price = '<span class="old">' . $currencies->display_price($orders['products_price'], tep_get_tax_rate($orders['products_tax_class_id'])) . '</span>
                                    <span class="new">' . $currencies->display_price($orders['specials_new_products_price'], tep_get_tax_rate($orders['products_tax_class_id'])) . '</span>';

                                    $sticker_sale = STICKER_SALE;
                                } else {
                                    $sticker_sale = '';
                                    $products_new_added_price = $currencies->display_price($orders['products_price'], tep_get_tax_rate($orders['products_tax_class_id']));
                                }

                                $products_new_added_price = '<div class="product-price">'.$products_new_added_price.'</div>';

                                /* if product has options */
                                $current_product =  $orders['products_id'];
                                $products_attributes_query = tep_db_query("select count(*) as total from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_ATTRIBUTES . " patrib where patrib.products_id='" . (int)$current_product . "' and patrib.options_id = popt.products_options_id and popt.language_id = '" . (int)$languages_id . "'");
                                $products_attributes = tep_db_fetch_array($products_attributes_query);

                                if ($products_attributes['total'] > 0) {
                                    $sticker_options = STICKER_OPTION;
                                }  else {
                                    $sticker_options = '';
                                }
                                /* if product has options */

                                if (tep_not_null($orders['products_date_available'])) {
                                    if ($orders['products_date_available'] <= date('Y-m-d H:i:s')) {
                                        $sticker_new = STICKER_NEW;
                                    }
                                } else {
                                    $sticker_new = '';
                                }

                                $rating	= rating_output($current_product);

                                /* if product has big img */
                                $products_new_added_big_img_query = tep_db_query("select distinct pi.image, pi.products_id from " . TABLE_PRODUCTS_IMAGES . " pi where pi.products_id = '$current_product' order by pi.id ASC ");

                                $realpath = DIR_FS_CATALOG.'/images/'. $orders['products_image'];


                                ?>
                                <!-- original product view -->
                                <div class="span3 product">

                                        <div class="product-image-wrapper">
                                            <!-- stickers -->
                                            <?php echo $sticker_sale.$sticker_options.$sticker_new; ?>
                                            <!-- stickers -->

                                            <a href="<?php echo tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $orders["products_id"]) ;?>">
                                                <?php if(file_exists($realpath)) {
                                                    echo tep_image(DIR_WS_IMAGES . $orders['products_image'], $orders['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT);
                                                } else { ?>
                                                    <img src="<?php echo DC_IMAGES.'empty.gif'; ?>" alt="">
                                                <?php } ?>
                                            </a>
                                        </div>

                                        <div class="wrapper-hover">
                                            <div class="product-name">
                                                <a href="<?php echo tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $orders["products_id"]) ;?>">
                                                    <?php echo trimmed_text($orders['products_name'] , 50) ?>
                                                </a>
                                            </div>
                                            <div class="wrapper">
                                                <?php echo $products_new_added_price; ?>
                                                <div class="product-tocart">
                                                    <a href="<?php echo tep_href_link(basename($PHP_SELF), tep_get_all_get_params(array('action')) . 'action=buy_now&products_id=' . $orders['products_id']) ?>"><i class="icon-basket"></i></a>
                                                </div>
                                            </div>

                                        </div>


                                </div>
                                <!-- end original product view -->

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
                                                        <a class="image" href="#" data-rel="<?php echo tep_href_link(DIR_WS_IMAGES . $products_new_added_big_img['image'], $products_new_added_big_img['products_name']); ?>">
                                                            <?php echo tep_image(DIR_WS_IMAGES . $products_new_added_big_img['image'], $products_new_added_big_img['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT, 'class="thumb"'); ?>
                                                        </a>
                                                    <?php } ?>
                                                    <!--  previews output -->
                                                </div>
                                    <?php }
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

                                            <!-- product has 1 previews -->
                                            <div class="col-2">

                                                <div class="big_image">
                                                    <a href="<?php echo tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $orders['products_id']); ?>">
                                                        <?php
                                                        if (tep_db_num_rows($products_new_added_big_img_query) > 0) {
                                                            echo tep_image(DIR_WS_IMAGES . $products_new_added_big_img['image'], $products_new_added_big_img['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT);
                                                        } else {
                                                            echo tep_image(DIR_WS_IMAGES . $orders['products_image'], $orders['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT);
                                                        }
                                                        ?>
                                                    </a>
                                                </div>

                                                <div class="wrapper-hover">
                                                    <div class="product-name">
                                                        <a href="<?php echo tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $orders["products_id"]) ;?>">
                                                            <?php echo trimmed_text($orders['products_name'] , 50) ?>
                                                        </a>
                                                    </div>
                                                    <div class="wrapper">
                                                        <?php echo $products_new_added_price; ?>
                                                        <div class="product-tocart">
                                                            <a href="<?php echo tep_href_link(basename($PHP_SELF), tep_get_all_get_params(array('action')) . 'action=buy_now&products_id=' . $orders['products_id']) ?>"><i class="icon-basket"></i></a>
                                                        </div>
                                                    </div>
                                                    <?php echo $rating; ?>
                                                </div>

                                            </div>
                                            <!-- product has 1 previews -->

                                        </div>
                                    </div>
                                <!-- rollover product view -->



                                <?php
                            }
                        ?>




                            </div>
                        </div>
                    </div>
                </div>


            </div>

  <?php
    }
  }
?>
