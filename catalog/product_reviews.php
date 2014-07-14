<?php

/*

  $Id$



  osCommerce, Open Source E-Commerce Solutions

  http://www.oscommerce.com



  Copyright (c) 2012 osCommerce



  Released under the GNU General Public License

*/



  require('includes/application_top.php');

  if (!isset($HTTP_GET_VARS['products_id'])) {
    tep_redirect(tep_href_link(FILENAME_REVIEWS));
  }

  $product_info_query = tep_db_query("select p.products_id, p.products_model, p.products_image, p.products_price, p.products_tax_class_id, pd.products_name from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_id = '" . (int)$HTTP_GET_VARS['products_id'] . "' and p.products_status = '1' and p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "'");
  if (!tep_db_num_rows($product_info_query)) {
    tep_redirect(tep_href_link(FILENAME_REVIEWS));
  } else {
    $product_info = tep_db_fetch_array($product_info_query);
  }

require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_PRODUCT_REVIEWS);
require(DIR_WS_INCLUDES . 'template_top.php');



if ($new_price = tep_get_products_special_price($product_info['products_id'])) {
    $products_price =
        '<span class="old-price"><span class="price">' . $currencies->display_price($product_info['products_price'], tep_get_tax_rate($product_info['products_tax_class_id'])) . '</span></span>
      <span class="special-price"><span class="price">' . $currencies->display_price($new_price, tep_get_tax_rate($product_info['products_tax_class_id'])) . '</span></span>';
} else {
    $products_price = '<span class="regular_price">'.$currencies->display_price($product_info['products_price'], tep_get_tax_rate($product_info['products_tax_class_id'])). '</span>';
}


if (tep_not_null($product_info['products_model'])) {
    $products_name = $product_info['products_name'] . '<br /><span class="smallText">[' . $product_info['products_model'] . ']</span>';
  } else {
    $products_name = $product_info['products_name'];
  }

  $breadcrumb->add(NAVBAR_TITLE, tep_href_link(FILENAME_PRODUCT_REVIEWS, tep_get_all_get_params()));




?>



<?php

  if ($messageStack->size('product_reviews') > 0) {

    echo $messageStack->output('product_reviews');

  }

?>

<div class="product-shop product_reviews_page">

<div class="contentContainer">



<?php
  if (tep_not_null($product_info['products_image'])) {
?>

  <div class="span2 product_img_wrapper">
        <?php echo '<a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $product_info['products_id']) . '">' . tep_image(DIR_WS_IMAGES . $product_info['products_image'], addslashes($product_info['products_name']), '', '', 'class="scale-with-grid"') . '</a>'; ?>
  </div>



<?php
  }

  $reviews_query_raw = "select r.reviews_id, left(rd.reviews_text, 1100) as reviews_text, r.reviews_rating, r.date_added, r.customers_name from " . TABLE_REVIEWS . " r, " . TABLE_REVIEWS_DESCRIPTION . " rd where r.products_id = '" . (int)$product_info['products_id'] . "' and r.reviews_id = rd.reviews_id and rd.languages_id = '" . (int)$languages_id . "' and r.reviews_status = 1 order by r.reviews_id desc";

  $reviews_split = new splitPageResults($reviews_query_raw, MAX_DISPLAY_NEW_REVIEWS);



  if ($reviews_split->number_of_rows > 0) {
    if ((PREV_NEXT_BAR_LOCATION == '1') || (PREV_NEXT_BAR_LOCATION == '3')) {
?>



  <div class="clearfix contentText">
      <p class="f_left"><?php echo $reviews_split->display_count(TEXT_DISPLAY_NUMBER_OF_REVIEWS); ?>
      <p class="f_right">
        <?php echo TEXT_RESULT_PAGE . ' ' . $reviews_split->display_links(MAX_DISPLAY_PAGE_LINKS, tep_get_all_get_params(array('page', 'info'))); ?>
      </p>
    </p>
  </div>

<?php
    }

      $reviews_query = tep_db_query($reviews_split->sql_query);
?>
 <div class="span6 product_info_wrapper">

      <div class="prod_info_name_price">
          <div class="prod_info_name"><h1><?php echo $products_name; ?></h1></div>
          <div class="price-box"><?php echo $products_price; ?></div>
      </div>

<?php
    while ($reviews = tep_db_fetch_array($reviews_query)) {

?>


      <div class="product_reviews_date"><?php echo sprintf(TEXT_REVIEW_DATE_ADDED, tep_date_long($reviews['date_added'])); ?></div>
      <h2 class="review_author"><?php echo '<a href="' . tep_href_link(FILENAME_PRODUCT_REVIEWS_INFO, 'products_id=' . $product_info['products_id'] . '&reviews_id=' . $reviews['reviews_id']) . '">' . sprintf(TEXT_REVIEW_BY, tep_output_string_protected($reviews['customers_name'])) . '</a>'; ?></h2>

      <?php echo trimmed_text($reviews['reviews_text'], 200) . '



    <br /><br />
                            <div class="rating_line"><i>' . sprintf(TEXT_REVIEW_RATING, rating_output($product_info['products_id']), sprintf(TEXT_OF_5_STARS, $reviews['reviews_rating'])) . '</i></div>

    '; ?>



<?php
    }
?>
      <?php
        if (($reviews_split->number_of_rows > 0) && ((PREV_NEXT_BAR_LOCATION == '2') || (PREV_NEXT_BAR_LOCATION == '3'))) {
      ?>

          <div class="clearfix product_reviews_pager">
              <p class="f_left">
                  <?php echo $reviews_split->display_count(TEXT_DISPLAY_NUMBER_OF_REVIEWS); ?>
              </p>
              <p class="f_right">
                  <?php echo TEXT_RESULT_PAGE . ' ' . $reviews_split->display_links(MAX_DISPLAY_PAGE_LINKS, tep_get_all_get_params(array('page', 'info'))); ?>
              </p>
          </div>






      <?php
        }
      ?>

<?php
  } else {
?>



  <div class="contentText span6 product_info_wrapper">
       <div class="prod_info_name_price">
           <div class="prod_info_name"><h1><?php echo $products_name; ?></h1></div>
           <div class="prod_info_price"><?php echo $products_price; ?></div>
       </div>
      <?php echo TEXT_NO_REVIEWS; ?>


<?php
  }
?>

    <div class="buttonSet">
        <div class="clearfix">
            <?php echo tep_draw_button(IMAGE_BUTTON_BACK, 'triangle-1-w', tep_href_link(FILENAME_PRODUCT_INFO, tep_get_all_get_params())); ?>
            <?php echo tep_draw_button(IMAGE_BUTTON_WRITE_REVIEW, 'comment', tep_href_link(FILENAME_PRODUCT_REVIEWS_WRITE, tep_get_all_get_params()), 'primary'); ?>
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

