<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2012 osCommerce

  Released under the GNU General Public License
*/

  $oscTemplate->buildBlocks();

  if (!$oscTemplate->hasBlocks('boxes_column_left')) {
    $oscTemplate->setGridContentWidth($oscTemplate->getGridContentWidth() + $oscTemplate->getGridColumnWidth());
  }

  if (!$oscTemplate->hasBlocks('boxes_column_right')) {
    $oscTemplate->setGridContentWidth($oscTemplate->getGridContentWidth() + $oscTemplate->getGridColumnWidth());
  }
?>
<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><html lang="en"> <![endif]-->

<html xmlns="http://www.w3.org/1999/xhtml" <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>" />
<title><?php echo tep_output_string_protected($oscTemplate->getTitle()); ?></title>

    <!-- Mobile Specific Metas==== -->
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <base href="<?php echo (($request_type == 'SSL') ? HTTPS_SERVER : HTTP_SERVER) . DIR_WS_CATALOG; ?>" />
<link rel="stylesheet" type="text/css" href="ext/jquery/ui/redmond/jquery-ui-1.10.4.min.css" />
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>

    <![endif]-->

    <script type="text/javascript" src="ext/jquery/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="ext/jquery/ui/jquery-ui-1.10.4.min.js"></script>


<?php
  if (tep_not_null(JQUERY_DATEPICKER_I18N_CODE)) {
?>
<script type="text/javascript" src="ext/jquery/ui/i18n/jquery.ui.datepicker-<?php echo JQUERY_DATEPICKER_I18N_CODE; ?>.js"></script>
<script type="text/javascript">
$.datepicker.setDefaults($.datepicker.regional['<?php echo JQUERY_DATEPICKER_I18N_CODE; ?>']);
</script>
<?php
  }


?>
<script type="text/javascript" src="ext/photoset-grid/jquery.photoset-grid.min.js"></script>

<link rel="stylesheet" type="text/css" href="ext/colorbox/colorbox.css" />
<script type="text/javascript" src="ext/colorbox/jquery.colorbox-min.js"></script>

<script type="text/javascript" src="ext/jquery/bxGallery/jquery.bxGallery.1.1.min.js"></script>
<link rel="stylesheet" type="text/css" href="ext/jquery/fancybox/jquery.fancybox-1.3.4.css" />
<script type="text/javascript" src="ext/jquery/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="ext/960gs/<?php echo ((stripos(HTML_PARAMS, 'dir="rtl"') !== false) ? 'rtl_' : ''); ?>960_24_col.css" />
<link rel="stylesheet" type="text/css" href="stylesheet.css" />

<!-- megastore styles -->

    <link rel="stylesheet" type="text/css" href="<?php echo  DC_STYLES ?>reset.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo  DC_STYLES ?>bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo  DC_STYLES ?>bootstrap-responsive.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo  DC_STYLES ?>flexslider.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo  DC_STYLES ?>andepict.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo  DC_STYLES ?>product-slider.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo  DC_STYLES ?>jquery.selectbox.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo  DC_STYLES ?>nouislider.css" />

<?php
    if (BUYSHOP_SLIDER == 'layerslider') {
?>
        <link rel="stylesheet" type="text/css" href="<?php echo  DC_STYLES ?>layerslider.css" />

<?php } ?>

    <link rel="stylesheet" type="text/css" href="<?php echo  DC_STYLES ?>style.css" />


<!-- new fancybox -->
<?php
    //if (PRODUCT_IMAGE_SCRIPT == 'fancybox') {
?>
<link rel="stylesheet" type="text/css" href="<?php echo  DC_STYLES ?>fancybox/jquery.fancybox-buttons.css" />
<link rel="stylesheet" type="text/css" href="<?php echo  DC_STYLES ?>fancybox/jquery.fancybox-thumbs.css" />
<link rel="stylesheet" type="text/css" href="<?php echo  DC_STYLES ?>fancybox/jquery.fancybox.css" />
<?php
    //}
?>
<!-- new fancybox -->






<link rel="stylesheet" type="text/css" href="<?php echo  DC_STYLES ?>megastore.css" />


    <link rel="stylesheet" type="text/css" href="<?php echo  DC_STYLES ?>light-theme.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo  DC_STYLES ?><?php echo BUYSHOP_THEME ?>-theme.css" />

<link rel="stylesheet" type="text/css" href="<?php echo  DC_STYLES ?>custom.css" />

<!--[if IE 8 ]><link rel="stylesheet" type="text/css" href="<?php echo DC_STYLES ?>styleie8.css" /><![endif]-->
    <!--[if IE 9]><link rel="stylesheet" type="text/css" href="<?php echo DC_STYLES ?>styleie9.css" /><![endif]-->


<!--[if !IE]><!-->
<script>if(/*@cc_on!@*/false){document.documentElement.className+='ie10';}</script>
<!--<![endif]-->


<!-- end megastore styles -->

    <!-- megastore scripts -->
    <!--
    <script src="https://ajax.googleapis.com/ajax/libs/prototype/1.7.1.0/prototype.js"></script>
    -->
    <script type="text/javascript" src="<?php echo  DC_SCRIPTS ?>html5.js"></script>


    <script type="text/javascript" src="<?php echo  DC_SCRIPTS ?>jquery-1.7.2.min.js"></script>
    <script type="text/javascript" src="<?php echo  DC_SCRIPTS ?>jquery-ui.min.js"></script>


    <script type="text/javascript" src="<?php echo DC_SCRIPTS ?>bootstrap.js"></script>
    <script type="text/javascript" src="<?php echo DC_SCRIPTS ?>jquery.easing.js"></script>
    <script type="text/javascript" src="<?php echo DC_SCRIPTS ?>jquery.mousewheel.js"></script>

    <script type="text/javascript" src="<?php echo DC_SCRIPTS ?>jquery.flexslider.js"></script>



<?php
  if (BUYSHOP_SLIDER == 'layerslider') {
?>
    <script type="text/javascript" src="<?php echo DC_SCRIPTS ?>layerslider.kreaturamedia.jquery.js"></script>
    <script type="text/javascript" src="<?php echo DC_SCRIPTS ?>layerslider_output_<?php echo BUYSHOP_THEME; ?>.js"></script>

<?php
 }
?>




    <script type="text/javascript" src="<?php echo DC_SCRIPTS ?>jquery.elastislide.js"></script>
    <script type="text/javascript" src="<?php echo DC_SCRIPTS ?>jquery.selectbox-0.2.js"></script>
    <script type="text/javascript" src="<?php echo DC_SCRIPTS ?>jquery.nouislider.js"></script>


    <script type="text/javascript" src="<?php echo DC_SCRIPTS ?>cloud-zoom.1.0.2.js"></script>
<script type="text/javascript" src="<?php echo DC_SCRIPTS ?>retina-replace.js"></script>


<!-- new fancybox -->
<?php
    //if (PRODUCT_IMAGE_SCRIPT == 'fancybox') {
?>
<script type="text/javascript" src="<?php echo DC_SCRIPTS ?>fancybox/jquery.fancybox.js"></script>
<script type="text/javascript" src="<?php echo DC_SCRIPTS ?>fancybox/jquery.fancybox-buttons.js"></script>
<script type="text/javascript" src="<?php echo DC_SCRIPTS ?>fancybox/jquery.fancybox-thumbs.js"></script>
<script type="text/javascript" src="<?php echo DC_SCRIPTS ?>fancybox/jquery.easing-1.3.pack.js"></script>
<script type="text/javascript" src="<?php echo DC_SCRIPTS ?>fancybox/jquery.mousewheel-3.0.6.pack.js"></script>
<?php
    //}
?>
<!-- new fancybox -->








<script type="text/javascript" src="<?php echo DC_SCRIPTS ?>custom.js"></script>



    <!-- end megastore scripts -->
<link href='//fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Rokkitt' rel='stylesheet' type='text/css'>

    <link href='//fonts.googleapis.com/css?family=<?php echo str_replace(' ', '+', BUYSHOP_CAPTIONS_TEXT_GOOGLE); ?>:200,300,400,500,600,700,800' rel='stylesheet' type='text/css'>


<?php echo $oscTemplate->getBlocks('header_tags'); ?>


    <!-- options from admin -->
    <style type="text/css">

        .nav-list li li a:hover,#nav > li > a:hover,
        .nav-list > li:hover > a,#nav > li:hover > a,
        .nav-tabs > .active > a,
        .nav-tabs > li > a:hover{
            color:white !important
        }


            /* bg image  */
<?php if (BG_IMAGE_STATUS !== 'disable') { ?>
        body{
            background-image:url("images/<?php echo BUYSHOP_THEME ?>/background_image.png");
            background-position: center center
        }
    <?php } ?>
        /* bg image  */

            /* theme color  */
        .bgcolor_icon,
        .form-mail button,
        .es-nav a.btn:hover,
        .flexslider.small .flex-direction-nav a:hover,
        .nav-tabs > li > a:hover, .nav-tabs > .active > a, .nav-tabs > .active > a:hover,
        .nav > li > a:hover,
        .messageStackSuccess{
            background-color:<?php echo BUYSHOP_THEMECOLOR; ?>
        }
        #topline .phone i,
        #topline a:hover,
        #topline .fadelink li a:hover, #topline .fadelink > a:hover,
        #nav > li.home-link:hover > a,
        .nav-list li li a:hover,
        .breadcrumbs a,
        a.custom_color,
        a.custom_color:hover,
        .twit .icon,
        h4 [class^="icon-twitter-bird"],
        .flex-direction-nav a,
        .form-search button.btn-top-search,
        .product .product-tocart a, .preview .product-tocart a,
        .product-img-box .more-views li .video i,
        .rating strong i{
            color:<?php echo BUYSHOP_THEMECOLOR; ?>
        }

        textarea:focus, input[type="text"]:focus, input[type="password"]:focus, input[type="datetime"]:focus, input[type="datetime-local"]:focus, input[type="date"]:focus, input[type="month"]:focus, input[type="time"]:focus, input[type="week"]:focus, input[type="number"]:focus, input[type="email"]:focus, input[type="url"]:focus, input[type="search"]:focus, input[type="tel"]:focus, input[type="color"]:focus, .uneditable-input:focus,
        .cloud-zoom-big{
            border-color: <?php echo BUYSHOP_THEMECOLOR; ?>;
        }

        #nav > li > ul,
        #nav li:hover .menu_custom_block,
        .ui-widget-header,
        .ui-widget-content,
        .tab-content{
            border-color:<?php echo BUYSHOP_THEMECOLOR; ?>;

        }

        button, .button,
        .shopping_cart_mini .button:hover,
        #nav > li:hover > a,
        button.button-3x, .button.button-3x,
        .nav-header > a,
        .custom_submit,
        .ui-widget-header,
        .middle_icon_color{
            background:<?php echo BUYSHOP_THEMECOLOR; ?>;
        }
/* end theme color  */

/* text color  */
        table, table td,
        body, .hidden-small-desktop, #topline .link_label,
        select, textarea, input[type="text"], input[type="password"], input[type="datetime"], input[type="datetime-local"], input[type="date"], input[type="month"], input[type="time"], input[type="week"], input[type="number"], input[type="email"], input[type="url"], input[type="search"], input[type="tel"], input[type="color"], .uneditable-input,
        .product .product-price, .product .product-price-regular, .preview .product-price, .preview .product-price-regular,
        .cleancode, ul.icons li, #footer_bottom .noHover span.text, #footer_bottom .noHover span.text span, .form-mail input,
        .rating-stars span,
        #topline .phone,
        .shopping_cart_mini, .shopping_cart_mini .product-price,
        .product .product-price span.old, .product .product-price-regular span.old, .preview .product-price span.old, .preview .product-price-regular span.old,
        .checkoutBarCurrent,
        .checkoutBarFrom, .checkoutBarTo,
        .ui-widget-content{
            color: <?php echo BUYSHOP_TEXTCOLOR; ?>;
        }
/* end text color  */

/* link color  */
        a, #topline, #topline a, #footer_bottom i,
        #topline .fadelink > a, #topline .fadelink li a, #topline .fadelink > a,
        #nav > li > a, #footer_popup p a, #nav li.level1 > a, #nav li.level2 > a, .nav-tabs > li > a,
        .reviews-box a.custom_submit, .reviews-box .reviews_link,
        .twit a,
        .shopping_cart_mini .product-detailes .product-name,
        .contentContainer a.checkoutBarFrom,
        .contentContainer a.checkoutBarTo,
        .orderEdit{
            color: <?php echo BUYSHOP_LINKCOLOR; ?>;
        }
/* end link color  */

/* link hover color  */
        a:hover,
        #topline a:hover,
        #topline .fadelink li a:hover, #topline .fadelink > a:hover,
        .nav-list li li a:hover,
        .breadcrumbs a:hover,
        .flexslider.small .flex-direction-nav a:hover,
        .custom_submit:hover, #nav li.level1:hover > a, #nav li.level2:hover > a, #footer_popup p a:hover,
        .nav-tabs > .active > a:hover,
        .twit a:hover,
        .shopping_cart_mini .product-detailes .product-name:hover,
        .contentContainer a.checkoutBarFrom:hover,
        .contentContainer a.checkoutBarTo:hover,
        .orderEdit:hover{
            color: <?php echo BUYSHOP_LINKHOVERCOLOR; ?>;
        }

        #nav > li.home-link:hover > a{
            color: <?php echo BUYSHOP_LINKHOVERCOLOR; ?> !important;
        }

            /* end link hover color  */

/* Background color  */
        body{
            background-color:<?php echo BUYSHOP_BGCOLOR; ?>;
        }
/* end Background color  */

/* captions color  */
        h1, #column_right h1, h2, h3, h4,
        .nav-list li a,
        #nav > li > a,
        .block .block-title,
        .accordion-heading,
        .custom_blocks .box a,
        #footer_popup h3, #footer_popup h4,
        button, .button,
        .custom_submit,
        .infoBox .infoBoxHeading, .infoBox .infoBoxHeading a,
        button.button-2x, .button.button-2x,
        button.button-3x, .button.button-3x,
        .product-shop .product-name h1, #column_right .product-shop .prod_info_name h1{
            color: <?php echo BUYSHOP_CAPTIONS_TEXT_COLOR; ?>;
        }
/* end captions color  */

/* captions google font  */

        h1, #column_right h1, h2, h3, h4,
        .nav-list li a,
        #nav > li > a,
        .block .block-title,
        .accordion-heading,
        .custom_blocks .box a,
        #footer_popup h3, #footer_popup h4,
        .infoBox .infoBoxHeading, .infoBox .infoBoxHeading a,
        button.button-2x, .button.button-2x,
        button.button-3x, .button.button-3x,
        .product-shop .product-name h1, #column_right .product-shop .prod_info_name h1,
        .product-shop h2.custom_block_title{
            font-family:<?php echo BUYSHOP_CAPTIONS_TEXT_GOOGLE; ?>;
        }

/* end captions google font  */

/* simple product view in listing  */
<?php if (PRODUCT_LISTING_VIEW == 'simple') { ?>
        .product .wrapper-hover{
            display: none!important;
        }
        .product .product-image-wrapper{padding: 5px!important}
<?php } ?>

/* simple product view in listing  */




    </style>
    <!-- end options from admin -->


</head>
<body>


    <!-- begin wrap //-->
    <div id="wrap">

        <?php include(DIR_WS_INCLUDES . 'header.php'); ?>

        <section id="content">

            <!-- blocks for all pages-->
            <?php if (!$main_page_url) { ?>
               <div class="container top <?php echo ($product_page_url) ? 'product_view_page' : 'general_page'; ?>">
                   <div class="row">
                   <?php if (!$product_page_url && !$main_page_url){ ?>

                        <div id="column_right" class="<?php echo (SIDEBAR_STATUS !== 'disable') ? 'span9' : 'span12' ?>">

                   <?php } ?>


            <?php } ?>
            <!-- end blocks for all pages-->


            <?php if ($product_page_url) {
                include(DC_BLOCKS . 'megastore_breadcrumbs.php');
            } ?>
