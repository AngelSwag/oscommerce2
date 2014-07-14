<?php
/*
  $Id$ cs_commission_junction
  2013 G.L. Walker - http://wsfive.com
  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com
  Copyright (c) 2010 osCommerce
  Released under the GNU General Public License
*/

  class cs_commission_junction {
    var $code = 'cs_commission_junction';
    var $group = 'checkout_success';
    var $title;
    var $description;
    var $sort_order;
    var $enabled = false;

    function cs_commission_junction() {
      $this->title = MODULE_CHECKOUT_SUCCESS_COMMISSION_JUNCTION_TITLE;
      $this->description = MODULE_CHECKOUT_SUCCESS_COMMISSION_JUNCTION_DESCRIPTION;

      if ( defined('MODULE_CHECKOUT_SUCCESS_COMMISSION_JUNCTION_STATUS') ) {
        $this->sort_order = MODULE_CHECKOUT_SUCCESS_COMMISSION_JUNCTION_SORT_ORDER;
        $this->enabled = (MODULE_CHECKOUT_SUCCESS_COMMISSION_JUNCTION_STATUS == 'True');
      }
    }

    function execute() {
      global $oscTemplate, $customer_id, $pixel, $affiliate_ref, $cj_discount, $cj_math, $cj_name, $cj_name_id, $cj_order, $cj_order_id, $cj_push, $cj_subtotal, $cj_subtotal_round, $cj_total, $cj_value, $order_products;

 

        if ( (!isset($affiliate_ref)) && tep_session_is_registered('customer_id') ) {									
          $cj_order_query = tep_db_query("select orders_id, payment_method, currency from " . TABLE_ORDERS . " where customers_id = '" . (int)$customer_id . "' order by date_purchased desc limit 1");

            $cj_order = tep_db_fetch_array($cj_order_query);
			$cj_order_id = (int)$cj_order['orders_id'];

		   $cj_subtotal_query = tep_db_query("select value from orders_total where orders_id = '". $cj_order_id ."' and class = 'ot_subtotal'");
			$cj_subtotal = tep_db_fetch_array($cj_subtotal_query);
			
			$cj_subtotal_round = tep_round($cj_subtotal['value'], 2);
			$cj_discount_query = tep_db_query("select * from " . TABLE_ORDERS_TOTAL . " where orders_id = '". $cj_order_id ."'");
			$cj_discount = 0;
			
			while ($cj_total = tep_db_fetch_array($cj_discount_query)) {
				if ($cj_total['class'] == "ot_discount_coupon")  {
					$cj_discount = tep_round($cj_total['value'], 2);
					$cj_math = $cj_subtotal_round += $cj_discount;
				} 
				if ($cj_total['class'] == "ot_coupon")  {
					$cj_discount = tep_round($cj_total['value'], 2);
					$cj_math = $cj_subtotal_round - $cj_discount;
				}         
			}
			
			
			if ($cj_discount) {
				$cj_push = $cj_math;
			} else {
				$cj_push =  $cj_subtotal_round;
			}
			$cj_value = $cj_push;
			
	////////// now pull customer and affiliate info
			
			$cj_name_id_query = tep_db_query("select customers_lastname from customers where customers_id = '" . (int)$customer_id . "'");
			$cj_name_id = tep_db_fetch_array($cj_name_id_query);
			$cj_name = $cj_name_id['customers_lastname'];
			$cj_name .= 'A'.$cj_order_id;
		/*	if (isset($affiliate_ref)){
				$cj_name .= '_'.$affiliate_ref;
			}
		*/
							
		if (MODULE_CHECKOUT_SUCCESS_COMMISSION_JUNCTION_IB_TRACKING == 'True') {
			
			 $pixel .= '	<img src="https://www.emjcd.com/u?CID='. MODULE_CHECKOUT_SUCCESS_COMMISSION_JUNCTION_ID .'&OID='. $cj_name .'&TYPE='. MODULE_CHECKOUT_SUCCESS_COMMISSION_JUNCTION_ACTION_ID;

            $order_products_query = tep_db_query("select op.products_id, pd.products_name, op.final_price, op.products_quantity from " . TABLE_ORDERS_PRODUCTS . " op, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_LANGUAGES . " l where op.orders_id = '". $cj_order_id ."' and op.products_id = pd.products_id and l.code = '" . tep_db_input(DEFAULT_LANGUAGE) . "' and l.languages_id = pd.language_id");
            while ($order_products = tep_db_fetch_array($order_products_query)) {
				$count++;
				$pixel .= '&ITEM' . $count . '='. (int)$order_products['products_id'] . 'sku&AMT' . $count . '=' . $this->format_raw($order_products['final_price']) . '&QTY' . $count . '=' . (int)$order_products['products_quantity'];
    
            }

			if ($cj_discount) {
			$pixel .= '&DISCOUNT='. str_replace("-", "",$cj_discount);
			}
            $pixel .= '&CURRENCY='. $cj_order['currency'] .'&METHOD=IMG" height="1" width="20">' . PHP_EOL; 
          } else {
			
			 
			$pixel .= '	<img src="https://www.emjcd.com/u?AMOUNT='. $cj_value .'&CID='. MODULE_CHECKOUT_SUCCESS_COMMISSION_JUNCTION_ID .'&OID='. $cj_name .'&TYPE='. MODULE_CHECKOUT_SUCCESS_COMMISSION_JUNCTION_ACTION_ID .'&KEEP=YES&METHOD=IMG" height=1 width=1>' . PHP_EOL;	
		}
		
		if ($cj_order['payment_method'] != MODULE_CHECKOUT_SUCCESS_COMMISSION_JUNCTION_EXCLUSION) {
			
		  $cs_data  = '	<!-- Begin Commision Junction -->' . PHP_EOL;
		  $cs_data .= 		$pixel . PHP_EOL;
		  $cs_data .= '	<!-- End Commission Junction -->' . PHP_EOL;
		}
        $oscTemplate->addBlock($cs_data, $this->group);
      }
    }

    function format_raw($number, $currency_code = '', $currency_value = '') {
      global $currencies, $currency;

      if (empty($currency_code) || !$currencies->is_set($currency_code)) {
        $currency_code = $currency;
      }

      if (empty($currency_value) || !is_numeric($currency_value)) {
        $currency_value = $currencies->currencies[$currency_code]['value'];
      }

      return number_format(tep_round($number * $currency_value, $currencies->currencies[$currency_code]['decimal_places']), $currencies->currencies[$currency_code]['decimal_places'], '.', '');
    }

    function isEnabled() {
      return $this->enabled;
    }

    function check() {
      return defined('MODULE_CHECKOUT_SUCCESS_COMMISSION_JUNCTION_STATUS');
    }

    function install() {
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Enable Commision Junction Module', 'MODULE_CHECKOUT_SUCCESS_COMMISSION_JUNCTION_STATUS', 'True', 'Do you want to add Commision Junctionaffiliate program pixel to your shop?', '6', '1', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
	  
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('CJ Enterprise ID', 'MODULE_CHECKOUT_SUCCESS_COMMISSION_JUNCTION_ID', '', 'CID', '6', '2', now())");
	  
	  tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('CJ Action ID', 'MODULE_CHECKOUT_SUCCESS_COMMISSION_JUNCTION_ACTION_ID', '', 'TYPE', '6', '3', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Item Based integration', 'MODULE_CHECKOUT_SUCCESS_COMMISSION_JUNCTION_IB_TRACKING', 'True', 'Are you using Item Based integration?', '6', '4', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
	  
	   tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Payment Method Exclusion', 'MODULE_CHECKOUT_SUCCESS_COMMISSION_JUNCTION_EXCLUSION', 'Check/Money Order', 'Name exactly as displayed on checkout payment screen', '6', '5', now())");
     
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'MODULE_CHECKOUT_SUCCESS_COMMISSION_JUNCTION_SORT_ORDER', '0', 'Sort order of display. Lowest is displayed first.', '6', '6', now())");
    }

    function remove() {
      tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('MODULE_CHECKOUT_SUCCESS_COMMISSION_JUNCTION_STATUS', 'MODULE_CHECKOUT_SUCCESS_COMMISSION_JUNCTION_ID','MODULE_CHECKOUT_SUCCESS_COMMISSION_JUNCTION_ACTION_ID', 'MODULE_CHECKOUT_SUCCESS_COMMISSION_JUNCTION_IB_TRACKING', 'MODULE_CHECKOUT_SUCCESS_COMMISSION_JUNCTION_EXCLUSION', 'MODULE_CHECKOUT_SUCCESS_COMMISSION_JUNCTION_SORT_ORDER');
    }
  }