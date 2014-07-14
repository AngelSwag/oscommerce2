<?php
/* theme general options */
$create_buyshop_theme = tep_db_query ("CREATE TABLE IF NOT EXISTS `buyshop_theme` (
    `color_value` varchar(200) NOT NULL,
    `slider_type` varchar(200) NOT NULL,
    `option_themecolor` varchar(200) NOT NULL,
    `option_textcolor` varchar(200) NOT NULL,
    `option_linkcolor` varchar(200) NOT NULL,
    `option_linkhovercolor` varchar(200) NOT NULL,
    `option_bgcolor` varchar(200) NOT NULL,
    `option_captions_text_color` varchar(200) NOT NULL,
    `option_captions_text_google` varchar(200) NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ");
$theme_query = tep_db_query("SELECT * FROM `buyshop_theme` ");

if (tep_db_num_rows($theme_query) > 0) {
   $theme_options = tep_db_fetch_array($theme_query);

    if ($theme_options["color_value"] !== '') {
        define (BUYSHOP_THEME, $theme_options["color_value"]);
    } else {
        define (BUYSHOP_THEME, 'light');
    }

   if ($theme_options["slider_type"] !== '') {
       define (BUYSHOP_SLIDER, $theme_options["slider_type"]);
   } else {
       define (BUYSHOP_SLIDER, 'layerslider');
   }
    define (BUYSHOP_THEMECOLOR, $theme_options["option_themecolor"]);

    define (BUYSHOP_TEXTCOLOR, $theme_options["option_textcolor"]);
    define (BUYSHOP_LINKCOLOR, $theme_options["option_linkcolor"]);
    define (BUYSHOP_LINKHOVERCOLOR, $theme_options["option_linkhovercolor"]);
    define (BUYSHOP_BGCOLOR, $theme_options["option_bgcolor"]);

    define (BUYSHOP_CAPTIONS_TEXT_COLOR, $theme_options["option_captions_text_color"]);

    if ($theme_options["option_captions_text_google"] !== '') {
        define (BUYSHOP_CAPTIONS_TEXT_GOOGLE, $theme_options["option_captions_text_google"]);
    } else {
        define (BUYSHOP_CAPTIONS_TEXT_GOOGLE, 'Rokkitt');
    }
} else {
   define (BUYSHOP_THEME, 'light');
   define (BUYSHOP_SLIDER, 'layerslider');
   define (BUYSHOP_CAPTIONS_TEXT_GOOGLE, 'Rokkitt');
}


/* theme options */

/* custom blocks */
$create_custom_menu_block = tep_db_query ("CREATE TABLE IF NOT EXISTS `custom_menu_block` (
  `menu_block_id` int(11) NOT NULL,
  `menu_block_content` text NOT NULL,
  PRIMARY KEY (`menu_block_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT= 0 ");

$create_custom_product_block = tep_db_query ("CREATE TABLE IF NOT EXISTS `custom_product_block` (
  `menu_block_id` int(11) NOT NULL,
  `menu_block_content` text NOT NULL,
  PRIMARY KEY (`menu_block_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT= 0 ");
/* end custom blocks */

/* product stickers options */

$stickers_table_create = tep_db_query ("CREATE TABLE IF NOT EXISTS `buyshop_stickers` (
    `sticker_new_status` varchar(200) NOT NULL,
    `sticker_new_position` varchar(200) NOT NULL,
    `sticker_sale_status` varchar(200) NOT NULL,
    `sticker_sale_position` varchar(200) NOT NULL,
    `sticker_options_status` varchar(200) NOT NULL,
    `sticker_options_position` varchar(200) NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ");
$stickers_query = tep_db_query("SELECT * FROM `buyshop_stickers` ");

if (tep_db_num_rows($stickers_query) > 0) {
    $stickers = tep_db_fetch_array($stickers_query);
    /*NEW*/
    if ($stickers["sticker_new_status"] !== 'disable') {
        switch ($stickers["sticker_new_position"]) {
            case 'left_top':
                define (STICKER_NEW, '<span class="product_sticker_new sticker_new sticker_new_top_left"></span>');
                break;
            case 'right_top':
                define (STICKER_NEW, '<span class="product_sticker_new sticker_new sticker_new_top_right"></span>');
                break;
            case 'right_bottom':
                define (STICKER_NEW, '<span class="product_sticker_new sticker_new sticker_new_bottom_right"></span>');
                break;
            case 'left_bottom':
                define (STICKER_NEW, '<span class="product_sticker_new sticker_new sticker_new_bottom_left"></span>');
                break;
        }
    } else {
        define (STICKER_NEW, '');
    }
    /*NEW*/
    /*SALE*/
    if ($stickers["sticker_sale_status"] !== 'disable') {
        switch ($stickers["sticker_sale_position"]) {
            case 'left_top':
                define (STICKER_SALE, '<span class="product_sticker sticker_sale sticker_onsale_top_left"></span>');
                break;
            case 'right_top':
                define (STICKER_SALE, '<span class="product_sticker sticker_sale sticker_onsale_top_right"></span>');
                break;
            case 'right_bottom':
                define (STICKER_SALE, '<span class="product_sticker sticker_sale sticker_onsale_bottom_right"></span>');
                break;
            case 'left_bottom':
                define (STICKER_SALE, '<span class="product_sticker sticker_sale sticker_onsale_bottom_left"></span>');
                break;
        }
    } else {
        define (STICKER_SALE, '');
    }
    /*SALE*/
    /*OPTIONS*/
    if ($stickers["sticker_options_status"] !== 'disable') {
        switch ($stickers["sticker_options_position"]) {
            case 'left_top':
                define (STICKER_OPTION, '<span class="product_sticker sticker_option sticker_option_top_left"></span>');
                break;
            case 'right_top':
                define (STICKER_OPTION, '<span class="product_sticker sticker_option sticker_option_top_right"></span>');
                break;
            case 'right_bottom':
                define (STICKER_OPTION, '<span class="product_sticker sticker_option sticker_option_bottom_right"></span>');
                break;
            case 'left_bottom':
                define (STICKER_OPTION, '<span class="product_sticker sticker_option sticker_option_bottom_left"></span>');
                break;
        }
    } else {
        define (STICKER_OPTION, '');
    }
    /*OPTIONS*/
} else {
    define (STICKER_NEW, '<span class="product_sticker_new sticker_new sticker_new_bottom_right"></span>');
    define (STICKER_SALE, '<span class="product_sticker sticker_sale sticker_onsale_top_left"></span>');
    define (STICKER_OPTION, '<span class="product_sticker sticker_option sticker_option_top_right"></span>');
}

/* layouts options */
$layouts_table_create = tep_db_query ("CREATE TABLE IF NOT EXISTS `buyshop_layouts` (
    `menu_block_status` varchar(200) NOT NULL,
    `bg_image_status` varchar(200) NOT NULL,

    `sidebar_status` varchar(200) NOT NULL,
    `products_listing_view` varchar(200) NOT NULL,
    `rollover_effect` varchar(200) NOT NULL,
    `listing_images_size` varchar(200) NOT NULL,
    `product_info_view` varchar(200) NOT NULL,
    `product_image_script` varchar(200) NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ");
$layouts_query = tep_db_query("SELECT * FROM `buyshop_layouts` ");
$layouts = tep_db_fetch_array($layouts_query);


define (MENU_BLOCK_STATUS, $layouts["menu_block_status"]);
define (BG_IMAGE_STATUS, $layouts["bg_image_status"]);


define (SIDEBAR_STATUS, $layouts["sidebar_status"]);
define (PRODUCT_LISTING_VIEW, $layouts["products_listing_view"]);
define (ROLLOVER_EFFECT, $layouts["rollover_effect"]);
define (LISTING_IMAGES_SIZE, $layouts["listing_images_size"]);
define (PRODUCT_INFO_VIEW, $layouts["product_info_view"]);
define (PRODUCT_IMAGE_SCRIPT, $layouts["product_image_script"]);

/* video */
$model_query = tep_db_query("SELECT products_model FROM `products` WHERE products_id = '1' ");
$model = tep_db_fetch_array($model_query);

if ($model['products_model'] == 'MG200MMS') {
    $clean_models = tep_db_query ("UPDATE `products` SET `products_model` = '' ");
}









