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
                <td class="pageHeading">Slider Type Changing</td>
                <td class="pageHeading" align="right"><?php echo tep_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
            </tr>
        </table></td>
    </tr>

    <?php
    $check = tep_db_query("select * from `buyshop_theme` ");
    if (isset($_POST['slider'])) {
        $themeslider = $_POST['slider'];


        if (tep_db_num_rows($check) == 0) {
            tep_db_query("INSERT INTO `buyshop_theme` (`slider_type`) VALUES ('$themeslider')");
        } else {
            tep_db_query("UPDATE `buyshop_theme` SET  `slider_type` =  '$themeslider' ");
        }

        echo '<tr><td class="dataTableHeadingContent" style="color:#000;font-size: 11px">Top slider type was set to '.$themeslider.'!</td></tr>';
        ?>
        <tr><td>
            <a href="slider_type.php" style="float: right;margin-top: 10px" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary ui-priority-secondary" role="button" aria-disabled="false">
                <span class="ui-button-icon-primary ui-icon ui-icon-triangle-1-w"></span>
                <span class="ui-button-text">Back</span>
            </a>
        </td></tr>
        <?php

    } else {

        $new_page_query = tep_db_query("select slider_type  from `buyshop_theme` ");
        $new_output = tep_db_fetch_array($new_page_query);
        $m_slidertype = $new_output['slider_type'];

        ?>



        <tr>
            <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
                <tr>
                    <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                        <tr class="dataTableHeadingRow">
                            <td class="dataTableHeadingContent">CHOOSE SLIDER TYPE BELOW</td>
                        </tr>

                        <td class="dataTableContent">
                            <!-- FORM CHOOSE SLIDER TYPE -->
                            <form name="theme_color" action="slider_type.php" method="post">
                                <div style="overflow: hidden">
                                    <p style="overflow: hidden;float: left;margin-right: 20px">
                                        <input name="slider" <?php if ($m_slidertype == 'layerslider') { echo 'checked="checked"'; } ?> type="radio" value="layerslider" />
                                        <label>LayerSlider</label>
                                    </p>
                                    <p style="overflow: hidden;float: left;">
                                        <input name="slider" <?php if ($m_slidertype == 'simple') { echo 'checked="checked"'; } ?> type="radio" value="simple" />
                                        <label>Simple Slider</label>
                                    </p>
                                    <button style="float: right;margin-top: 10px" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary ui-priority-primary" type="submit">
                                        <span class="ui-button-icon-primary ui-icon ui-icon-disk"></span>
                                        <span class="ui-button-text">Save</span>
                                    </button>
                                </div>
                            </form>
                            <!-- FORM CHOOSE SLIDER TYPE -->


                        </td>

                        </tr>
                    </table></td>
                </tr>
            </table></td>
        </tr>



        <?php } ?>

</table>







<?php
require(DIR_WS_INCLUDES . 'template_bottom.php');
require(DIR_WS_INCLUDES . 'application_bottom.php');
?>
