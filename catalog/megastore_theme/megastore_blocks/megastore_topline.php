<div id="topline">
    <div class="container">
        <div class="wrapper_w">
            <div class="pull-left hidden-phone hidden-tablet ">
                <div class="phone">
                    <i class="icon-mobile-alt icon-large"></i><?php echo PHONE_NUMBER; ?>
                </div>
            </div>
            <div class="pull-right">
                <div class="alignright">
                    <span class="hidden-small-desktop"><?php echo HEADER_WELCOME; ?> &nbsp;&nbsp;</span>
                    <span class="hidden-phone"><a href="<?php echo $login_url; ?>"><?php echo $login_text; ?></a> / <a href="<?php echo $create_account_url; ?>"><?php echo $create_account_text; ?></a> &nbsp;&nbsp;</span>
                    <div class="fadelink"><a><?php echo MENU_TEXT_MEMBERS; ?></a>
                        <div class="ul_wrapper">
                            <ul>
                                <li><a href="<?php echo $create_account_url; ?>"><?php echo MENU_TEXT_MEMBERS; ?></a></li>
                                <li><a href="<?php echo tep_href_link(FILENAME_SPECIALS); ?>"><?php echo MENU_TEXT_SPECIALS; ?></a></li>
                                <li><a href="<?php echo tep_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'); ?>"><?php echo MENU_TEXT_CHECKOUT; ?></a></li>
                                <li><a href="<?php echo $login_url; ?>"><?php echo $login_text; ?></a></li>
                                <li><a href="<?php echo tep_href_link(FILENAME_CONTACT_US); ?>"><?php echo MENU_TEXT_EMAILUS; ?></a></li>
                            </ul>
                        </div>
                    </div>

                    <?php include(DC_BLOCKS . 'megastore_languages.php'); ?>
                    <?php include(DC_BLOCKS . 'megastore_currencies.php'); ?>

                </div>
            </div>
        </div>
    </div>
</div>
