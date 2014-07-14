<?php
/*
  $Id$
  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com
  Copyright (c) 2010 osCommerce
  Released under the GNU General Public License
*/

$listing_sql = str_replace('pd.products_name,', 'pd.products_name, pd.products_description, ', $listing_sql);
$listing_split = new splitPageResults($listing_sql, MAX_DISPLAY_SEARCH_RESULTS, 'p.products_id');
$column3 = 0;
$column2 = 0;
$column4 = 0;
$column6 = 0;
?>



<div class="row <?php echo (LISTING_IMAGES_SIZE == 'small') ? 'small_with_description' : 'big_with_description'; ?>">

<?php
    if ( ($listing_split->number_of_rows > 0) && ( (PREV_NEXT_BAR_LOCATION == '1') || (PREV_NEXT_BAR_LOCATION == '3') ) ) {
?>
    <div class="toolbar_top">
      <span class="f_right"><?php echo TEXT_RESULT_PAGE . ' ' . $listing_split->display_links(MAX_DISPLAY_PAGE_LINKS, tep_get_all_get_params(array('page', 'info', 'x', 'y'))); ?></span>
      <span><?php echo $listing_split->display_count(TEXT_DISPLAY_NUMBER_OF_PRODUCTS); ?></span>
    </div>
    <br />

<?php
  }

  $prod_list_contents = '<div class="infoBoxContainer">';

  if ( !empty($column_list) ) {
  $prod_list_contents .='  <div class="sort_text">' .
                        '    <table>' .
                        '      <tr>' .
                        '      <td><b>'.TEXT_SORT_PRODUCTS.' '.TEXT_BY.':</b>  ';

  for ($col=0, $n=sizeof($column_list); $col<$n; $col++) {
    $lc_align = '';

    switch ($column_list[$col]) {
      case 'PRODUCT_LIST_MODEL':
        $lc_text = TABLE_HEADING_MODEL;
        $lc_align = '';
        break;
      case 'PRODUCT_LIST_NAME':
        $lc_text = TABLE_HEADING_PRODUCTS;
        $lc_align = '';
        break;
      case 'PRODUCT_LIST_MANUFACTURER':
        $lc_text = TABLE_HEADING_MANUFACTURER;
        $lc_align = '';
        break;
      case 'PRODUCT_LIST_PRICE':
        $lc_text = TABLE_HEADING_PRICE;
        $lc_align = 'right';
        break;
      case 'PRODUCT_LIST_QUANTITY':
        $lc_text = TABLE_HEADING_QUANTITY;
        $lc_align = 'right';
        break;
      case 'PRODUCT_LIST_WEIGHT':
        $lc_text = TABLE_HEADING_WEIGHT;
        $lc_align = 'right';
        break;
      case 'PRODUCT_LIST_IMAGE':
        $lc_text = TABLE_HEADING_IMAGE;
        $lc_align = 'center';
        break;
    }

    if ( ($column_list[$col] != 'PRODUCT_LIST_BUY_NOW') && ($column_list[$col] != 'PRODUCT_LIST_IMAGE') ) {
      $lc_text = tep_create_sort_heading($HTTP_GET_VARS['sort'], $col+1, $lc_text);
      $prod_list_contents .= '  '.$lc_text.'  ' ;
    }
  }


  $prod_list_contents .= '</td></tr></table></div>';

  }
  if ($listing_split->number_of_rows > 0) {
    $rows = 0;
    $listing_query = tep_db_query($listing_split->sql_query);
    $counter = 0;
    $col = 0;
    $width = floor(100 / $megastore_grids);
    $num_products = tep_db_num_rows($listing_query);

    while ($listing = tep_db_fetch_array($listing_query)) {
        $counter++;
        if ($new_price = tep_get_products_special_price($listing['products_id'])) {
            $products_price = '
            <span class="old">' .$currencies->display_price($listing['products_price'], tep_get_tax_rate($listing['products_tax_class_id'])). '</span>
            <span class="new">' .$currencies->display_price($listing['specials_new_products_price'], tep_get_tax_rate($listing['products_tax_class_id'])) . '</span>';
            $product['sticker_sale'] = STICKER_SALE;

        } else {
            $products_price =  $currencies->display_price($listing['products_price'], tep_get_tax_rate($listing['products_tax_class_id']));
            $product['sticker_sale']		= '';
        }

        $products_price = '<span class="new_price">'.$products_price.'</span>';

        $product['id']				= $listing['products_id'];
        $product['name']			= $listing['products_name'];
        $product['price']			= $products_price;
        $product['price_special']	= $products_price_special;
        $product['name_url']		= tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $listing['products_id']);
        $product['image']           = tep_image(DIR_WS_IMAGES . $listing['products_image'], $listing['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT);

        $product['review']	= rating_output($listing['products_id']);


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

        if (tep_not_null($listing['products_date_available'])) {
            //if ($listing['products_date_available'] <= date('Y-m-d H:i:s')) {
                $sticker_new = STICKER_NEW;
           // }
        } else {
            $sticker_new = '';
        }


        /* if product has big img */





      $product['cart_url']		= tep_href_link($PHP_SELF, tep_get_all_get_params(array('action', 'products_id')) . 'action=buy_now&products_id=' . $listing['products_id']);
        if ($column6 == 6) {$column6 = 1;} else  {$column6 ++;}
        if ($column4 == 4) {$column4 = 1;} else  {$column4 ++;}
        if ($column3 == 3) {$column3 = 1;} else  {$column3 ++;}
        if ($column2 == 2) {$column2 = 1;} else  {$column2 ++;}

        include(DC_BLOCKS. 'megastore_model_listing.php');

        $prod_list_contents .= $megastore_listing_output;
        $col ++;
        if (($col >= $megastore_grids) || ($counter == $num_products)) {
            while ( $col < $megastore_grids ) {
                $col++;
            }
            $col = 0;
        }
    }
    $prod_list_contents .= '</div>';
    echo $prod_list_contents;
  } else {
?>
    <p class="margin_discard no_products"><?php echo TEXT_NO_PRODUCTS; ?></p>
<?php
  }
  if ( ($listing_split->number_of_rows > 0) && ((PREV_NEXT_BAR_LOCATION == '2') || (PREV_NEXT_BAR_LOCATION == '3')) ) {
?>

    <div class="toolbar_bottom">
        <?php echo '<label>'.TEXT_RESULT_PAGE.'</label>' . ' ' . $listing_split->display_links(MAX_DISPLAY_PAGE_LINKS, tep_get_all_get_params(array('page', 'info', 'x', 'y'))); ?>
    </div>

<?php

  }

?>

</div>