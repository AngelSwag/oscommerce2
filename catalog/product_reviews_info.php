<?php

/*

  $Id$



  osCommerce, Open Source E-Commerce Solutions

  http://www.oscommerce.com



  Copyright (c) 2010 osCommerce



  Released under the GNU General Public License

*/



  require('includes/application_top.php');
require(DIR_WS_INCLUDES . 'template_top.php');

require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_PRODUCT_REVIEWS_INFO);



if (isset($HTTP_GET_VARS['reviews_id']) && tep_not_null($HTTP_GET_VARS['reviews_id']) && isset($HTTP_GET_VARS['products_id']) && tep_not_null($HTTP_GET_VARS['products_id'])) {
    $review_check_query = tep_db_query("select count(*) as total from " . TABLE_REVIEWS . " r, " . TABLE_REVIEWS_DESCRIPTION . " rd where r.reviews_id = '" . (int)$HTTP_GET_VARS['reviews_id'] . "' and r.products_id = '" . (int)$HTTP_GET_VARS['products_id'] . "' and r.reviews_id = rd.reviews_id and rd.languages_id = '" . (int)$languages_id . "' and r.reviews_status = 1");
    $review_check = tep_db_fetch_array($review_check_query);



    if ($review_check['total'] < 1) {
      tep_redirect(tep_href_link(FILENAME_PRODUCT_REVIEWS, tep_get_all_get_params(array('reviews_id'))));
    }

  } else {
    tep_redirect(tep_href_link(FILENAME_PRODUCT_REVIEWS, tep_get_all_get_params(array('reviews_id'))));
  }



  tep_db_query("update " . TABLE_REVIEWS . " set reviews_read = reviews_read+1 where reviews_id = '" . (int)$HTTP_GET_VARS['reviews_id'] . "'");



  $review_query = tep_db_query("select rd.reviews_text, r.reviews_rating, r.reviews_id, r.customers_name, r.date_added, r.reviews_read, p.products_id, p.products_price, p.products_tax_class_id, p.products_image, p.products_model, pd.products_name from " . TABLE_REVIEWS . " r, " . TABLE_REVIEWS_DESCRIPTION . " rd, " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where r.reviews_id = '" . (int)$HTTP_GET_VARS['reviews_id'] . "' and r.reviews_id = rd.reviews_id and rd.languages_id = '" . (int)$languages_id . "' and r.products_id = p.products_id and p.products_status = '1' and p.products_id = pd.products_id and pd.language_id = '". (int)$languages_id . "'");

  $review = tep_db_fetch_array($review_query);



  if ($new_price = tep_get_products_special_price($review['products_id'])) {
    $products_price =  '<span class="old-price"><span class="price">' . $currencies->display_price($review['products_price'], tep_get_tax_rate($review['products_tax_class_id'])) . '</span></span>
   <span class="special-price"><span class="price">' . $currencies->display_price($new_price, tep_get_tax_rate($review['products_tax_class_id'])) . '</span></span>';
  } else {
    $products_price = $currencies->display_price($review['products_price'], tep_get_tax_rate($review['products_tax_class_id']));
  }
  $products_price = '<span class="regular_price">'.$products_price.'</span>';



if (tep_not_null($review['products_model'])) {

    $products_name = $review['products_name'] . '<br /><span class="smallText">[' . $review['products_model'] . ']</span>';

  } else {

    $products_name = $review['products_name'];

  }



  $breadcrumb->add(NAVBAR_TITLE, tep_href_link(FILENAME_PRODUCT_REVIEWS, tep_get_all_get_params()));

?>

<div class="product-shop product_reviews_info_page">

<div class="contentContainer">



<?php

  if (tep_not_null($review['products_image'])) {

?>



  <div class="span2 product_img_wrapper">
    <?php echo '<a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $review['products_id']) . '">' . tep_image(DIR_WS_IMAGES . $review['products_image'], addslashes($review['products_name']), '', '', 'class="scale-with-grid"') . '</a>'; ?>
  </div>



<?php

  }

?>



  <div class="span6 product_info_wrapper">

      <div class="prod_info_name_price">
          <div class="prod_info_name"><h1><?php echo $products_name; ?></h1></div>
          <div class="price-box"><?php echo $products_price; ?></div>
      </div>
      <span><?php echo sprintf(TEXT_REVIEW_DATE_ADDED, tep_date_long($review['date_added'])); ?></span>

    <h2 class="review_author"><?php echo sprintf(TEXT_REVIEW_BY, tep_output_string_protected($review['customers_name'])); ?></h2>



    <?php echo tep_break_string(nl2br(tep_output_string_protected($review['reviews_text'])), 1100, '-<br />') . '<br /><br />
    <div class="rating_line"><i>' . sprintf(TEXT_REVIEW_RATING, rating_output($review['products_id']), sprintf(TEXT_OF_5_STARS, $reviews['reviews_rating'])) . '</i></div>

    '; ?>


      <div class="buttonSet">
          <div class="clearfix">
              <?php echo tep_draw_button(IMAGE_BUTTON_BACK, 'triangle-1-w', tep_href_link(FILENAME_PRODUCT_REVIEWS, tep_get_all_get_params(array('reviews_id')))); ?>
              <?php echo tep_draw_button(IMAGE_BUTTON_WRITE_REVIEW, 'comment', tep_href_link(FILENAME_PRODUCT_REVIEWS_WRITE, tep_get_all_get_params(array('reviews_id'))), 'primary'); ?>
              <?php echo tep_draw_button(IMAGE_BUTTON_IN_CART, 'cart', tep_href_link(basename($PHP_SELF), tep_get_all_get_params(array('action')) . 'action=buy_now')); ?>
          </div>
      </div>



  </div>






</div>

</div>

<?php

  require(DIR_WS_INCLUDES . 'template_bottom.php');
  require(DIR_WS_INCLUDES . 'application_bottom.php');

?>

