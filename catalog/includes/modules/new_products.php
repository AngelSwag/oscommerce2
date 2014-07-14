<?php
/*
  $Id$
  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com
  Copyright (c) 2010 osCommerce
  Released under the GNU General Public License
*/

$column3 = 0;
$column2 = 0;
$column4 = 0;
$column6 = 0;
if ( (!isset($new_products_category_id)) || ($new_products_category_id == '0') ) {
    $new_products_query = tep_db_query(
        "select
            p.products_id, p.products_image, p.products_tax_class_id, pd.products_name, pd.products_description,
            p.products_date_available,
            p.products_price, if(s.status, s.specials_new_products_price, null) as specials_new_products_price
        from
            " . TABLE_PRODUCTS . " p left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id,
            " . TABLE_PRODUCTS_DESCRIPTION . " pd
        where
            p.products_status = '1'
            and p.products_id = pd.products_id
            and pd.language_id = '" . (int)$languages_id . "'
        order by
            p.products_date_added desc
        limit " . MAX_DISPLAY_NEW_PRODUCTS);
  } else {
    $new_products_query = tep_db_query(
        "select
            distinct p.products_id, p.products_image, p.products_tax_class_id, pd.products_name, pd.products_description,
            p.products_date_available,
            p.products_price, if(s.status, s.specials_new_products_price, null) as specials_new_products_price
        from
            " . TABLE_PRODUCTS . " p left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id,
            " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c, " . TABLE_CATEGORIES . " c
        where
            p.products_id = p2c.products_id
            and p2c.categories_id = c.categories_id
            and c.parent_id = '" . (int)$new_products_category_id . "'
            and p.products_status = '1'
            and p.products_id = pd.products_id
            and pd.language_id = '" . (int)$languages_id . "'
        order by
            p.products_date_added desc
        limit " . MAX_DISPLAY_NEW_PRODUCTS);
  }

  $num_new_products = tep_db_num_rows($new_products_query);
  if ($num_new_products > 0) {
    $counter = 0;
    $col = 0;

    while ($new_products = tep_db_fetch_array($new_products_query)) {
        $counter++;
        if ($new_price = tep_get_products_special_price($new_products['products_id'])) {
            $products_price = '
            <span class="old">' .  $currencies->display_price($new_products['products_price'], tep_get_tax_rate($new_products['products_tax_class_id'])) . '</span>
            <span class="new">' . $currencies->display_price($new_products['specials_new_products_price'], tep_get_tax_rate($new_products['products_tax_class_id'])) . '</span>';
            $product['sticker_sale'] = STICKER_SALE;

        } else {
            $products_price = $currencies->display_price($new_products['products_price'], tep_get_tax_rate($new_products['products_tax_class_id']));
            $product['sticker_sale'] = '';
        }

        $products_price = '<span class="new_price">'.$products_price.'</span>';


        $product['id']				= $new_products['products_id'];
        $product['name']			= $new_products['products_name'];
        $product['price']			= $products_price;
        $product['name_url']		= tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $new_products['products_id']);
        $product['image']           = tep_image(DIR_WS_IMAGES . $new_products['products_image'], $new_products['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT);
        $product['review']	= rating_output($new_products['products_id']);

        /* if product has options */
        $current_product =  $product['id'];
        $products_attributes_query = tep_db_query("select count(*) as total from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_ATTRIBUTES . " patrib where patrib.products_id='" . (int)$current_product . "' and patrib.options_id = popt.products_options_id and popt.language_id = '" . (int)$languages_id . "'");
        $products_attributes = tep_db_fetch_array($products_attributes_query);
        if ($products_attributes['total'] > 0) {
            $product['sticker_options'] =  STICKER_OPTION;
        }  else {
             $product['sticker_options'] = '';
        }
        /* if product has options */

        /* if product has big img */


        if (tep_not_null($new_products['products_date_available'])) {
            //if ($new_products['products_date_available'] <= date('Y-m-d H:i:s')) {
                $sticker_new = STICKER_NEW;
            //}
        } else {
            $sticker_new = '';
        }





        $product['cart_url']		= tep_href_link(basename($PHP_SELF), tep_get_all_get_params(array('action')) . 'action=buy_now&products_id=' . $new_products['products_id']);
        if ($column6 == 6) {$column6 = 1;} else  {$column6 ++;}
        if ($column4 == 4) {$column4 = 1;} else  {$column4 ++;}
        if ($column3 == 3) {$column3 = 1;} else  {$column3 ++;}
        if ($column2 == 2) {$column2 = 1;} else  {$column2 ++;}

        include(DC_BLOCKS. 'megastore_model_listing.php');

        $new_prods_content .= $megastore_listing_output;

        $col ++;

        if (($col >= $megastore_grids) || ($counter == $num_new_products)) {
            $col = 0;
        }
    }
?>

  <div class="row <?php echo (LISTING_IMAGES_SIZE == 'small') ? 'small_with_description' : 'big_with_description'; ?>">
  <?php echo $new_prods_content; ?>
  </div>

<?php
  }
?>

