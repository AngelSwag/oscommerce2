<div class="shoppingcart">
    <div class="fadelink">
            <span class="pull-right">
                <a class="btn btn_basket"><i class="icon-basket-1 icon-large"></i></a>
            </span>



               <?php if ($cart->count_contents() > 0) {
                    echo '<div class="shopping_cart_mini full_cart hidden-phone hidden-tablet"><div class="inner-wrapper">'.SOME_ITEMS_IN_CART;
                    $products = array_reverse($cart->get_products());
                     if (sizeof($products) > 3) {
                         $count = 3;
                     } else {
                         $count = sizeof($products);
                     }
                    for ($i=0, $n=$count; $i<$n; $i++) {
                        $cart_contents_string .= '
                        <div class="item">
                            <a href="'.tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $products[$i]['id']).'" class="product-image">
                                '.tep_image(DIR_WS_IMAGES . $products[$i]['image'], $products[$i]['name']).'
                            </a>
                            <div class="product-detailes">';
                                $cart_contents_string .= '
                                <a class="product-name" href="'.tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $products[$i]['id']).'">';

                                //if ((tep_session_is_registered('new_products_id_in_cart')) && ($new_products_id_in_cart == $products[$i]['id'])) {
                                    //$cart_contents_string .= '<span class="newItemInCart">';
                                //}

                                $cart_contents_string .= $products[$i]['quantity'].'&nbsp;x&nbsp;'.$products[$i]['name'];
                                //if ((tep_session_is_registered('new_products_id_in_cart')) && ($new_products_id_in_cart == $products[$i]['id'])) {
                                    //$cart_contents_string .= '</span>';
                                //}
                                $cart_contents_string .= '</a>';

                                $cart_contents_string .= '
                            </div>
                            <div class="alignright">
                                <a href="'.tep_href_link(FILENAME_PRODUCT_INFO, 'products_id='.$products[$i]['id']).'"><i class="icon-edit-1"></i></a>
                                <a href="'.tep_href_link(FILENAME_SHOPPING_CART, 'products_id='.$products[$i]['id'].'&action=remove_product').'"><i class="icon-trash-3"></i></a>
                            </div>
                        </div>';

                        //if ((tep_session_is_registered('new_products_id_in_cart')) && ($new_products_id_in_cart == $products[$i]['id'])) {
                        $cart_contents_string .= '<div class="product-price alignright">'.TEXT_CART_SUBTOTAL.$currencies->format($cart->show_total()).'</div>';
                        //}


                        if ((tep_session_is_registered('new_products_id_in_cart')) && ($new_products_id_in_cart == $products[$i]['id'])) {
                            tep_session_unregister('new_products_id_in_cart');
                        }
                    }
                        $cart_contents_string .=
                        '<div class="wrapper">
                                <a class="button" title="'.VIEW_CART.'" href="'.tep_href_link(FILENAME_SHOPPING_CART, '', 'SSL').'">'.VIEW_CART.'</a>
                                <a class="button" title="'.CHECKOUT_MEGASTORE.'" href="'.tep_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL').'">'.CHECKOUT_MEGASTORE.'</a>
                       </div>';

                        echo $cart_contents_string;
                ?>

                <!--  full cart -->


                </div>
                    </div>

                <!--  full cart -->

                <?php } else {
                    echo '<div class="shopping_cart_mini hidden-phone hidden-tablet empty_cart"><div class="inner-wrapper">'.ET_HEADER_NOW_IN_CART.'</div></div>';
                 }
                ?>




    </div>
</div>