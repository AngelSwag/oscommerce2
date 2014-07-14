<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');

require('../megastore_theme.php');

$action = (isset($HTTP_GET_VARS['action']) ? $HTTP_GET_VARS['action'] : '');

  if (tep_not_null($action)) {
    switch ($action) {
      case 'save':
        $error = false;

        $background_image = new upload('background_image');
        $background_image->set_extensions('png');
        $background_image->set_destination(DIR_FS_CATALOG_IMAGES.BUYSHOP_THEME.'/');

        if ($background_image->parse()) {
          $background_image->set_filename('background_image.png');

          if ($background_image->save()) {
            $messageStack->add_session(SUCCESS_LOGO_UPDATED, 'success');
          } else {
            $error = true;
          }
        } else {
          $error = true;
        }

        if ($error == false) {
          tep_redirect(tep_href_link('background_image.php'));
        }
        break;
    }
  }

  if (!tep_is_writable(DIR_FS_CATALOG_IMAGES)) {
    $messageStack->add(sprintf(ERROR_IMAGES_DIRECTORY_NOT_WRITEABLE, tep_href_link(FILENAME_SEC_DIR_PERMISSIONS)), 'error');
  }

  require(DIR_WS_INCLUDES . 'template_top.php');
?>

    <table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td width="100%"><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo tep_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo tep_image(HTTP_CATALOG_SERVER . DIR_WS_CATALOG_IMAGES .BUYSHOP_THEME. '/background_image.png'); ?></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_form('logo', 'background_image.php', 'action=save', 'post', 'enctype="multipart/form-data"'); ?>
          <table border="0" cellspacing="0" cellpadding="2">
            <tr>
              <td class="main" valign="top"><?php echo TEXT_LOGO_IMAGE; ?></td>
              <td class="main"><?php echo tep_draw_file_field('background_image'); ?></td>
              <td class="smallText"><?php echo tep_draw_button(IMAGE_SAVE, 'disk', null, 'primary'); ?></td>
            </tr>
          </table>
        </form>
        </td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td class="main"><?php echo TEXT_FORMAT_AND_LOCATION; ?></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td class="main"><?php echo DIR_FS_CATALOG_IMAGES . BUYSHOP_THEME.'/background_image.png'; ?></td>
      </tr>
    </table>

<?php
  require(DIR_WS_INCLUDES . 'template_bottom.php');
  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>
