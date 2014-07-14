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
            <td class="pageHeading">Theme Skin Changing</td>
            <td class="pageHeading" align="right"><?php echo tep_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>

        <?php
        $check = tep_db_query("select * from `buyshop_theme` ");
        if (isset($_POST['color'])) {
            $themecolor = $_POST['color'];


        if (tep_db_num_rows($check) == 0) {
            tep_db_query("INSERT INTO `buyshop_theme` (`color_value`) VALUES ('$themecolor')");
        } else {
            tep_db_query("UPDATE `buyshop_theme` SET  `color_value` =  '$themecolor' ");
        }

        echo '<tr><td class="dataTableHeadingContent" style="color:#000;font-size: 11px">Your theme color was set to '.$themecolor.'!</td></tr>';
            ?>
            <tr><td>
            <a href="theme_color.php" style="float: right;margin-top: 10px" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary ui-priority-secondary" role="button" aria-disabled="false">
                <span class="ui-button-icon-primary ui-icon ui-icon-triangle-1-w"></span>
                <span class="ui-button-text">Back</span>
            </a>
            </td></tr>
            <?php

        } else {


            $new_page_query = tep_db_query("select color_value  from `buyshop_theme` ");
            $new_output = tep_db_fetch_array($new_page_query);
            $m_themecolor = $new_output['color_value'];

        ?>



      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent">CHOOSE THEME OPTIONS BELOW</td>
              </tr>

                <td class="dataTableContent">
                    <!-- FORM CHOOSE THEME COLOR -->
                    <form name="theme_color" action="theme_color.php" method="post">
                         <div id="theme_color_container" style="overflow: hidden">
                             <!-- theme skins -->
                             <div id="skin_container">
                                 <p style="overflow: hidden;float: left;margin-right: 20px">
                                    <input name="color" type="radio" <?php if ($m_themecolor == 'light') { echo 'checked="checked"'; } ?> value="light" />
                                    <label>light</label>
                                </p>
                                <p style="overflow: hidden;float: left;">
                                    <input name="color" type="radio" <?php if ($m_themecolor == 'dark') { echo 'checked="checked"'; } ?> value="dark" />
                                    <label>dark</label>
                                </p>
                            </div>
                             <!-- end theme skins -->
                             <button style="float: right;margin-top: 10px" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary ui-priority-primary" type="submit">
                                <span class="ui-button-icon-primary ui-icon ui-icon-disk"></span>
                                <span class="ui-button-text">Save</span>
                            </button>
                        </div>
                    </form>
                    <!-- FORM CHOOSE THEME COLOR -->


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
