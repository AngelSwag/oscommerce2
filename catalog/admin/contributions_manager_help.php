<?php
/*
  $Id: contributions_manager_help.php,v 1.0 20014/06/06 10:58:19 Shawn Mulligan Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');

  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_CONTRIBUTIONS_MANAGER_HELP);
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo HELP_PAGE_TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
</head>
<style type="text/css"><!--
BODY { margin-bottom: 10px; margin-left: 10px; margin-right: 10px; margin-top: 10px; }
//--></style>
<body marginwidth="10" marginheight="10" topmargin="10" bottommargin="10" leftmargin="10" rightmargin="10">
<?php echo HELP_TITLE; ?>
<?php echo AUTHOR; ?>
<?php echo TEXT_HELP_SUPPORT; ?>

       <table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent" align="center">How to ... ?</td>
	</tr>
	</table>
	</td></tr>
	<tr>
        <td width="100%" class="dataTableContent">
<?php echo TEXT_HELP_OSCID . TEXT_HELP_FORUM_REF . TEXT_HELP_STATUS . TEXT_HELP_STATUS_EXAMPLE . TEXT_HELP_COMMENTS . TEXT_HELP_NOTE; ?>
       </td>
         </tr>
        </table>
<p class="smallText" align="right"><?php echo '<a href="javascript:window.close()">' . TEXT_CLOSE_WINDOW . '</a>'; ?></p>

</body>
</html>
<?php require('includes/application_bottom.php'); ?>