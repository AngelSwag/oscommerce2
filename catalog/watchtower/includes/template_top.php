<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2012 osCommerce

  Released under the GNU General Public License
*/
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<meta name="robots" content="noindex,nofollow">
<title><?php echo TITLE; ?></title>
<base href="<?php echo ($request_type == 'SSL') ? HTTPS_SERVER . DIR_WS_HTTPS_ADMIN : HTTP_SERVER . DIR_WS_ADMIN; ?>" />
<!--[if IE]><script type="text/javascript" src="<?php echo tep_catalog_href_link('ext/flot/excanvas.min.js', '', 'SSL'); ?>"></script><![endif]-->
<link rel="stylesheet" type="text/css" href="<?php echo tep_catalog_href_link('ext/jquery/ui/redmond/jquery-ui-1.10.4.min.css', '', 'SSL'); ?>">
<script type="text/javascript" src="<?php echo tep_catalog_href_link('ext/jquery/jquery-1.11.1.min.js', '', 'SSL'); ?>"></script>
<script type="text/javascript" src="<?php echo tep_catalog_href_link('ext/jquery/ui/jquery-ui-1.10.4.min.js', '', 'SSL'); ?>"></script>

<?php
  if (tep_not_null(JQUERY_DATEPICKER_I18N_CODE)) {
?>
<script type="text/javascript" src="<?php echo tep_catalog_href_link('ext/jquery/ui/i18n/jquery.ui.datepicker-' . JQUERY_DATEPICKER_I18N_CODE . '.js', '', 'SSL'); ?>"></script>
<script type="text/javascript">
$.datepicker.setDefaults($.datepicker.regional['<?php echo JQUERY_DATEPICKER_I18N_CODE; ?>']);
</script>
<?php
  }
?>

<script type="text/javascript" src="<?php echo tep_catalog_href_link('ext/flot/jquery.flot.min.js', '', 'SSL'); ?>"></script>
<script type="text/javascript" src="<?php echo tep_catalog_href_link('ext/flot/jquery.flot.time.min.js', '', 'SSL'); ?>"></script><link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<script type="text/javascript" src="includes/general.js"></script>
    <!-- colorpicker -->
    <script type="text/javascript" src="includes/mColorPicker/mColorPicker.js"></script>
    <script type="text/javascript" src="includes/mColorPicker/mColorPicker_output.js"></script>
    <!-- colorpicker -->

<!--  START CONTRIBUTIONS MANAGER  -->
<SCRIPT LANGUAGE='JAVASCRIPT' TYPE='TEXT/JAVASCRIPT'>
var win=null;
function NewWindow(mypage,myname,w,h,pos,infocus){
if(pos=="random"){myleft=(screen.width)?Math.floor(Math.random()*(screen.width-w)):100;mytop=(screen.height)?Math.floor(Math.random()*((screen.height-h)-75)):100;}
if(pos=="center"){myleft=(screen.width)?(screen.width-w)/2:100;mytop=(screen.height)?(screen.height-h)/2:100;}
else if((pos!='center' && pos!="random") || pos==null){myleft=0;mytop=20}
settings="width=" + w + ",height=" + h + ",top=" + mytop + ",left=" + myleft + ",scrollbars=yes,location=no,directories=no,status=no,menubar=no,toolbar=no,resizable=yes";win=window.open(mypage,myname,settings);
win.focus();}
</script>
<!--  END CONTRIBUTIONS MANAGER  -->

    <?php
    if (!defined('USE_CKEDITOR_ADMIN_TEXTAREA')) {
        tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added, set_function) values ('', 'Use CKEditor', 'USE_CKEDITOR_ADMIN_TEXTAREA','true','Use CKEditor for WYSIWYG editing of textarea fields in admin',1,99,now(),'tep_cfg_select_option(array(\'true\', \'false\'),' )");
        define ('USE_CKEDITOR_ADMIN_TEXTAREA','true');
    }
    if (USE_CKEDITOR_ADMIN_TEXTAREA == "true") {
        ?>
        <script type="text/javascript" src="<?php echo tep_href_link('ext/ckeditor/ckeditor.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo tep_href_link('ext/ckeditor/adapters/jquery.js'); ?>"></script>
        <script type="text/javascript">
            jQuery(function() {
                var $editors = jQuery('textarea');
                if ($editors.length) {
                    $editors.each(function() {
                        var editorID = $(this).attr("id");
                        var instance = CKEDITOR.instances[editorID];
                        if (instance) { CKEDITOR.remove(instance); }
                        CKEDITOR.replace(editorID);
                    });
                }




                //update font preview
                jQuery(function(){
                    fontSelect=jQuery("#option_captions_text_google");
                    fontUpdate=function(){
                        curFont=jQuery("#option_captions_text_google").val();
                        jQuery("#bs_general_font_preview").css({ fontFamily: curFont });
                        jQuery("<link />",{href:"http://fonts.googleapis.com/css?family="+curFont,rel:"stylesheet",type:"text/css"}).appendTo("head");
                    }
                    fontSelect.change(function(){
                        fontUpdate();
                    }).keyup(function(){
                            fontUpdate();
                        }).keydown(function(){
                            fontUpdate();
                        });
                    jQuery("#option_captions_text_google").trigger("change");
                    fontUpdate();
                });



            });
        </script>
        <?php
    }
    ?>
<!-- AJAX Attribute Manager  -->
<?php 
	if ((basename($_SERVER["SCRIPT_NAME"]) == FILENAME_CATEGORIES)) {
		require('attributeManager/includes/attributeManagerHeader.inc.php');
	}
?>
<!-- AJAX Attribute Manager  end -->
</head>
<!-- AJAX Attribute Manager  -->
<?php 
	if ((basename($_SERVER["SCRIPT_NAME"]) == FILENAME_CATEGORIES)) {
?>
<body onload="goOnLoad();">
<?php
	} else {
?>
<body onload="goOnLoad();">
<?php
	}
?>
<!-- AJAX Attribute Manager  end -->


<?php require(DIR_WS_INCLUDES . 'header.php'); ?>

<?php
  if (tep_session_is_registered('admin')) {
    include(DIR_WS_INCLUDES . 'column_left.php');
  } else {
?>

<style>
#contentText {
  margin-left: 0;
}
</style>

<?php
  }
?>

<div id="contentText">
