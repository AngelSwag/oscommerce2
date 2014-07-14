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
            <td class="pageHeading">Theme Color Changing</td>
            <td class="pageHeading" align="right"><?php echo tep_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>

        <?php
        $check = tep_db_query("select * from `buyshop_theme` ");
        if (isset($_POST['option_themecolor']) || isset($_POST['option_textcolor']) || isset($_POST['option_linkcolor']) || isset($_POST['option_linkhovercolor']) || isset($_POST['option_bgcolor']) || isset($_POST['option_captions_text_color'])) {
            $option_themecolor = $_POST['option_themecolor'];
            $option_textcolor = $_POST['option_textcolor'];
            $option_linkcolor = $_POST['option_linkcolor'];
            $option_linkhovercolor = $_POST['option_linkhovercolor'];
            $option_bgcolor = $_POST['option_bgcolor'];
            $option_captions_text_color = $_POST['option_captions_text_color'];

            $option_captions_text_google = $_POST['option_captions_text_google'];


            if (tep_db_num_rows($check) == 0) {
                tep_db_query("INSERT INTO `buyshop_theme` (`option_themecolor`, `option_textcolor`, `option_linkcolor`, `option_linkhovercolor`, `option_bgcolor`, `option_captions_text_color`, `option_captions_text_google` ) VALUES ('$option_themecolor', '$option_textcolor', '$option_linkcolor', '$option_linkhovercolor', '$option_bgcolor', '$option_captions_text_color', '$option_captions_text_google' )");
        } else {
                tep_db_query("UPDATE `buyshop_theme` SET `option_themecolor` = '$option_themecolor', `option_textcolor` =  '$option_textcolor', `option_linkcolor` =  '$option_linkcolor', `option_linkhovercolor` =  '$option_linkhovercolor', `option_bgcolor` =  '$option_bgcolor', `option_captions_text_color` =  '$option_captions_text_color', `option_captions_text_google` =  '$option_captions_text_google' ");
        }

            echo '<tr><td class="dataTableHeadingContent" style="color:#000;font-size: 11px">Options were set!</td></tr>';
            ?>
            <tr><td>
            <a href="general_options_themecolor.php" style="float: right;margin-top: 10px" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary ui-priority-secondary" role="button" aria-disabled="false">
                <span class="ui-button-icon-primary ui-icon ui-icon-triangle-1-w"></span>
                <span class="ui-button-text">Back</span>
            </a>
            </td></tr>
            <?php

        } else {

            $check = tep_db_query("select * from `buyshop_theme` ");

            $new_page_query = tep_db_query("select option_themecolor, option_textcolor, option_linkcolor, option_linkhovercolor, option_bgcolor, option_captions_text_color, option_captions_text_google  from `buyshop_theme` ");
            $new_output = tep_db_fetch_array($new_page_query);

            $m_option_themecolor = $new_output['option_themecolor'];
            $m_option_textcolor = $new_output['option_textcolor'];
            $m_option_linkcolor = $new_output['option_linkcolor'];
            $m_option_linkhovercolor = $new_output['option_linkhovercolor'];
            $m_option_bgcolor = $new_output['option_bgcolor'];
            $m_option_captions_text_color = $new_output['option_captions_text_color'];
            $m_option_captions_text_google = $new_output['option_captions_text_google'];
?>



      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top">

                <!-- FORM CHOOSE THEME COLOR -->
                <form name="general_options_themecolor" action="general_options_themecolor.php" method="post">
                    <table border="0" width="100%" cellspacing="0" cellpadding="2">

<!-- theme color -->
                            <tr class="dataTableHeadingRow">
                                <td class="dataTableHeadingContent">CHOOSE THEME COLOR BELOW</td>
                            </tr>
                            <tr>
                                <td class="dataTableContent">
                                    <div style="margin: 10px 0px 10px 0px"><input id="option_themecolor" type="color" name="option_themecolor" value="<?php echo $m_option_themecolor; ?>" data-hex="true" class="color" /></div>
                                </td>
                            </tr>
<!-- theme color -->

<!-- text color -->
                        <tr class="dataTableHeadingRow">
                            <td class="dataTableHeadingContent">CHOOSE TEXT COLOR BELOW</td>
                        </tr>
                        <tr>
                            <td class="dataTableContent">
                                <div style="margin: 10px 0px 10px 0px"><input id="option_textcolor" type="color" name="option_textcolor" value="<?php echo $m_option_textcolor; ?>" data-hex="true" class="color" /></div>
                            </td>
                        </tr>
<!-- text color -->

<!-- option_linkcolor color -->
                        <tr class="dataTableHeadingRow">
                            <td class="dataTableHeadingContent">CHOOSE LINKS COLOR BELOW</td>
                        </tr>
                        <tr>
                            <td class="dataTableContent">
                                <div style="margin: 10px 0px 10px 0px"><input id="option_linkcolor" type="color" name="option_linkcolor" value="<?php echo $m_option_linkcolor; ?>" data-hex="true" class="color" /></div>
                            </td>
                        </tr>
<!-- option_linkcolor color -->

<!-- option_linkhovercolor -->
                        <tr class="dataTableHeadingRow">
                            <td class="dataTableHeadingContent">CHOOSE LINKS HOVER COLOR BELOW</td>
                        </tr>
                        <tr>
                            <td class="dataTableContent">
                                <div style="margin: 10px 0px 10px 0px"><input id="option_linkhovercolor" type="color" name="option_linkhovercolor" value="<?php echo $m_option_linkhovercolor; ?>" data-hex="true" class="color" /></div>
                            </td>
                        </tr>
<!-- option_linkhovercolor -->

<!-- bg color -->
                            <tr class="dataTableHeadingRow">
                                <td class="dataTableHeadingContent">CHOOSE BG COLOR BELOW</td>
                            </tr>
                            <tr>
                                <td class="dataTableContent">
                                    <div style="margin: 10px 0px 10px 0px"><input id="option_bgcolor" type="color" name="option_bgcolor" value="<?php echo $m_option_bgcolor; ?>" data-hex="true" class="color" /></div>
                                </td>
                            </tr>
<!-- bg color -->

<!-- option_captions_text_color -->
                        <tr class="dataTableHeadingRow">
                            <td class="dataTableHeadingContent">CHOOSE CAPTIONS TEXT COLOR BELOW</td>
                        </tr>
                        <tr>
                            <td class="dataTableContent">
                                <div style="margin: 10px 0px 10px 0px"><input id="option_captions_text_color" type="color" name="option_captions_text_color" value="<?php echo $m_option_captions_text_color; ?>" data-hex="true" class="color" /></div>
                            </td>
                        </tr>
<!-- option_captions_text_color -->

                        <!-- option_captions_google font -->
                        <tr class="dataTableHeadingRow">
                            <td class="dataTableHeadingContent">CHOOSE CAPTIONS FONT TYPE BELOW</td>
                        </tr>
                        <tr>
                            <td class="dataTableContent">
                                <div style="margin: 10px 0px 10px 0px">
                                    <select id="option_captions_text_google" name="option_captions_text_google" data-active="<?php echo $m_option_captions_text_google; ?>">
                                        <option value="Rokkitt">Rokkit</option>
                                        <option value="Oswald">Oswald</option>
                                        <option value="Allan">Allan</option>
                                        <option value="Allerta">Allerta</option>
                                        <option value="Amaranth">Amaranth</option>
                                        <option value="Anton">Anton</option>
                                        <option value="Arimo">Arimo</option>
                                        <option value="Artifika">Artifika</option>
                                        <option value="Arvo">Arvo</option>
                                        <option value="Asset">Asset</option>
                                        <option value="Astloch">Astloch</option>
                                        <option value="Bangers">Bangers</option>
                                        <option value="Bentham">Bentham</option>
                                        <option value="Bevan">Bevan</option>
                                        <option value="Cabin">Cabin</option>
                                        <option value="Calligraffitti">Calligraffitti</option>
                                        <option value="Candal">Candal</option>
                                        <option value="Cantarell">Cantarell</option>
                                        <option value="Cardo">Cardo</option>
                                        <option value="Coda">Coda</option>
                                        <option value="Crushed">Crushed</option>
                                        <option value="Cuprum">Cuprum</option>
                                        <option value="Damion">Damion</option>
                                        <option value="Forum">Forum</option>
                                        <option value="Geo">Geo</option>
                                        <option value="Gruppo">Gruppo</option>
                                        <option value="Inconsolata">Inconsolata</option>
                                        <option value="Judson">Judson</option>
                                        <option value="Jura">Jura</option>
                                        <option value="Kameron">Kameron</option>
                                        <option value="Kenia">Kenia</option>
                                        <option value="Kranky">Kranky</option>
                                        <option value="Kreon">Kreon</option>
                                        <option value="Kristi">Kristi</option>
                                        <option value="Lekton">Lekton</option>
                                        <option value="Limelight">Limelight</option>
                                        <option value="Lobster">Lobster</option>
                                        <option value="Lora">Lora</option>
                                        <option value="Mako">Mako</option>
                                        <option value="MedievalSharp">MedievalSharp</option>
                                        <option value="Megrim">Megrim</option>
                                        <option value="Merriweather">Merriweather</option>
                                        <option value="Metrophobic">Metrophobic</option>
                                        <option value="Michroma">Michroma</option>
                                        <option value="Monofett">Monofett</option>
                                        <option value="Neucha">Neucha</option>
                                        <option value="Neuton">Neuton</option>
                                        <option value="Orbitron">Orbitron</option>
                                        <option value="Oswald">Oswald</option>
                                        <option value="Pacifico">Pacifico</option>
                                        <option value="Philosopher">Philosopher</option>
                                        <option value="Play">Play</option>
                                        <option value="Puritan">Puritan</option>
                                        <option value="Quattrocento">Quattrocento</option>
                                        <option value="Radley">Radley</option>
                                        <option value="Rokkitt">Rokkitt</option>
                                        <option value="Schoolbell">Schoolbell</option>
                                        <option value="Slackey">Slackey</option>
                                        <option value="Smythe">Smythe</option>
                                        <option value="Sunshiney">Sunshiney</option>
                                        <option value="Syncopate">Syncopate</option>
                                        <option value="Tangerine">Tangerine</option>
                                        <option value="Ubuntu">Ubuntu</option>
                                        <option value="Ultra">Ultra</option>
                                        <option value="Varela">Varela</option>
                                        <option value="Vibur">Vibur</option>
                                        <option value="Wallpoet">Wallpoet</option>
                                        <option value="Zeyada">Zeyada</option>
                                    </select>

                                    <span id="bs_general_font_preview" style="font-size:30px;line-height: 30px; display:block;padding:8px 0 0 0">Lorem Ipsum Dolor</span>

                                </div>
                            </td>
                        </tr>
                        <!-- option_captions_text_color -->



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

        //set active font
        jQuery("#option_captions_text_google").val($("#option_captions_text_google").data("active")).attr('selected', true);

    });
</script>




<?php
  require(DIR_WS_INCLUDES . 'template_bottom.php');
  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>
