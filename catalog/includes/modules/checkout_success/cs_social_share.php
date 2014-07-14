<?php
/*
  $Id$ cs_social_share
  2013 G.L. Walker - http://wsfive.com
  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com
  Copyright (c) 2010 osCommerce
  Released under the GNU General Public License
*/

  class cs_social_share {
    var $code = 'cs_social_share';
    var $group = 'checkout_success';
    var $title;
    var $description;
    var $sort_order;
    var $enabled = false;

    function cs_social_share() {
      $this->title = MODULE_CHECKOUT_SUCCESS_SOCIAL_SHARE_TITLE;
      $this->description = MODULE_CHECKOUT_SUCCESS_SOCIAL_SHARE_DESCRIPTION;

	  if (defined('MODULE_CHECKOUT_SUCCESS_SOCIAL_SHARE_STATUS')) {
        $this->sort_order = MODULE_CHECKOUT_SUCCESS_SOCIAL_SHARE_SORT_ORDER;
        $this->enabled = (MODULE_CHECKOUT_SUCCESS_SOCIAL_SHARE_STATUS == 'True');
      }
	}
	 
    function execute() {
      global $oscTemplate, $customer_id, $currencies;
	  
	  $header = '<script>(function() {var po = document.createElement(\'script\'); po.type = \'text/javascript\'; po.async = true; po.src = \'https://apis.google.com/js/plusone.js\'; var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(po, s); })();</script>' . PHP_EOL;
	  
	  $header .= '<div id="fb-root"></div>' . PHP_EOL;
	  $header .= '<script>(function(d, s, id) { var js, fjs = d.getElementsByTagName(s)[0]; if (d.getElementById(id)) return; js = d.createElement(s); js.id = id; js.src = "//connect.facebook.net/en_US/all.js#xfbml=1"; fjs.parentNode.insertBefore(js, fjs); }(document, \'script\', \'facebook-jssdk\'));</script>' . PHP_EOL;
					
	  $header .= '<script src="//assets.pinterest.com/js/pinit.js"></script>' . PHP_EOL; 
				   
	  $header .= '<script>!function(d,s,id){ var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>' . PHP_EOL;
				   
	  $header .= '' . PHP_EOL;
	  
	  $header .= '<style>' .
	  			 ' #cs-prod-share .infoBoxContainer { float:left; margin:1%; width:48%; } ' .
				 ' #cs-prod-share .infoBoxContainer img { float:right; margin:8%; } ' . 
				 ' #cs-prod-share .infoBoxContainer a { float:left;  } ' .
	  			 '</style>' . PHP_EOL;
					
	  $oscTemplate->addBlock($header, 'header_tags');
	   
      if (tep_session_is_registered('customer_id')) {
        $orders_query = tep_db_query("select orders_id from " . TABLE_ORDERS . " where customers_id = '" . (int)$customer_id . "' order by date_purchased desc limit 1");
        $orders = tep_db_fetch_array($orders_query);

        $products_array = array();
        $products_query = tep_db_query("select op.products_id, op.products_name, op.final_price, p.products_image from " . TABLE_ORDERS_PRODUCTS . " op, " . TABLE_PRODUCTS . " p where orders_id = '" . (int)$orders['orders_id'] . "' and op.products_id = p.products_id order by products_name");
        while ($products = tep_db_fetch_array($products_query)) {
    	  $products_array[] = array('id' => $products['products_id'],
                                    'text' => $products['products_name'],
								    'image' => $products['products_image'],
									'price' => $products['final_price']);						
        }
	    
		$share_block = '' . PHP_EOL;
		
		$products_displayed = array();			
		  for ($i=0, $n=sizeof($products_array); $i<$n; $i++) {
           if (!in_array($products_array[$i]['id'], $products_displayed)) {  
			 
			 $share_block .= '<div class="ui-widget infoBoxContainer">' . PHP_EOL;
			 $share_block .= '  <div class="ui-widget-header infoBoxHeading">' . $products_array[$i]['text'] . '</div>' . PHP_EOL;
			 
			 $share_block .= '  <div class="ui-widget-content infoBoxContents">' . PHP_EOL;
			 
			 $share_block .=        tep_image(DIR_WS_IMAGES . $products_array[$i]['image'], $products_array[$i]['text'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . PHP_EOL;
			  
			  $share_block .= $currency_value;

			 /* pinterest */
			 $share_block .= '    <a href="https://pinterest.com/pin/create/button/?url='. tep_href_link(FILENAME_PRODUCT_INFO, '&products_id='.$products_array[$i]['id'] ).'&media='. HTTP_SERVER . DIR_WS_HTTP_CATALOG . DIR_WS_IMAGES . $products_array[$i]['image'] .'&description='. $currencies->format($this->format_raw($products_array[$i]['price']) ). ' ' . MODULE_CHECKOUT_SUCCESS_SOCIAL_SHARE_MESSAGE . ' ' . $products_array[$i]['text'] . ' '. MODULE_CHECKOUT_SUCCESS_SOCIAL_SHARE_FROM . '&nbsp;' . STORE_NAME.'" class="pin-it-button" count-layout="none"><img src="//assets.pinterest.com/images/PinExt.png" title="Pin It" /></a>' . PHP_EOL;
			      
			 $share_block .= '      <br><br>' . PHP_EOL;
			 
/* face book */
			  $share_block .= '      <fb:like href="'. tep_href_link(FILENAME_PRODUCT_INFO, '&products_id='.$products_array[$i]['id']).'" layout="button_count" show_faces="false" width="90" font="arial" data-action="recommend"></fb:like>' . PHP_EOL;

             $share_block .= '      <br><br>' . PHP_EOL;
			 
		     /* twiiter */
			 $share_block .= '      <a class="twitter-share-button" href="https://twitter.com/share" data-url="'. tep_href_link(FILENAME_PRODUCT_INFO, '&products_id='.$products_array[$i]['id']).'" data-text="' . MODULE_CHECKOUT_SUCCESS_SOCIAL_SHARE_MESSAGE . ' ' . $products_array[$i]['text'] . ' '. MODULE_CHECKOUT_SUCCESS_SOCIAL_SHARE_FROM . ' ' . STORE_NAME .'" data-size="medium" data-count="none">Tweet</a>' .PHP_EOL;
			 
			 $share_block .= '      <br><br>' . PHP_EOL;
		     /* google plus */
			 $share_block .= '      <g:plusone size="medium" annotation="none" href="'. tep_href_link(FILENAME_PRODUCT_INFO, '&products_id='.$products_array[$i]['id']).'"></g:plusone>' . PHP_EOL;
		     
			  $share_block .= '      <br><br>' . PHP_EOL;
			  
			   /* Buffer does not currently support SSL - oh well, maybe later */
			//  $share_block .= '      <a href="http://bufferapp.com/add" class="buffer-add-button" data-text="' . MODULE_CHECKOUT_SUCCESS_SOCIAL_SHARE_MESSAGE . ' ' . $products_array[$i]['text'] . ' '. MODULE_CHECKOUT_SUCCESS_SOCIAL_SHARE_FROM . ' ' . STORE_NAME .'" data-url="'. tep_href_link(FILENAME_PRODUCT_INFO, '&products_id='.$products_array[$i]['id']).'" data-count="none"  data-picture="'. HTTP_SERVER . DIR_WS_HTTP_CATALOG . DIR_WS_IMAGES . $products_array[$i]['image'] .'">Buffer</a>' . PHP_EOL;
			  			 	
			  			
			  $share_block .= '    </div>' . PHP_EOL;
			  $share_block .= '  </div>' . PHP_EOL;
		     
			 }
		   }
		   
      $cs_data = '<div id="cs-prod-share">' . 
	             '  <h2>' . MODULE_CHECKOUT_SUCCESS_SOCIAL_SHARE_HEADING . '</h2>'  . 
                 '  <p>' . MODULE_CHECKOUT_SUCCESS_SOCIAL_SHARE_TEXT . '</p>' .
                    $share_block . 
				 '<div style="clear:both;"></div>' .
				 /* Buffer must be loaded after button, but does not currently support SSL - oh well, maybe later */
				 '<script type="text/javascript" src="http://static.bufferapp.com/js/button.js"></script>'.
                 '</div>' . PHP_EOL;
				  
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
      return defined('MODULE_CHECKOUT_SUCCESS_SOCIAL_SHARE_STATUS');
    }

    function install() {
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Enable Social Share Module', 'MODULE_CHECKOUT_SUCCESS_SOCIAL_SHARE_STATUS', 'True', 'Do you want to add the module to your shop?', '6', '1', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
	  

      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'MODULE_CHECKOUT_SUCCESS_SOCIAL_SHARE_SORT_ORDER', '0', 'Sort order of display. Lowest is displayed first.', '6', '2', now())");
    }

    function remove() {
      tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('MODULE_CHECKOUT_SUCCESS_SOCIAL_SHARE_STATUS', 'MODULE_CHECKOUT_SUCCESS_SOCIAL_SHARE_SORT_ORDER');
    }
  }