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
            <td class="pageHeading">Custom Product Block content</td>
            <td class="pageHeading" align="right"><?php echo tep_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>


    <?php

        $check = tep_db_query("select * from `custom_product_block` ");

        $languages = tep_db_query("select * from `languages` ");
        $languages_count = tep_db_num_rows($languages);



        if (isset($_POST['menu_block_content1'])) {

            while ($languages_output = tep_db_fetch_array($languages )) {

                $language_number = $languages_output['languages_id'];
                //if (isset($_POST['menu_block_content'.$language_number])) {

                    $menu_block_content = $_POST['menu_block_content'.$language_number];

                    $page_query = tep_db_query("select menu_block_content from `custom_product_block` where `menu_block_id` = '$language_number' ");
                    $page_count = tep_db_num_rows($page_query);
                    if ($page_count > 0) {
                        tep_db_query("UPDATE `custom_product_block` SET  `menu_block_content` =  '$menu_block_content' where `menu_block_id` = '$language_number' ");
                    } else {
                        tep_db_query("INSERT INTO `custom_product_block` (`menu_block_content`, `menu_block_id`) VALUES ('$menu_block_content', '$language_number')  ");
                    }



            }
                //echo '<tr><td class="dataTableHeadingContent" style="color:#000;font-size: 11px">Your page was edited for&nbsp;'.$languages_output['directory'].'!</td></tr>';

            ?>
            <tr>
                <td class="dataTableHeadingContent" style="color:#000;font-size: 11px">
            Changes are done!
                <a href="custom_product_block.php" style="float: right;margin-top: 10px" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary ui-priority-secondary" role="button" aria-disabled="false">
                <span class="ui-button-icon-primary ui-icon ui-icon-triangle-1-w"></span>
                <span class="ui-button-text">Back</span>
            </a>
            </td>
            </tr>
            <?php


        } else {
          ?>

    <form name="menu_block_content_language" action="custom_product_block.php" method="post">


      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent">ENTER ANY CONTENT FOR THE PRODUCT CUSTOM BLOCK BELOW</td>
              </tr>
                <tr>

                <td class="dataTableContent">
                    <!-- FORM CONTENT ENTER -->

                         <div style="overflow: hidden">
                            <p>
                                <?php

            $languages1 = tep_db_query("select * from `languages` ");
            $languages_count = tep_db_num_rows($languages1);




                    while ($languages_output = tep_db_fetch_array($languages1 )) {
                        $language_number = $languages_output['languages_id'];
                                    $new_page_query = tep_db_query("select menu_block_content from `custom_product_block` where `menu_block_id` = '$language_number' ");
                                    $new_output = tep_db_fetch_array($new_page_query);
                                    $m = $new_output['menu_block_content'];


                                    $k = $languages_output['languages_id'];

                                echo '<h2>'.$languages_output['directory'].'</h2>';
                                echo tep_draw_textarea_field('menu_block_content'.$languages_output['languages_id'], 'soft', '70', '15', $m);

                                ?>
                             </p>


                        </div>

                    <?php
                        }



                    ?>


                    <!-- FORM CHOOSE THEME COLOR -->


                </td>

              </tr>

    <button style="float: right;margin-bottom: 10px" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary ui-priority-primary" type="submit">
        <span class="ui-button-icon-primary ui-icon ui-icon-disk"></span>
        <span class="ui-button-text">Save</span>
    </button>

</form>


    <?php } ?>


            </table></td>
          </tr>
        </table></td>
      </tr>






</table>







<?php
  require(DIR_WS_INCLUDES . 'template_bottom.php');
  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>
