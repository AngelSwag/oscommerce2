<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');
  require(DIR_WS_INCLUDES . 'template_top.php');
?>

    <table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading">Layouts settings</td>
            <td class="pageHeading" align="right"><?php echo tep_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>

        <?php
        $check = tep_db_query("select * from `buyshop_layouts` ");
        if (isset($_POST['menu_block_status']) ||isset($_POST['bg_image_status']) ||isset($_POST['sidebar_status']) || isset($_POST['products_listing_view']) || isset($_POST['rollover_effect']) || isset($_POST['listing_images_size']) || isset($_POST['product_info_view']) || isset($_POST['product_image_script'])) {

            $menu_block_status = $_POST['menu_block_status'];
            $bg_image_status = $_POST['bg_image_status'];


            $sidebar_status = $_POST['sidebar_status'];
            $products_listing_view = $_POST['products_listing_view'];
            $rollover_effect = $_POST['rollover_effect'];
            $listing_images_size = $_POST['listing_images_size'];
            $product_info_view = $_POST['product_info_view'];
            $product_image_script = $_POST['product_image_script'];



            if (tep_db_num_rows($check) == 0) {
                tep_db_query("INSERT INTO `buyshop_layouts` (`menu_block_status`, `bg_image_status`, `sidebar_status`, `products_listing_view`, `rollover_effect`, `listing_images_size`, `product_info_view`, `product_image_script` ) VALUES ('$menu_block_status', '$bg_image_status', '$sidebar_status', '$products_listing_view', '$rollover_effect', '$listing_images_size', '$product_info_view', '$product_image_script' )");
        } else {
                tep_db_query("UPDATE `buyshop_layouts` SET `menu_block_status` = '$menu_block_status', `bg_image_status` = '$bg_image_status', `sidebar_status` = '$sidebar_status', `products_listing_view` =  '$products_listing_view', `rollover_effect` = '$rollover_effect', `listing_images_size` =  '$listing_images_size', `product_info_view` =  '$product_info_view', `product_image_script` =  '$product_image_script' ");
        }

            echo '<tr><td class="dataTableHeadingContent" style="color:#000;font-size: 11px">Layouts were changed!</td></tr>';
            ?>
            <tr><td>
            <a href="buyshop_layouts.php" style="float: right;margin-top: 10px" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary ui-priority-secondary" role="button" aria-disabled="false">
                <span class="ui-button-icon-primary ui-icon ui-icon-triangle-1-w"></span>
                <span class="ui-button-text">Back</span>
            </a>
            </td></tr>
            <?php

        } else {

            $check = tep_db_query("select * from `buyshop_layouts` ");

            $new_page_query = tep_db_query("select menu_block_status, bg_image_status, sidebar_status, products_listing_view, rollover_effect, listing_images_size, product_info_view, product_image_script from `buyshop_layouts` ");
            $new_output = tep_db_fetch_array($new_page_query);

            $m_menu_block_status = $new_output['menu_block_status'];
            $m_bg_image_status = $new_output['bg_image_status'];

            $m_sidebar_status = $new_output['sidebar_status'];
            $m_products_listing_view = $new_output['products_listing_view'];
            $m_rollover_effect = $new_output['rollover_effect'];
            $m_listing_images_size = $new_output['listing_images_size'];
            $m_product_info_view = $new_output['product_info_view'];
            $m_product_image_script = $new_output['product_image_script'];

?>




      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top">

                <!-- FORM CHOOSE THEME COLOR -->
                <form name="buyshop_layouts" action="buyshop_layouts.php" method="post">
                    <table border="0" width="100%" cellspacing="0" cellpadding="2">


                        <!-- ENABLE / DISABLE CUSTOM BLOCK IN TOP MENU -->
                        <tr class="dataTableHeadingRow">
                            <td class="dataTableHeadingContent">ENABLE / DISABLE CUSTOM BLOCK IN TOP MENU</td>
                        </tr>
                        <tr>
                            <td class="dataTableContent">
                                <p style="overflow: hidden;float: left;margin-right: 20px">
                                    <input name="menu_block_status" type="radio" <?php if ($m_menu_block_status == 'enable') { echo 'checked="checked"'; } ?> value="enable" />
                                    <label>Enable</label>
                                </p>
                                <p style="overflow: hidden;float: left;">
                                    <input name="menu_block_status" type="radio" <?php if ($m_menu_block_status == 'disable') { echo 'checked="checked"'; } ?> value="disable" />
                                    <label>Disable</label>
                                </p>
                            </td>
                        </tr>
                        <!-- ENABLE / DISABLE CUSTOM BLOCK IN TOP MENU -->

                        <!-- ENABLE / DISABLE BG IMAGE -->
                        <tr class="dataTableHeadingRow">
                            <td class="dataTableHeadingContent">ENABLE / DISABLE BACKGROUND IMAGE</td>
                        </tr>
                        <tr>
                            <td class="dataTableContent">
                                <p style="overflow: hidden;float: left;margin-right: 20px">
                                    <input name="bg_image_status" type="radio" <?php if ($m_bg_image_status == 'enable') { echo 'checked="checked"'; } ?> value="enable" />
                                    <label>Enable</label>
                                </p>
                                <p style="overflow: hidden;float: left;">
                                    <input name="bg_image_status" type="radio" <?php if ($m_bg_image_status == 'disable') { echo 'checked="checked"'; } ?> value="disable" />
                                    <label>Disable</label>
                                </p>
                            </td>
                        </tr>
                        <!-- ENABLE / DISABLE BG IMAGE -->



                        <!-- ENABLE / DISABLE SIDEBAR IN LISTING -->
                        <tr class="dataTableHeadingRow">
                           <td class="dataTableHeadingContent">ENABLE / DISABLE SIDEBAR IN LISTING</td>
                        </tr>
                        <tr>
                            <td class="dataTableContent">
                                    <p style="overflow: hidden;float: left;margin-right: 20px">
                                        <input name="sidebar_status" type="radio" <?php if ($m_sidebar_status == 'enable') { echo 'checked="checked"'; } ?> value="enable" />
                                        <label>Enable</label>
                                    </p>
                                    <p style="overflow: hidden;float: left;">
                                        <input name="sidebar_status" type="radio" <?php if ($m_sidebar_status == 'disable') { echo 'checked="checked"'; } ?> value="disable" />
                                        <label>Disable</label>
                                    </p>
                            </td>
                        </tr>
                        <!-- END ENABLE / DISABLE SIDEBAR IN LISTING -->

                        <!-- Usual / simple product view in listing.  -->
                        <tr class="dataTableHeadingRow">
                            <td class="dataTableHeadingContent">USUAL / SIMPLE PRODUCT VIEWING IN LISTING</td>
                        </tr>
                        <tr>
                            <td class="dataTableHeadingContent" style="color: #000">Usual - image, product info, price, etc. Simple - image only</td>
                        </tr>
                        <tr>
                            <td class="dataTableContent">
                                <p style="overflow: hidden;float: left;margin-right: 20px">
                                    <input name="products_listing_view" type="radio" <?php if ($m_products_listing_view == 'usual') { echo 'checked="checked"'; } ?> value="usual" />
                                    <label>Usual view</label>
                                </p>
                                <p style="overflow: hidden;float: left;">
                                    <input name="products_listing_view" type="radio" <?php if ($m_products_listing_view == 'simple') { echo 'checked="checked"'; } ?> value="simple" />
                                    <label>Simple view</label>
                                </p>
                            </td>
                        </tr>
                        <!-- end Usual / simple product view in listing.  -->

                        <!-- Switch rollover effect simple / advanced. -->
                        <tr class="dataTableHeadingRow">
                            <td class="dataTableHeadingContent">SIMPLE / ADVANCED ROLLOVER EFFECT ON PRODUCTS IN LISTING</td>
                        </tr>
                        <tr>
                            <td class="dataTableContent">
                                <p style="overflow: hidden;float: left;margin-right: 20px">
                                    <input name="rollover_effect" type="radio" <?php if ($m_rollover_effect == 'simple') { echo 'checked="checked"'; } ?> value="simple" />
                                    <label>Simple rollover</label>
                                </p>
                                <p style="overflow: hidden;float: left;">
                                    <input name="rollover_effect" type="radio" <?php if ($m_rollover_effect == 'advanced') { echo 'checked="checked"'; } ?> value="advanced" />
                                    <label>Advanced rollover</label>
                                </p>
                            </td>
                        </tr>
                        <!-- end Switch rollover effect simple / advanced. -->


                        <!-- Small / big images in product listing -->
                        <tr class="dataTableHeadingRow">
                            <td class="dataTableHeadingContent">SMALL / BIG IMAGES OF PRODUCTS IN LISTINGS</td>
                        </tr>
                        <tr>
                            <td class="dataTableContent">
                                <p style="overflow: hidden;float: left;margin-right: 20px">
                                    <input name="listing_images_size" type="radio" <?php if ($m_listing_images_size == 'small') { echo 'checked="checked"'; } ?> value="small" />
                                    <label>Small images</label>
                                </p>
                                <p style="overflow: hidden;float: left;">
                                    <input name="listing_images_size" type="radio" <?php if ($m_listing_images_size == 'big') { echo 'checked="checked"'; } ?> value="big" />
                                    <label>Big images</label>
                                </p>
                            </td>
                        </tr>
                        <!-- end Small / big images in product listing -->


                        <!-- PRODUCT INFO PAGE WITH / WITHOUT PRODUCT CUSTOM BLOCK -->
                        <tr class="dataTableHeadingRow">
                            <td class="dataTableHeadingContent">PRODUCT INFO PAGE WITH / WITHOUT PRODUCT CUSTOM BLOCK</td>
                        </tr>
                        <tr>
                            <td class="dataTableContent">
                                <p style="overflow: hidden;float: left;margin-right: 20px">
                                    <input name="product_info_view" type="radio" <?php if ($m_product_info_view == 'with') { echo 'checked="checked"'; } ?> value="with" />
                                    <label>Product page with custom block</label>
                                </p>
                                <p style="overflow: hidden;float: left;">
                                    <input name="product_info_view" type="radio" <?php if ($m_product_info_view == 'without') { echo 'checked="checked"'; } ?> value="without" />
                                    <label>Product page without custom block</label>
                                </p>
                            </td>
                        </tr>
                        <!-- end PRODUCT INFO PAGE WITH / WITHOUT PRODUCT CUSTOM BLOCK -->

                        <!-- Choose image preview type: Cloud zoom / FancyBox -->
                        <tr class="dataTableHeadingRow">
                            <td class="dataTableHeadingContent">IMAGE PREVIEW TYPE ON PRODUCT PAGE</td>
                        </tr>
                        <tr>
                            <td class="dataTableContent">
                                <p style="overflow: hidden;float: left;margin-right: 20px">
                                    <input name="product_image_script" type="radio" <?php if ($m_product_image_script == 'cloudzoom') { echo 'checked="checked"'; } ?> value="cloudzoom" />
                                    <label>Cloudzoom</label>
                                </p>
                                <p style="overflow: hidden;float: left;">
                                    <input name="product_image_script" type="radio" <?php if ($m_product_image_script == 'fancybox') { echo 'checked="checked"'; } ?> value="fancybox" />
                                    <label>Fancy box</label>
                                </p>
                            </td>
                        </tr>
                        <!-- end Choose image preview type: Cloud zoom / FancyBox -->





                        <tr>
                                <td align="right">
                                    <button class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary ui-priority-primary" type="submit">
                                        <span class="ui-button-icon-primary ui-icon ui-icon-disk"></span>
                                        <span class="ui-button-text">Save</span>
                                    </button>
                                </td>
                            </tr>

                    </table>
                </form>
                <!-- FORM CHOOSE THEME COLOR -->

            </td>
          </tr>
        </table></td>
      </tr>



       <?php } ?>

    </table>

<?php
  require(DIR_WS_INCLUDES . 'template_bottom.php');
  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>
