<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  if ($messageStack->size('header') > 0) {
    echo '<div>' . $messageStack->output('header') . '</div>';
  }
?>

<!--RIGHT TOOLBAR-->
<?php include(DC_BLOCKS . 'megastore_right_toolbar.php');?>
<!-- TOP LINE BLOCKS-->
<?php include(DC_BLOCKS . 'megastore_topline.php');?>


<div id="header">
    <div class="container">

        <div class="wrapper_w">
            <div id="logo">
                <div id="storeLogo">
                    <?php echo '<a href="' . tep_href_link(FILENAME_DEFAULT) . '">' . tep_image(DIR_WS_IMAGES .BUYSHOP_THEME. '/store_logo.png', STORE_NAME,'','','style="width:253px;height:66px"') . '</a>'; ?>
                </div>
            </div>

            <div class="pull-right padding-1 shopping_cart_top">
                <?php include(DC_BLOCKS . 'megastore_top_cart.php');?>
            </div>

            <?php include(DC_BLOCKS . 'megastore_search.php');?>

        </div>

        <!-- navigation menu -->
        <div class="row">
            <div class="span12">

                <nav>
                    <!-- small menu -->
                    <?php include(DC_BLOCKS . 'megastore_small_categories.php'); ?>
                    <!-- small menu -->

                    <!-- big menu -->
                    <?php include(DC_BLOCKS . 'megastore_main_categories.php'); ?>
                    <!-- big menu -->
                </nav>

            </div>
        </div>
        <!-- navigation menu -->


    </div>
</div>


<?php
  if (isset($HTTP_GET_VARS['error_message']) && tep_not_null($HTTP_GET_VARS['error_message'])) {
?>
<table border="0" width="100%" cellspacing="0" cellpadding="2">
  <tr class="headerError">
    <td class="headerError"><?php echo htmlspecialchars(stripslashes(urldecode($HTTP_GET_VARS['error_message']))); ?></td>
  </tr>
</table>
<?php
  }

  if (isset($HTTP_GET_VARS['info_message']) && tep_not_null($HTTP_GET_VARS['info_message'])) {
?>
<table border="0" width="100%" cellspacing="0" cellpadding="2">
  <tr class="headerInfo">
    <td class="headerInfo"><?php echo htmlspecialchars(stripslashes(urldecode($HTTP_GET_VARS['info_message']))); ?></td>
  </tr>
</table>
<?php
  }
?>
