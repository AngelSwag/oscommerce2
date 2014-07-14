<?php

/*

  $Id$



  osCommerce, Open Source E-Commerce Solutions

  http://www.oscommerce.com



  Copyright (c) 2010 osCommerce



  Released under the GNU General Public License

*/



  require('includes/application_top.php');


if (!isset($HTTP_GET_VARS['products_id'])) {
    tep_redirect(tep_href_link(FILENAME_DEFAULT));
}

  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_PRODUCT_INFO);

  $product_check_query = tep_db_query("select count(*) as total from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_status = '1' and p.products_id = '" . (int)$HTTP_GET_VARS['products_id'] . "' and pd.products_id = p.products_id and pd.language_id = '" . (int)$languages_id . "'");
  $product_check = tep_db_fetch_array($product_check_query);

  require(DIR_WS_INCLUDES . 'template_top.php');
?>


<div itemscope itemtype="http://data-vocabulary.org/Product" class="product-box">
<div>
<?php
  if ($product_check['total'] < 1) {
?>



<div class="container">
    <div class="row">
        <div class="span12">
            <div class="empty_page">
                <div class="contentText">
                    <?php echo TEXT_PRODUCT_NOT_FOUND; ?>
                </div>

                <div class="f_right">
                    <?php echo tep_draw_button(IMAGE_BUTTON_CONTINUE, 'triangle-1-e', tep_href_link(FILENAME_DEFAULT)); ?>
                </div>
            </div>
        </div>
    </div>
</div>



<?php
  } else {

    $product_info_query = tep_db_query("select p.products_id, pd.products_name, pd.products_description, p.products_model, p.products_video, p.products_quantity, p.products_image, pd.products_url, p.products_price, p.products_tax_class_id, p.products_date_added, p.products_date_available, p.manufacturers_id from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_status = '1' and p.products_id = '" . (int)$HTTP_GET_VARS['products_id'] . "' and pd.products_id = p.products_id and pd.language_id = '" . (int)$languages_id . "'");
    $product_info = tep_db_fetch_array($product_info_query);



    tep_db_query("update " . TABLE_PRODUCTS_DESCRIPTION . " set products_viewed = products_viewed+1 where products_id = '" . (int)$HTTP_GET_VARS['products_id'] . "' and language_id = '" . (int)$languages_id . "'");



    if ($new_price = tep_get_products_special_price($product_info['products_id'])) {
      $products_price =
      '<span class="old-price"><span class="price">' . $currencies->display_price($product_info['products_price'], tep_get_tax_rate($product_info['products_tax_class_id'])) . '</span></span>
      <span class="special-price"><span itemprop="price" class="price">' . $currencies->display_price($new_price, tep_get_tax_rate($product_info['products_tax_class_id'])) . '</span></span>';
    } else {
      $products_price = '<span itemprop="price" class="regular_price">'.$currencies->display_price($product_info['products_price'], tep_get_tax_rate($product_info['products_tax_class_id'])). '</span>';
    }
      $products_name = $product_info['products_name'];


?>



<div>
    <div>





  <div class="span6">
        <div class="product-img-box">
            <div class="row">

                <!-- new gallery -->

      <?php
      if (tep_not_null($product_info['products_image'])) {
          $pi_query = tep_db_query("select image, htmlcontent from " . TABLE_PRODUCTS_IMAGES . " where products_id = '" . (int)$product_info['products_id'] . "' order by sort_order");
          if (tep_db_num_rows($pi_query) > 0 || tep_not_null($product_info['products_video'])) {
      ?>


              <div class="span1">
                    <div class="more-views">

                        <ul>
                        <?php
                            while ($pi = tep_db_fetch_array($pi_query)) {
                                $pi_counter ++;

                                if (PRODUCT_IMAGE_SCRIPT == 'fancybox') {
                                $pi_entry = '
                                  <li>
                                     <a class="fancybox" rel="group" href="'.tep_href_link(DIR_WS_IMAGES . $pi['image']).'" >'.
                                        tep_image(DIR_WS_IMAGES . $pi['image']) . '
                                      </a>
                                  </li>';
                                } else {
                                    $pi_entry = '
                                  <li>
                                     <a class="cloud-zoom-gallery" data-rel="useZoom:\'zoom1\', lensOpacity:1, smallImage: \''.tep_href_link(DIR_WS_IMAGES . $pi['image']).'\' " href="'.tep_href_link(DIR_WS_IMAGES . $pi['image']).'" >'.
                                        tep_image(DIR_WS_IMAGES . $pi['image']) . '
                                      </a>
                                  </li>';

                                }
                                echo $pi_entry;
                            }
                        ?>
                        <?php if (tep_not_null($product_info['products_video'])) { ?>

                            <li>
                                <a class="video various fancybox.iframe" href="http://www.youtube.com/embed/<?php echo $product_info['products_video']; ?>?autoplay=1">
                                    <i class="icon-video"></i>
                                </a>
                            </li>

                        <?php } ?>

                        </ul>


                    </div>
                </div>

          <?php
      }
        ?>

        <div class="<?php echo (tep_db_num_rows($pi_query) > 0 || tep_not_null($product_info['products_model'])) ? 'span5' : 'span6' ?>">

                    <div class="product-image">
                        <?php
                        $pi_query = tep_db_query("select image, htmlcontent from " . TABLE_PRODUCTS_IMAGES . " where products_id = '" . (int)$product_info['products_id'] . "' order by sort_order");
                        $pi = tep_db_fetch_array($pi_query);
                        ?>

                     <!-- big image output -->
                    <?php if (tep_db_num_rows($pi_query) > 0 ) {

                             if (PRODUCT_IMAGE_SCRIPT == 'fancybox') {  ?>
                            <a class="fancybox" rel="group" href="<?php echo tep_href_link(DIR_WS_IMAGES . $pi['image']); ?>">
                               <?php echo tep_image(DIR_WS_IMAGES . $pi['image'], '', '', '', 'itemprop="image" id="image"'); ?>
                            </a>
                        <?php  } else {  ?>
                            <a class="cloud-zoom" href="<?php echo tep_href_link(DIR_WS_IMAGES . $pi['image']); ?>" id='zoom1' data-rel="adjustX:-4, adjustY:-4, softFocus:true">
                                <?php echo tep_image(DIR_WS_IMAGES . $pi['image'], '', '', '', 'itemprop="image"'); ?>
                            </a>
                        <?php  }

                    } else {


                     /* no small previews */

                        if (PRODUCT_IMAGE_SCRIPT == 'fancybox') {
                        echo '<a class="fancybox" rel="group" href="' . tep_href_link(DIR_WS_IMAGES . $product_info['products_image'], '', 'NONSSL', false) . '">' . tep_image(DIR_WS_IMAGES . $product_info['products_image'], addslashes($product_info['products_name']), '', '', '', 'itemprop="image"') . '</a>';
                        } else {
                        echo '<a href="' . tep_href_link(DIR_WS_IMAGES . $product_info['products_image'], '', 'NONSSL', false) . '" class="cloud-zoom" id="zoom1" data-rel="adjustX:-4, adjustY:-4, softFocus:true">' . tep_image(DIR_WS_IMAGES . $product_info['products_image'], addslashes($product_info['products_name']), '', '', '', 'itemprop="image"') . '</a>';
                        }

                     /* no small previews */
                        } ?>

                        <!-- big image output -->

                    </div>
                </div>
                <!-- new gallery -->



        </div>
    </div>



    </div>








<?php
    }
?>

<div class="span6">

         <?php /* ALL PRODUCT INFO */ ?>
           <div class="product-shop">

                <!-- CUSTOM BLOCK -->
<?php if (PRODUCT_INFO_VIEW !== 'without') { ?>

               <div class="product_custom">
                   <h2 class="custom_block_title"><?php echo PRODUCT_CUSTOM_BLOCK; ?></h2>

      <?php

          $custom_block_query = tep_db_query("SELECT menu_block_content FROM `custom_product_block` where `menu_block_id` = '$languages_id' ");
          if (tep_db_num_rows($custom_block_query) > 0) {
                   $custom_block_output = tep_db_fetch_array($custom_block_query);
                  if ($custom_block_output['menu_block_content'] !== '') {
                      echo stripslashes($custom_block_output['menu_block_content']);
                  } else {
                       echo CUSTOM_PRODUCT_BLOCK_CONTENT;
                  }

          } else {
              echo CUSTOM_PRODUCT_BLOCK_CONTENT;
          }
      ?>

        </div>




<?php } ?>

               <!-- CUSTOM BLOCK -->


               <div class="product_info_left">

            <?php echo tep_draw_form('cart_quantity', tep_href_link(FILENAME_PRODUCT_INFO, tep_get_all_get_params(array('action')) . 'action=add_product')); ?>


            <div class="prod_info_name_price">
                <div class="product-name"><h1 itemprop="name"><?php echo $products_name; ?></h1></div>

                <?php echo '<p class="availability in-stock">'.AVAILABILITY.'<strong itemprop="availability"> '.AVAILABILITY_IN.'</strong></p>'; ?>

                <?php
                if ($product_info['products_description'] !== '') {
                    echo '<div class="short-description">'.stripslashes($product_info['products_description']).'</div>';
                }
                ?>

                <div itemprop="offerDetails" itemscope itemtype="http://data-vocabulary.org/Offer" class="price-box"><?php echo $products_price; ?></div>


            </div>

<?php
    $products_attributes_query = tep_db_query("select count(*) as total from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_ATTRIBUTES . " patrib where patrib.products_id='" . (int)$HTTP_GET_VARS['products_id'] . "' and patrib.options_id = popt.products_options_id and popt.language_id = '" . (int)$languages_id . "'");
    $products_attributes = tep_db_fetch_array($products_attributes_query);
    if ($products_attributes['total'] > 0) {
//++++ QT Pro: Begin Changed code
      $products_id=(preg_match("/^\d{1,10}(\{\d{1,10}\}\d{1,10})*$/",$HTTP_GET_VARS['products_id']) ? $HTTP_GET_VARS['products_id'] : (int)$HTTP_GET_VARS['products_id']); 
      require(DIR_WS_CLASSES . 'pad_' . PRODINFO_ATTRIBUTE_PLUGIN . '.php');
      $class = 'pad_' . PRODINFO_ATTRIBUTE_PLUGIN;
      $pad = new $class($products_id);
      echo $pad->draw();
    }

//Display a table with which attributecombinations is on stock to the customer?
if(PRODINFO_ATTRIBUTE_DISPLAY_STOCK_LIST == 'True'): require(DIR_WS_MODULES . "qtpro_stock_table.php"); endif;

//++++ QT Pro: End Changed Code
?>


<?php
    $products_attributes_query = tep_db_query("select count(*) as total from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_ATTRIBUTES . " patrib where patrib.products_id='" . (int)$HTTP_GET_VARS['products_id'] . "' and patrib.options_id = popt.products_options_id and popt.language_id = '" . (int)$languages_id . "'");
    $products_attributes = tep_db_fetch_array($products_attributes_query);
    if ($products_attributes['total'] > 0) {
?>


        <p class="clearfix options_form_label"><?php echo TEXT_PRODUCT_OPTIONS; ?></p>

        <p class="clearfix options_form">
        <?php
      $products_options_name_query = tep_db_query("select distinct popt.products_options_id, popt.products_options_name from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_ATTRIBUTES . " patrib where patrib.products_id='" . (int)$HTTP_GET_VARS['products_id'] . "' and patrib.options_id = popt.products_options_id and popt.language_id = '" . (int)$languages_id . "' order by popt.products_options_name");
      while ($products_options_name = tep_db_fetch_array($products_options_name_query)) {
        $products_options_array = array();

		//<!-- AJAX Attribute Manager -->
		//        $products_options_query = tep_db_query("select pov.products_options_values_id, pov.products_options_values_name, pa.options_values_price, pa.price_prefix from " . TABLE_PRODUCTS_ATTRIBUTES . " pa, " . TABLE_PRODUCTS_OPTIONS_VALUES . " pov where pa.products_id = '" . (int)$HTTP_GET_VARS['products_id'] . "' and pa.options_id = '" . (int)$products_options_name['products_options_id'] . "' and pa.options_values_id = pov.products_options_values_id and pov.language_id = '" . (int)$languages_id . "'");
		        $products_options_query = tep_db_query("select pov.products_options_values_id, pov.products_options_values_name, pa.options_values_price, pa.price_prefix from " . TABLE_PRODUCTS_ATTRIBUTES . " pa, " . TABLE_PRODUCTS_OPTIONS_VALUES . " pov where pa.products_id = '" . (int)$HTTP_GET_VARS['products_id'] . "' and pa.options_id = '" . (int)$products_options_name['products_options_id'] . "' and pa.options_values_id = pov.products_options_values_id and pov.language_id = '" . (int)$languages_id . "' order by pa.products_options_sort_order");
		//<!-- AJAX Attribute Manager end -->        
        while ($products_options = tep_db_fetch_array($products_options_query)) {
          $products_options_array[] = array('id' => $products_options['products_options_values_id'], 'text' => $products_options['products_options_values_name']);
          if ($products_options['options_values_price'] != '0') {
            $products_options_array[sizeof($products_options_array)-1]['text'] .= ' (' . $products_options['price_prefix'] . $currencies->display_price($products_options['options_values_price'], tep_get_tax_rate($product_info['products_tax_class_id'])) .') ';
          }
        }

        if (is_string($HTTP_GET_VARS['products_id']) && isset($cart->contents[$HTTP_GET_VARS['products_id']]['attributes'][$products_options_name['products_options_id']])) {
          $selected_attribute = $cart->contents[$HTTP_GET_VARS['products_id']]['attributes'][$products_options_name['products_options_id']];
        } else {
          $selected_attribute = false;
        }
?>

      <strong><?php echo $products_options_name['products_options_name'] . ':'; ?></strong><br class="br_space" /><br class="br_space" /><?php echo tep_draw_pull_down_menu('id[' . $products_options_name['products_options_id'] . ']', $products_options_array, $selected_attribute); ?><br class="br_space" /><br class="br_space" />

<?php
      }
?>

    </p>


<?php
    }
?>
                   <!-- add to cart box -->
            <div class="clearfix add-to-cart">
                 <?php echo '<div class="btn-cart">'.tep_draw_hidden_field('products_id', $product_info['products_id']) . tep_draw_button(IMAGE_BUTTON_IN_CART, 'cart', null, 'primary').'</div>';  ?>
            </div>
                   <!-- end add to cart box -->

        </form>


                   <!-- socialsplugins -->
                   <div class="clearfix socialsplugins_wrapper">
                        <div class="facebook_button">
                            <script>(function(d, s, id) {
                                var js, fjs = d.getElementsByTagName(s)[0];
                                if (d.getElementById(id)) return;
                                js = d.createElement(s); js.id = id;
                                js.src = "//connect.facebook.net/en_GB/all.js#xfbml=1";
                                fjs.parentNode.insertBefore(js, fjs);
                            }(document, 'script', 'facebook-jssdk'));</script>
                            <div class="fb-like" data-send="false" data-layout="button_count" data-width="94" data-show-faces="false" data-font="arial"></div>
                        </div>

                        <div class="twitter_button">
                            <a rel="nofollow" href="http://twitter.com/share" class="twitter-share-button" data-count="horizontal" data-via="tonytemplates"></a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
                        </div>
                        <div class="pin-it-button">
                            <script type="text/javascript" src="http://assets.pinterest.com/js/pinit.js"></script>
                            &nbsp;&nbsp;<a href="http://pinterest.com/pin/create/button/" class="pin-it-button" count-layout="Horizontal">
                            <img src="//assets.pinterest.com/images/PinExt.png" alt="Pin it" /></a>
                        </div>
                        <div class="clear"></div>
                   </div>
                   <!-- end socialsplugins -->


               </div>

           </div>
        <?php /* ALL PRODUCT INFO */ ?>





    </div>

    <!-- tags -->
    <div class="product_tags">
        <div class="row">
            <div class="span12">
                <ul class="nav-tabs" id="myTab">


            <?php
                 if ($product_info['products_description'] !== '') {
            ?>
                       <li class="active"><a href="#tab1"><?php echo DESCRIPTION; ?></a></li>
            <?php
                 }
            ?>
                        <li><a href="#tab2"><?php echo MENU_TEXT_REVIEWS_FOOTER; ?></a></li>
                </ul>
                <div class="tab-content">


            <?php
                if ($product_info['products_description'] !== '') {
            ?>

                    <div itemprop="description" class="tab-pane active" id="tab1">
                        <?php echo stripslashes($product_info['products_description']); ?>
                    </div>
            <?php
                }
            ?>



                    <div class="tab-pane" id="tab2">
                        <!-- reviews box -->
                        <div itemprop="review" itemscope itemtype="http://data-vocabulary.org/Review-aggregate" class="reviews-box">

                            <?php
                            $reviews_query = tep_db_query("select count(*) as count, r.reviews_rating from " . TABLE_REVIEWS . " r, " . TABLE_REVIEWS_DESCRIPTION . " rd where r.products_id = '" . (int)$HTTP_GET_VARS['products_id'] . "' and r.reviews_id = rd.reviews_id and rd.languages_id = '" . (int)$languages_id . "' and reviews_status = 1");
                            $reviews = tep_db_fetch_array($reviews_query);

                            $review_query_rating = tep_db_query("SELECT ROUND(SUM(`reviews_rating`)/COUNT(`reviews_id`)) as rating
             FROM " . TABLE_REVIEWS . " WHERE products_id = '" . $product_info['products_id'] . "'  AND `reviews_status` = 1");
                            $review_rating = tep_db_fetch_array($review_query_rating);

                            if ($reviews['count'] == 0) {
                                echo
                                    '<p class="no-rating">'
                                    .tep_draw_button(NO_RATING, 'comment', tep_href_link(FILENAME_PRODUCT_REVIEWS_WRITE, tep_get_all_get_params()), 'primary').'</p>';
                            } else {
                                echo '<div class="rating-stars">
                                 '.rating_output($product_info['products_id']).'&nbsp;&nbsp;&nbsp;&nbsp;
                                 <a class="reviews_link" href="'.tep_href_link(FILENAME_PRODUCT_REVIEWS, 'products_id=' . $product_info['products_id']).'"><span itemprop="count">'.$reviews['count'].'</span>&nbsp;'.MENU_TEXT_REVIEWS.'</a>&nbsp;&nbsp;<span>|</span>&nbsp;&nbsp;
                                 '.tep_draw_button(ADD_REVIEW, 'comment', tep_href_link(FILENAME_PRODUCT_REVIEWS_WRITE, tep_get_all_get_params()), 'primary').'
                                 </div>';
                            }
                            ?>


                        </div>
                        <!-- end reviews box -->
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- tags -->

    </div>
    </div>
</div>





</div>


<?php
    if ((USE_CACHE == 'true') && empty($SID)) {
      echo tep_cache_also_purchased(3600);
    } else {
      include(DIR_WS_MODULES . FILENAME_ALSO_PURCHASED_PRODUCTS);
    }

if (PRODUCT_IMAGE_SCRIPT == 'fancybox') {  ?>
    <script type="text/javascript">
        jQuery(".fancybox").fancybox();
    </script>
<?php
}
?>
  <script type="text/javascript">
      jQuery(".various").fancybox({
          maxWidth	: 800,
          maxHeight	: 600,
          fitToView	: false,
          width		: '70%',
          height		: '70%',
          autoSize	: false,
          closeClick	: false,
          openEffect	: 'none',
          closeEffect	: 'none'
      });

  </script>

  <?php
  }

  require(DIR_WS_INCLUDES . 'template_bottom.php');
  require(DIR_WS_INCLUDES . 'application_bottom.php');

?>

