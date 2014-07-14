<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

?>


<div id="footer">
    <div id="footer_line">

        <div <?php if (BUYSHOP_THEME == 'light') { ?> id="footer_popup" class="footer_bg allowHover" <?php } else { ?> class="footer_info_dark" <?php } ?>>
            <div class="container">
                <div class="row">

                    <div class="span6">
                        <div class="row">
                            <div class="span3">
                                <h3><?php echo MODULE_BOXES_INFORMATION_TITLE; ?></h3>
                                <p><a href="<?php echo MENU_LINK_ABOUT_US; ?>" target="_blank"><?php echo MENU_TEXT_ABOUT_US; ?></a></p>
                                <p><a href="<?php echo tep_href_link(FILENAME_SHIPPING); ?>"><?php echo MODULE_BOXES_INFORMATION_BOX_SHIPPING; ?></a></p>
                                <p><a href="<?php echo tep_href_link(FILENAME_PRIVACY); ?>"><?php echo MODULE_BOXES_INFORMATION_BOX_PRIVACY; ?></a></p>
                                <p><a href="<?php echo tep_href_link(FILENAME_CONDITIONS); ?>"><?php echo BOX_INFORMATION_CONDITIONS; ?></a></p>
                            </div>
                            <div class="span3">
                                <h3><?php echo MENU_CUSTOMER_SERVICE; ?></h3>
                                <p><a href="<?php echo tep_href_link(FILENAME_CONTACT_US); ?>"><?php echo MENU_TEXT_CONTACTUS; ?></a></p>
                                <p> <a href="<?php echo tep_href_link(FILENAME_SHIPPING); ?>"><?php echo MENU_TEXT_RETURNS; ?></a> </p>
                                <p><a href="<?php echo tep_href_link(FILENAME_PRODUCTS_NEW); ?>"><?php echo MENU_TEXT_NEW_PRODUCTS; ?></a></p>
                            </div>
                        </div>
                    </div>


                    <div class="span6">
                        <div class="row">
                            <div class="span3">
                                <h3><?php echo MENU_TEXT_MEMBERS; ?></h3>
                                <p><a href="<?php echo $create_account_url; ?>"><?php echo MENU_TEXT_MEMBERS; ?></a></p>
                                <p><a href="<?php echo tep_href_link(FILENAME_ACCOUNT_HISTORY); ?>"><?php echo ORDER_HISTORY; ?></a></p>
                                <p><a href="<?php echo tep_href_link(FILENAME_ADVANCED_SEARCH); ?>"><?php echo MENU_TEXT_ADVANCE_SEARCH; ?></a></p>
                                <p><a href="<?php echo tep_href_link(FILENAME_REVIEWS); ?>"><?php echo MENU_TEXT_REVIEWS_FOOTER; ?></a></p>
                            </div>

                            <?php include(DC_BLOCKS . 'megastore_footer_newsletter.php'); ?>

                        </div>
                    </div>



                </div>
            </div>
        </div>

        <?php if (BUYSHOP_THEME == 'light') : ?>
        <div id="footer_button"><i class="icon-up"></i></div>
        <?php endif; ?>

        <div class="container" id="footer_bottom">
            <div class="row">
                <div class="span12">
                    <div class="pull-left noHover">
                          <?php include(DC_BLOCKS . 'megastore_footer_payments.php'); ?>
                          <span class="text"><?php echo FOOTER_COPYRIGHT; ?></span>
                    </div>
                    <div class="pull-right noHover">
                        <?php include(DC_BLOCKS . 'megastore_footer_socials.php'); ?>
                    </div>
                </div>
            </div>
        </div>

    </div>



</div>