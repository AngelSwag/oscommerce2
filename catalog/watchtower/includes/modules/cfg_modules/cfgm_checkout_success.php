<?php
/*
  $Id cfgm_checkout_success.php v1.0 20110112 Kymation $
  $Loc: catalog/admin/includes/modules/cfg_modules/ $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2011 osCommerce

  Released under the GNU General Public License
*/

  class cfgm_checkout_success {
    var $code = 'checkout_success';
    var $directory;
    var $language_directory = DIR_FS_CATALOG_LANGUAGES;
    var $key = 'MODULE_CHECKOUT_SUCCESS_INSTALLED';
    var $title;
    var $template_integration = true;

    function cfgm_checkout_success() {
      $this->directory = DIR_FS_CATALOG_MODULES . 'checkout_success/';
      $this->title = MODULE_CFG_MODULE_CHECKOUT_SUCCESS_TITLE;
    }
  }
?>
