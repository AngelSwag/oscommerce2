<div class="shoppingcart">
    <div class="fadelink">
            <span class="pull-right">
                <a class="btn btn_basket"><i class="icon-basket-1 icon-large"></i></a>
            </span>

        <div class="shopping_cart_mini">
            <div class="inner-wrapper">


               <?php if ($cart->count_contents() > 0) {
                    echo SOME_ITEMS_IN_CART;
                    $top_cart = array_reverse($cart->get_products());
                    if (sizeof($products) > 3) {
                        $count = 3;
                    } else {
                        $count = sizeof($products);
                    }
                    for ($i=0, $n=$count; $i<$n; $i++) {
                    $topcart_contents_string .= '
                        <div class="item">
                            <a href="'.tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $top_cart[$i]['id']).'" class="product-image">
                                '.tep_image(DIR_WS_IMAGES . $top_cart[$i]['image'], $top_cart[$i]['name']).'
                            </a>
                            <div class="product-detailes">';
                        $topcart_contents_string .= '
                                <a class="product-name" href="'.tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $top_cart[$i]['id']).'">';

                                //if ((tep_session_is_registered('new_products_id_in_cart')) && ($new_products_id_in_cart == $top_cart[$i]['id'])) {
                                    //$topcart_contents_string .= '<span class="newItemInCart">';
                                //}

                        $topcart_contents_string .= $top_cart[$i]['quantity'].'&nbsp;x&nbsp;'.$top_cart[$i]['name'];
                                //if ((tep_session_is_registered('new_products_id_in_cart')) && ($new_products_id_in_cart == $top_cart[$i]['id'])) {
                                    //$topcart_contents_string .= '</span>';
                                //}
                        $topcart_contents_string .= '</a>';

                        $topcart_contents_string .= '
                            </div>
                            <div class="alignright">
                                <a href="'.tep_href_link(FILENAME_PRODUCT_INFO, 'products_id='.$top_cart[$i]['id']).'"><i class="icon-edit-1"></i></a>
                                <a href="'.tep_href_link(FILENAME_SHOPPING_CART, 'products_id='.$top_cart[$i]['id'].'&action=remove_product').'"><i class="icon-trash-3"></i></a>
                            </div>
                        </div>';

                        //if ((tep_session_is_registered('new_products_id_in_cart')) && ($new_products_id_in_cart == $top_cart[$i]['id'])) {
                        $topcart_contents_string .= '<div class="product-price alignright">'.TEXT_CART_SUBTOTAL.$currencies->format($cart->show_total()).'</div>';
                        //}


                        if ((tep_session_is_registered('new_products_id_in_cart')) && ($new_products_id_in_cart == $top_cart[$i]['id'])) {
                            tep_session_unregister('new_products_id_in_cart');
                        }
                    }
                $topcart_contents_string .=
                        '<div class="wrapper">
                                <a class="button" title="'.VIEW_CART.'" href="'.tep_href_link(FILENAME_SHOPPING_CART, '', 'SSL').'">'.VIEW_CART.'</a>
                                <a class="button" title="'.CHECKOUT_MEGASTORE.'" href="'.tep_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL').'">'.CHECKOUT_MEGASTORE.'</a>
                       </div>';

// CCGV
      if (tep_session_is_registered('customer_id')) {
		$gv_query = tep_db_query("select amount from " . TABLE_COUPON_GV_CUSTOMER . " where customer_id = '" . (int)$customer_id . "'");
		$gv_result = tep_db_fetch_array($gv_query);
		if ($gv_result['amount'] > 0 )
			{
			$gv_contents_string = '<div class="ui-widget-content infoBoxContents"><div style="float:left;">' . VOUCHER_BALANCE . '</div><div style="float:right;">' . $currencies->format($gv_result['amount']) . '</div><div style="clear:both;"></div>';
			$gv_contents_string .= '<div style="text-align:center; width:100%; margin:auto;"><a href="'. tep_href_link(FILENAME_GV_SEND) . '">' . BOX_SEND_TO_FRIEND . '</a></div></div>';
			}
      }

      if (tep_session_is_registered('gv_id')) {
		$gv_query = tep_db_query("select coupon_amount from " . TABLE_COUPONS . " where coupon_id = '" . $gv_id . "'");
		$coupon = tep_db_fetch_array($gv_query);
		$gv_contents_string = '<div style="text-align:center; width:100%; margin:auto;">' . VOUCHER_REDEEMED . '</td><td class="smalltext" align="right" valign="bottom">' . $currencies->format($coupon['coupon_amount']) . '</div>';
      }
      if (tep_session_is_registered('cc_id') && $cc_id) {
		$coupon_query = tep_db_query("select * from " . TABLE_COUPONS . " where coupon_id = '" . $cc_id . "'");
		$coupon = tep_db_fetch_array($coupon_query);
		$coupon_desc_query = tep_db_query("select * from " . TABLE_COUPONS_DESCRIPTION . " where coupon_id = '" . $cc_id . "' and language_id = '" . $languages_id . "'");
		$coupon_desc = tep_db_fetch_array($coupon_desc_query);
		$text_coupon_help = sprintf("%s",$coupon_desc['coupon_name']);
		$gv_contents_string = '<div style="text-align:center; width:100%; margin:auto;">' . CART_COUPON . $text_coupon_help . '<br>' . '</div>';
      }  
/* CCGV - END */
                        echo $topcart_contents_string . $gv_contents_string;
                ?>

                <!--  full cart -->




                <!--  full cart -->

                <?php } else {
                    echo ET_HEADER_NOW_IN_CART;
                 }
                ?>



            </div>
        </div>
    </div>
</div>