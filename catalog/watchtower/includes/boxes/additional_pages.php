<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/


$cl_box_groups[] = array(
    'heading' => 'Megastore Custom Blocks',
    'apps' => array(
      array(
        'code' => FILENAME_CUSTOM_MENU_BLOCK,
        'title' => 'Block in Menu',
        'link' => tep_href_link(FILENAME_CUSTOM_MENU_BLOCK)
      ),
      array(
            'code' => FILENAME_CUSTOM_PRODUCT_BLOCK,
            'title' => 'Product Block',
            'link' => tep_href_link(FILENAME_CUSTOM_PRODUCT_BLOCK)
      )
    )
  );