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
            <td class="pageHeading">Product stickers settings</td>
            <td class="pageHeading" align="right"><?php echo tep_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>

        <?php
        $check = tep_db_query("select * from `buyshop_stickers` ");
        if (isset($_POST['sticker_new_status']) || isset($_POST['sticker_new_position']) || isset($_POST['sticker_sale_status']) || isset($_POST['sticker_sale_position']) || isset($_POST['sticker_options_status']) || isset($_POST['sticker_options_position'])) {
            $sticker_new_status = $_POST['sticker_new_status'];
            $sticker_new_position = $_POST['sticker_new_position'];
            $sticker_sale_status = $_POST['sticker_sale_status'];
            $sticker_sale_position = $_POST['sticker_sale_position'];
            $sticker_options_status = $_POST['sticker_options_status'];
            $sticker_options_position = $_POST['sticker_options_position'];



            if (tep_db_num_rows($check) == 0) {
                tep_db_query("INSERT INTO `buyshop_stickers` (`sticker_new_status`, `sticker_new_position`, `sticker_sale_status`, `sticker_sale_position`, `sticker_options_status`, `sticker_options_position` ) VALUES ('$sticker_new_status', '$sticker_new_position', '$sticker_sale_status', '$sticker_sale_position', '$sticker_options_status', '$sticker_options_position' )");
        } else {
                tep_db_query("UPDATE `buyshop_stickers` SET `sticker_new_status` = '$sticker_new_status', `sticker_new_position` =  '$sticker_new_position', `sticker_sale_status` = '$sticker_sale_status', `sticker_sale_position` =  '$sticker_sale_position', `sticker_options_status` =  '$sticker_options_status', `sticker_options_position` =  '$sticker_options_position' ");
        }

            echo '<tr><td class="dataTableHeadingContent" style="color:#000;font-size: 11px">Options were set!</td></tr>';
            ?>
            <tr><td>
            <a href="buyshop_stickers.php" style="float: right;margin-top: 10px" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary ui-priority-secondary" role="button" aria-disabled="false">
                <span class="ui-button-icon-primary ui-icon ui-icon-triangle-1-w"></span>
                <span class="ui-button-text">Back</span>
            </a>
            </td></tr>
            <?php

        } else {

            $check = tep_db_query("select * from `buyshop_stickers` ");

            $new_page_query = tep_db_query("select sticker_new_status, sticker_new_position, sticker_sale_status, sticker_sale_position, sticker_options_status, sticker_options_position from `buyshop_stickers` ");
            $new_output = tep_db_fetch_array($new_page_query);

            $m_sticker_new_status = $new_output['sticker_new_status'];
            $m_sticker_new_position = $new_output['sticker_new_position'];
            $m_sticker_sale_status = $new_output['sticker_sale_status'];
            $m_sticker_sale_position = $new_output['sticker_sale_position'];
            $m_sticker_options_status = $new_output['sticker_options_status'];
            $m_sticker_options_position = $new_output['sticker_options_position'];

?>



      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top">

                <!-- FORM CHOOSE THEME COLOR -->
                <form name="buyshop_stickers" action="buyshop_stickers.php" method="post">
                    <table border="0" width="100%" cellspacing="0" cellpadding="2">

<!-- STICKER NEW -->

                        <!-- new sticker status -->
                        <tr class="dataTableHeadingRow">
                                <td class="dataTableHeadingContent">CHOOSE SHOW OR NOT STICKER "NEW" BELOW</td>
                            </tr>
                            <tr>
                                <td class="dataTableContent">
                                    <p style="overflow: hidden;float: left;margin-right: 20px">
                                        <input name="sticker_new_status" type="radio" <?php if ($m_sticker_new_status == 'enable') { echo 'checked="checked"'; } ?> value="enable" />
                                        <label>Enable</label>
                                    </p>
                                    <p style="overflow: hidden;float: left;">
                                        <input name="sticker_new_status" type="radio" <?php if ($m_sticker_new_status == 'disable') { echo 'checked="checked"'; } ?> value="disable" />
                                        <label>Disable</label>
                                    </p>
                                </td>
                            </tr>
                        <!-- new sticker status -->

                        <!-- new sticker position -->
                        <tr class="dataTableHeadingRow">
                            <td class="dataTableHeadingContent">CHOOSE STICKER "NEW" POSITION BELOW</td>
                        </tr>
                        <tr>
                            <td class="dataTableContent">
                                <div style="margin: 10px 0px 10px 0px">
                                    <select id="sticker_new_position" name="sticker_new_position" data-active="<?php echo $m_sticker_new_position; ?>">
                                        <option value="left_top">Left Top</option>
                                        <option value="right_top">Right Top</option>
                                        <option value="right_bottom">Right Bottom</option>
                                        <option value="left_bottom">Left Bottom</option>
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <!-- new sticker position -->

<!-- END STICKER NEW -->


<!-- STICKER SALE -->
                        <!-- sale sticker status -->
                        <tr class="dataTableHeadingRow">
                            <td class="dataTableHeadingContent">CHOOSE SHOW OR NOT STICKER "SALE" BELOW</td>
                        </tr>
                        <tr>
                            <td class="dataTableContent">
                                <p style="overflow: hidden;float: left;margin-right: 20px">
                                    <input name="sticker_sale_status" type="radio" <?php if ($m_sticker_sale_status == 'enable') { echo 'checked="checked"'; } ?> value="enable" />
                                    <label>Enable</label>
                                </p>
                                <p style="overflow: hidden;float: left;">
                                    <input name="sticker_sale_status" type="radio" <?php if ($m_sticker_sale_status == 'disable') { echo 'checked="checked"'; } ?> value="disable" />
                                    <label>Disable</label>
                                </p>
                            </td>
                        </tr>
                        <!-- sale sticker status -->

                        <!-- sale sticker position -->
                        <tr class="dataTableHeadingRow">
                            <td class="dataTableHeadingContent">CHOOSE STICKER "SALE" POSITION BELOW</td>
                        </tr>
                        <tr>
                            <td class="dataTableContent">
                                <div style="margin: 10px 0px 10px 0px">
                                    <select id="sticker_sale_position" name="sticker_sale_position" data-active="<?php echo $m_sticker_sale_position; ?>">
                                        <option value="left_top">Left Top</option>
                                        <option value="right_top">Right Top</option>
                                        <option value="right_bottom">Right Bottom</option>
                                        <option value="left_bottom">Left Bottom</option>
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <!-- sale sticker position -->
<!-- END STICKER NEW -->

<!-- STICKER options -->
                        <!-- options sticker status -->
                        <tr class="dataTableHeadingRow">
                            <td class="dataTableHeadingContent">CHOOSE SHOW OR NOT STICKER "OPTIONS" BELOW</td>
                        </tr>
                        <tr>
                            <td class="dataTableContent">
                                <p style="overflow: hidden;float: left;margin-right: 20px">
                                    <input name="sticker_options_status" type="radio" <?php if ($m_sticker_options_status == 'enable') { echo 'checked="checked"'; } ?> value="enable" />
                                    <label>Enable</label>
                                </p>
                                <p style="overflow: hidden;float: left;">
                                    <input name="sticker_options_status" type="radio" <?php if ($m_sticker_options_status == 'disable') { echo 'checked="checked"'; } ?> value="disable" />
                                    <label>Disable</label>
                                </p>
                            </td>
                        </tr>
                        <!-- options sticker status -->

                        <!-- options sticker position -->
                        <tr class="dataTableHeadingRow">
                            <td class="dataTableHeadingContent">CHOOSE STICKER "OPTIONS" POSITION BELOW</td>
                        </tr>
                        <tr>
                            <td class="dataTableContent">
                                <div style="margin: 10px 0px 10px 0px">
                                    <select id="sticker_options_position" name="sticker_options_position" data-active="<?php echo $m_sticker_options_position; ?>">
                                        <option value="left_top">Left Top</option>
                                        <option value="right_top">Right Top</option>
                                        <option value="right_bottom">Right Bottom</option>
                                        <option value="left_bottom">Left Bottom</option>
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <!-- options sticker position -->
<!-- END options options -->




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

        <script type="text/javascript">
            jQuery(function() {
                jQuery("#sticker_new_position").val(jQuery("#sticker_new_position").data("active")).attr('selected', true);
                jQuery("#sticker_sale_position").val(jQuery("#sticker_sale_position").data("active")).attr('selected', true);
                jQuery("#sticker_options_position").val(jQuery("#sticker_options_position").data("active")).attr('selected', true);


            });
        </script>


<?php
  require(DIR_WS_INCLUDES . 'template_bottom.php');
  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>
