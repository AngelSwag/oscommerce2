<?php
/*
  $Id$ cs_gift_voucher.php
  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com
  Copyright (c) 2014 osCommerce
  Released under the GNU General Public License
*/

  class cs_gift_voucher {
    var $code = 'cs_gift_voucher';
    var $group = 'checkout_success';
    var $title;
    var $description;
    var $sort_order;
    var $enabled = false;

    function cs_gift_voucher() {
      $this->title = MODULE_CHECKOUT_SUCCESS_GIFT_VOUCHER_TITLE;
      $this->description = MODULE_CHECKOUT_SUCCESS_GIFT_VOUCHER_DESCRIPTION;

	  if (defined('MODULE_CHECKOUT_SUCCESS_GIFT_VOUCHER_STATUS')) {
        $this->sort_order = MODULE_CHECKOUT_SUCCESS_GIFT_VOUCHER_SORT_ORDER;
        $this->enabled = (MODULE_CHECKOUT_SUCCESS_GIFT_VOUCHER_STATUS == 'True');
      }
	}
	 
    function execute() {
      global $oscTemplate, $customer_id;
	    
  		if (tep_session_is_registered('customer_id')) {	
			$gv_query=tep_db_query("select amount from " . TABLE_COUPON_GV_CUSTOMER . " where customer_id='".$customer_id."'");
			if ($gv_result=tep_db_fetch_array($gv_query)) {
				if ($gv_result['amount'] > 0) {
				
					$cs_data = '<div id="cs-gift-voucher" class="ui-widget infoBoxContainer">' .
							   '  <div class="ui-widget-header infoBoxHeading">' . MODULE_CHECKOUT_SUCCESS_GIFT_VOUCHER_TITLE . '</div>' .
							   '  <div class="ui-widget-content infoBoxContents">' . GV_HAS_VOUCHERA.tep_href_link(FILENAME_GV_SEND).GV_HAS_VOUCHERB .'</div>' .
								'</div>';
					$oscTemplate->addBlock($cs_data, $this->group);
				}
			}
		}
  }

    function isEnabled() {
      return $this->enabled;
    }

    function check() {
      return defined('MODULE_CHECKOUT_SUCCESS_GIFT_VOUCHER_STATUS');
    }

    function install() {
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Enable Gift Voucher Module', 'MODULE_CHECKOUT_SUCCESS_GIFT_VOUCHER_STATUS', 'True', 'Do you want to add the module to your shop?', '6', '1', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");

      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'MODULE_CHECKOUT_SUCCESS_GIFT_VOUCHER_SORT_ORDER', '0', 'Sort order of display. Lowest is displayed first.', '6', '2', now())");
    }

    function remove() {
      tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('MODULE_CHECKOUT_SUCCESS_GIFT_VOUCHER_STATUS', 'MODULE_CHECKOUT_SUCCESS_GIFT_VOUCHER_SORT_ORDER');
    }
  }