<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  $cl_box_groups[] = array(
    'heading' => 'Megastore Options',
    'apps' => array(
      array(
        'code' => FILENAME_GENERAL_OPTIONS_THEMECOLOR,
        'title' => 'General Options',
        'link' => tep_href_link(FILENAME_GENERAL_OPTIONS_THEMECOLOR)
      ),
      array(
        'code' => FILENAME_THEME_STICKERS,
        'title' => 'Stickers Options',
        'link' => tep_href_link(FILENAME_THEME_STICKERS)
      ),
      array(
            'code' => FILENAME_THEME_LAYOUTS,
            'title' => 'Layouts changing',
            'link' => tep_href_link(FILENAME_THEME_LAYOUTS)
      ),
        array(
            'code' => FILENAME_LOGO_MINI,
            'title' => 'Right Mini logo',
            'link' => tep_href_link(FILENAME_LOGO_MINI)
        ),
        array(
            'code' => FILENAME_BACKGROUND_IMAGE,
            'title' => 'Background Image',
            'link' => tep_href_link(FILENAME_BACKGROUND_IMAGE)
        )
    )
  );