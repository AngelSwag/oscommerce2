<?php

/* constants    */
define (DC_FOLDER, 'megastore_theme/');
define (DC_STYLES, DC_FOLDER . 'megastore_styles/');
define (DC_SCRIPTS, DC_FOLDER . 'megastore_js/');
define (DC_BLOCKS, DC_FOLDER . 'megastore_blocks/');
define (DC_IMAGES, DC_FOLDER . 'megastore_images/');

if ( file_exists(DIR_WS_LANGUAGES . $language . '/megastore_constants.php') ) {
    include(DIR_WS_LANGUAGES . $language . '/megastore_constants.php');
}


$megastore_grids = 3;
/* constants */

    $main_page_url = false;
    if (basename($PHP_SELF) == FILENAME_DEFAULT && !isset($HTTP_GET_VARS['cPath']) && !isset($HTTP_GET_VARS['manufacturers_id'])) {
        $main_page_url = true;
    }
    $product_page_url = false;
    if (basename($PHP_SELF) == FILENAME_PRODUCT_INFO){
        $product_page_url = true;
    }

/* header links  */
if (tep_session_is_registered('customer_id')) {
    $login_url = tep_href_link(FILENAME_LOGOFF, '', 'SSL');
    $login_text = MENU_TEXT_LOGOUT;

    $create_account_url = tep_href_link(FILENAME_ACCOUNT, '', 'SSL');
    $create_account_text = MENU_TEXT_MEMBERS;



} else {
    $login_url = tep_href_link(FILENAME_LOGIN, '', 'SSL');
    $login_text = MENU_TEXT_LOGIN;

    $create_account_url = tep_href_link(FILENAME_CREATE_ACCOUNT, '', 'SSL');
    $create_account_text = TEXT_REGISTER;

}



/* functions for texts */


function et_short_text($text, $limit='10') {
	$str = strlen($text) > $limit ? substr(strip_tags($text), 0, $limit) . '&hellip;' : strip_tags($text);
	return $str;
}

function trimmed_text($text, $limit='20') {
	mb_internal_encoding("UTF-8");
	$str = strlen($text) > $limit ? mb_substr(strip_tags($text), 0, $limit) . '&hellip;' : strip_tags($text);
	return $str;
}

function rating_output($products_id) {
    $rating = '';
    $review_query = tep_db_query(
        "SELECT
            ROUND(SUM(`reviews_rating`)/COUNT(`reviews_id`)) as rating
         FROM
            " . TABLE_REVIEWS . "
         WHERE
            products_id = '" . (int)$products_id . "'
            AND `reviews_status` = 1");
    $review = tep_db_fetch_array($review_query);

    if ( !empty($review['rating']) ) {

             $rating .= '<strong>';
             for ($i = 1; $i <= $review['rating']; $i ++) {
                 $rating .= '<i class="icon-star"></i>';
             }
             $rating .= '</strong>';

            $k =  5 - $review['rating'];
            for ($j = 1; $j <= $k; $j ++) {
                $rating .= '<i class="icon-star"></i>';
            }
    } else {
        $rating = '
                <i class="icon-star"></i>
                <i class="icon-star"></i>
                <i class="icon-star"></i>
                <i class="icon-star"></i>
                <i class="icon-star"></i>
            ';
    }
    return '<div class="rating">'.$rating.'</div><meta itemprop="rating" content="'.$review['rating'].'" />' ;
}



