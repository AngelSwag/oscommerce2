<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  class bm_specials {
    var $code = 'bm_specials';
    var $group = 'boxes';
    var $title;
    var $description;
    var $sort_order;
    var $enabled = false;

    function bm_specials() {
      $this->title = MODULE_BOXES_SPECIALS_TITLE;
      $this->description = MODULE_BOXES_SPECIALS_DESCRIPTION;

      if ( defined('MODULE_BOXES_SPECIALS_STATUS') ) {
        $this->sort_order = MODULE_BOXES_SPECIALS_SORT_ORDER;
        $this->enabled = (MODULE_BOXES_SPECIALS_STATUS == 'True');

        $this->group = ((MODULE_BOXES_SPECIALS_CONTENT_PLACEMENT == 'Left Column') ? 'boxes_column_left' : 'boxes_column_right');
      }
    }

    function execute() {
      global $HTTP_GET_VARS, $languages_id, $currencies, $oscTemplate;

      if (!isset($HTTP_GET_VARS['products_id'])) {
        if ($random_product = tep_random_select("select p.products_id, pd.products_name, p.products_price, p.products_tax_class_id, p.products_image, s.specials_new_products_price from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_SPECIALS . " s where p.products_status = '1' and p.products_id = s.products_id and pd.products_id = s.products_id and pd.language_id = '" . (int)$languages_id . "' and s.status = '1' order by s.specials_date_added desc limit " . MAX_RANDOM_SELECT_SPECIALS)) {

            $special_price = '<span class="old">' . $currencies->display_price($random_product['products_price'], tep_get_tax_rate($random_product['products_tax_class_id'])) . '</span>
            <span class="new">' . $currencies->display_price($random_product['specials_new_products_price'], tep_get_tax_rate($random_product['products_tax_class_id'])) . '</span>';
            $special_price_last = '<div class="product-price">'.$special_price.'</div>';

            /* if product has big img */
            $current_product =  $random_product['products_id'];
            $products_new_added_big_img_query = tep_db_query("select distinct pi.image, pi.products_id from " . TABLE_PRODUCTS_IMAGES . " pi where pi.products_id = '$current_product' order by pi.id ASC ");
            if (tep_db_num_rows($products_new_added_big_img_query) > 0) {
                $products_new_added_big_img = tep_db_fetch_array($products_new_added_big_img_query);
                $rollover =
                '<div class="preview hidden-tablet hidden-phone">
                     <div class="wrapper">
                        <div class="col-2">
                            <div class="big_image">
                                <a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $products_new_added_big_img["products_id"]) . '">
                                    ' . tep_image(DIR_WS_IMAGES . $products_new_added_big_img['image'], $products_new_added_big_img['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '
                                </a>
                            </div>
                        </div>
                     </div>
                </div>
                ';

            }
            /* if product has big img */



            $data = '
		  <div class="infoBox infoBoxSpecials">
                <div class="infoBoxHeading"><a href="' . tep_href_link(FILENAME_SPECIALS) . '">' . MODULE_BOXES_SPECIALS_BOX_TITLE . '</a></div>
                <div class="infoBoxContents">

                     <div class="product">
                            <div class="product-image-wrapper">
                                <a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $random_product["products_id"]) . '">
                                    ' . tep_image(DIR_WS_IMAGES . $random_product['products_image'], $random_product['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT, 'class="scale-with-grid"') . '
                                </a>
                            </div>
                            <div class="wrapper-hover">
                                <div class="product-name">
                                   <a class="icon_cart_title" href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $random_product['products_id']) . '">
                                       '.$random_product['products_name'].'
                                   </a>
                                </div>
                                <div class="wrapper">
                                    '.$special_price_last.'
                                    <div class="product-tocart">
                                       <a href="' . tep_href_link(basename('shopping_cart.php'), tep_get_all_get_params(array('action')) . 'action=buy_now&products_id=' . $random_product['products_id']) . '"><i class="icon-basket"></i></a>
                                    </div>
                                </div>
                            </div>
                     </div>

                </div>

          </div>';

          $oscTemplate->addBlock($data, $this->group);
        }
      }
    }

    function isEnabled() {
      return $this->enabled;
    }

    function check() {
      return defined('MODULE_BOXES_SPECIALS_STATUS');
    }

    function install() {
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Enable Specials Module', 'MODULE_BOXES_SPECIALS_STATUS', 'True', 'Do you want to add the module to your shop?', '6', '1', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Content Placement', 'MODULE_BOXES_SPECIALS_CONTENT_PLACEMENT', 'Left Column', 'Should the module be loaded in the left or right column?', '6', '1', 'tep_cfg_select_option(array(\'Left Column\', \'Right Column\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'MODULE_BOXES_SPECIALS_SORT_ORDER', '2', 'Sort order of display. Lowest is displayed first.', '6', '0', now())");
    }

    function remove() {
      tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('MODULE_BOXES_SPECIALS_STATUS', 'MODULE_BOXES_SPECIALS_CONTENT_PLACEMENT', 'MODULE_BOXES_SPECIALS_SORT_ORDER');
    }
  }
?>
