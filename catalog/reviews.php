<?php

/*

  $Id$



  osCommerce, Open Source E-Commerce Solutions

  http://www.oscommerce.com



  Copyright (c) 2010 osCommerce



  Released under the GNU General Public License

*/

  require('includes/application_top.php');
  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_REVIEWS);

  $breadcrumb->add(NAVBAR_TITLE, tep_href_link(FILENAME_REVIEWS));
  require(DIR_WS_INCLUDES . 'template_top.php');
?>

<h1><?php echo HEADING_TITLE; ?></h1>

<div class="contentContainer">
    <div class="contentText product-shop">
        <table class="table_style">
            <tr>
                <td>
<?php
  $reviews_query_raw = "select r.reviews_id, left(rd.reviews_text, 1100) as reviews_text, r.reviews_rating, r.date_added, p.products_id, pd.products_name, p.products_image, r.customers_name from " . TABLE_REVIEWS . " r, " . TABLE_REVIEWS_DESCRIPTION . " rd, " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_status = '1' and p.products_id = r.products_id and r.reviews_id = rd.reviews_id and p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "' and rd.languages_id = '" . (int)$languages_id . "' and reviews_status = 1 order by r.reviews_id DESC";
  $reviews_split = new splitPageResults($reviews_query_raw, MAX_DISPLAY_NEW_REVIEWS);

  if ($reviews_split->number_of_rows > 0) {
    if ((PREV_NEXT_BAR_LOCATION == '1') || (PREV_NEXT_BAR_LOCATION == '3')) {
?>

  <div class="contentText">
    <p class="f_right"><?php echo TEXT_RESULT_PAGE . ' ' . $reviews_split->display_links(MAX_DISPLAY_PAGE_LINKS, tep_get_all_get_params(array('page', 'info'))); ?></p>
    <p><?php echo $reviews_split->display_count(TEXT_DISPLAY_NUMBER_OF_REVIEWS); ?></p>
  </div>

  <br />



<?php
    }
?>


<?php
    $reviews_query = tep_db_query($reviews_split->sql_query);
    while ($reviews = tep_db_fetch_array($reviews_query)) {
?>


              <div class="clearfix reviews_wrapper">
                  <div class="product_img_wrapper">
                    <?php echo '<a href="'.tep_href_link(FILENAME_PRODUCT_REVIEWS_INFO, 'products_id=' . $reviews['products_id'] . '&reviews_id=' . $reviews['reviews_id']) . '">' . tep_image(DIR_WS_IMAGES . $reviews['products_image'], $reviews['products_name'], '', '', 'class="scale-with-grid-resize"') . '</a>'; ?>
                  </div>
                  <div class="product_info_wrapper">
                      <div>
                          <span><?php echo sprintf(TEXT_REVIEW_DATE_ADDED, tep_date_long($reviews['date_added'])); ?></span>
                          <div class="reviews_author">
                              <?php echo '<a href="' . tep_href_link(FILENAME_PRODUCT_REVIEWS_INFO, 'products_id=' . $reviews['products_id'] . '&reviews_id=' . $reviews['reviews_id']) . '">' . $reviews['products_name'] . '</a>
                              <span class="smallText">' . sprintf(TEXT_REVIEW_BY, tep_output_string_protected($reviews['customers_name'])) . '</span>'; ?>
                          </div>
                      </div>

                      <?php echo trimmed_text($reviews['reviews_text'], 100) . '
                    <div class="rating_line"><i>' . sprintf(TEXT_REVIEW_RATING, rating_output($reviews['products_id']), sprintf(TEXT_OF_5_STARS, $reviews['reviews_rating'])) . '</i></div>
                  </div>
              </div>';
        ?>

<?php
    }
  } else {
?>



    <?php echo TEXT_NO_REVIEWS; ?>



<?php
  }

  if (($reviews_split->number_of_rows > 0) && ((PREV_NEXT_BAR_LOCATION == '2') || (PREV_NEXT_BAR_LOCATION == '3'))) {
?>
  <br />

  <div class="contentText">
    <p style="float: right;"><?php echo TEXT_RESULT_PAGE . ' ' . $reviews_split->display_links(MAX_DISPLAY_PAGE_LINKS, tep_get_all_get_params(array('page', 'info'))); ?></p>
    <p><?php echo $reviews_split->display_count(TEXT_DISPLAY_NUMBER_OF_REVIEWS); ?></p>
  </div>

<?php
  }
?>

</td>
</tr>
</table>

</div>


</div>



<?php
  require(DIR_WS_INCLUDES . 'template_bottom.php');
  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>

