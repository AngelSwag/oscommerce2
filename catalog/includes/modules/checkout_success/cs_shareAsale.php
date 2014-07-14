<?php
/*
  $Id$ cs_shareAsale
  2013 G.L. Walker - http://wsfive.com
  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com
  Copyright (c) 2010 osCommerce
  Released under the GNU General Public License
*/
  class cs_shareAsale {
    var $code = 'cs_shareAsale';
    var $group = 'checkout_success';
    var $title;
    var $description;
    var $sort_order;
    var $enabled = false;

    function cs_shareAsale() {
      $this->title = MODULE_CHECKOUT_SUCCESS_SHARE_A_SALE_TITLE;
      $this->description = MODULE_CHECKOUT_SUCCESS_SHARE_A_SALE_DESCRIPTION;

      if ( defined('MODULE_CHECKOUT_SUCCESS_SHARE_A_SALE_STATUS') ) {
        $this->sort_order = MODULE_CHECKOUT_SUCCESS_SHARE_A_SALE_SORT_ORDER;
        $this->enabled = (MODULE_CHECKOUT_SUCCESS_SHARE_A_SALE_STATUS == 'True');
      }
    }

    function execute() {
      global $oscTemplate, $customer_id, $sspixel, $affiliate_ref, $sas_discount, $sas_math, $sas_order, $sas_order_id, $sas_push, $sas_subtotal, $sas_subtotal_round, $sas_total, $sas_value; 

        if ( (!isset($affiliate_ref)) && tep_session_is_registered('customer_id') ) {								
          $sas_order_query = tep_db_query("select orders_id, payment_method, currency from " . TABLE_ORDERS . " where customers_id = '" . (int)$customer_id . "' order by date_purchased desc limit 1");

            $sas_order = tep_db_fetch_array($sas_order_query);
			$sas_order_id = (int)$sas_order['orders_id'];

		   $sas_subtotal_query = tep_db_query("select value from orders_total where orders_id = '". $sas_order_id ."' and class = 'ot_subtotal'");
			$sas_subtotal = tep_db_fetch_array($sas_subtotal_query);
			
			$sas_subtotal_round = tep_round($sas_subtotal['value'], 2);
			$sas_discount_query = tep_db_query("select * from " . TABLE_ORDERS_TOTAL . " where orders_id = '". $sas_order_id ."'");
			$sas_discount = 0;
			
			while ($sas_total = tep_db_fetch_array($sas_discount_query)) {
				if ($sas_total['class'] == "ot_discount_coupon")  {
					$sas_discount = tep_round($sas_total['value'], 2);
					$sas_math = $sas_subtotal_round += $sas_discount;
				} 
				if ($sas_total['class'] == "ot_coupon")  {
					$sas_discount = tep_round($sas_total['value'], 2);
					$sas_math = $sas_subtotal_round - $sas_discount;
				}         
			}
			
			
			if ($sas_discount) {
				$sas_push = $sas_math;
			} else {
				$sas_push =  $sas_subtotal_round;
			}
			
			$sas_value = $sas_push;
			
	////////// now set the pixel				
			 
			$sspixel .= '<img src="https://shareasale.com/sale.cfm?amount='. $sas_value .'&tracking='. $sas_order_id .'&transtype=sale&merchantID='. MODULE_CHECKOUT_SUCCESS_SHARE_A_SALE_MERCHANT_ID .'" height="1" width="1">' . PHP_EOL;	
			
		}
		
		if ($sas_order['payment_method'] != MODULE_CHECKOUT_SUCCESS_SHARE_A_SALE_EXCLUSION) {
		


			$cs_data  = '	<!-- Begin ShareASale -->' . PHP_EOL;
			$cs_data .= 		$sspixel . PHP_EOL;
			$cs_data .= '	<!-- End ShareASale -->' . PHP_EOL;
		}
        $oscTemplate->addBlock($cs_data, $this->group);
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
      return defined('MODULE_CHECKOUT_SUCCESS_SHARE_A_SALE_STATUS');
    }

    function install() {
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Enable ShareASale module', 'MODULE_CHECKOUT_SUCCESS_SHARE_A_SALE_STATUS', 'True', 'Do you want to add ShareASale affiliate program pixel to your shop?', '6', '1', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
	  
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('ShareASale Merchant ID', 'MODULE_CHECKOUT_SUCCESS_SHARE_A_SALE_MERCHANT_ID', 'XXXX', 'merchantID', '6', '2', now())");
	  
	  
	   tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Payment Method Exclusion', 'MODULE_CHECKOUT_SUCCESS_SHARE_A_SALE_EXCLUSION', 'Check/Money Order', 'Name exactly as displayed on checkout payment screen', '6', '5', now())");
     
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'MODULE_CHECKOUT_SUCCESS_SHARE_A_SALE_SORT_ORDER', '0', 'Sort order of display. Lowest is displayed first.', '6', '7', now())");
    }

    function remove() {
      tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('MODULE_CHECKOUT_SUCCESS_SHARE_A_SALE_STATUS', 'MODULE_CHECKOUT_SUCCESS_SHARE_A_SALE_MERCHANT_ID', 'MODULE_CHECKOUT_SUCCESS_SHARE_A_SALE_EXCLUSION', 'MODULE_CHECKOUT_SUCCESS_SHARE_A_SALE_SORT_ORDER');
    }
  }