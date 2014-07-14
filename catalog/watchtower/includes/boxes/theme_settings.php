<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  $cl_box_groups[] = array(
    'heading' => 'Megastore Theme Switch',
    'apps' => array(
      array(
        'code' => FILENAME_THEME_COLOR,
        'title' => 'Theme Skin',
        'link' => tep_href_link(FILENAME_THEME_COLOR)
      ),
      array(
        'code' => FILENAME_SLIDER_TYPE,
        'title' => 'Slider Type',
        'link' => tep_href_link(FILENAME_SLIDER_TYPE)
      )
    )
  );