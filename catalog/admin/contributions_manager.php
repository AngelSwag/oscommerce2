<?php
/*
   $Id: contributions_manager.php,v 1.0 20014/06/06 10:58:19 Shawn Mulligan Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');
  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_CONTRIBUTIONS_MANAGER);
  require(DIR_WS_FUNCTIONS . '/' . FILENAME_CONTRIBUTIONS_MANAGER);
  
  
  
  $action = (isset($HTTP_GET_VARS['action']) ? $HTTP_GET_VARS['action'] : '');

  if (tep_not_null($action)) {
    switch ($action) {
      case 'setflag':
        if ( ($HTTP_GET_VARS['flag'] == '0') || ($HTTP_GET_VARS['flag'] == '1') || ($HTTP_GET_VARS['flag'] == '2') ) {
          tep_set_contributions_manager_status($HTTP_GET_VARS['cmID'], $HTTP_GET_VARS['flag']);
          $messageStack->add_session(SUCCESS_CONTRIBUTIONS_STATUS_UPDATED, 'success');
        } else {
          $messageStack->add_session(ERROR_UNKNOWN_STATUS_FLAG, 'error');
        }
        tep_redirect(tep_href_link(FILENAME_CONTRIBUTIONS_MANAGER, 'page=' . $HTTP_GET_VARS['page'] . '&cmID=' . $HTTP_GET_VARS['cmID']));
        break;

      case 'setcolumnorder':
          if ($HTTP_GET_VARS['sort_name'] != '') {
          tep_set_contributions_manager_sort_order($HTTP_GET_VARS['sort_name']);
          $messageStack->add_session(SUCCESS_CONTRIBUTIONS_MANAGER_ORDER_UPDATED, 'success');
        } else {
          $messageStack->add_session(ERROR_UNKNOWN_CONTRIBUTIONS_MANAGER_ORDER_UPDATED, 'error');
        }
        tep_redirect(tep_href_link(FILENAME_CONTRIBUTIONS_MANAGER));
        break;


      case 'insert':
      case 'update':
        if (isset($HTTP_POST_VARS['contr_id'])) $contr_id = tep_db_prepare_input($HTTP_POST_VARS['contr_id']);
        $contr_ref = tep_db_prepare_input($HTTP_POST_VARS['contr_ref']);
        $forum_ref = tep_db_prepare_input($HTTP_POST_VARS['forum_ref']);
        $contr_type = tep_db_prepare_input($HTTP_POST_VARS['file_type_id']);
        $contr_name_version = tep_db_prepare_input($HTTP_POST_VARS['contr_name_version']);
        $config_comments = tep_db_prepare_input($HTTP_POST_VARS['config_comments']);
        $status = tep_db_prepare_input($HTTP_POST_VARS['status']);
        $contr_module = $HTTP_POST_VARS['contr_module'];
        $last_update = tep_db_prepare_input($HTTP_POST_VARS['last_update']);
      if ($HTTP_POST_VARS['osC_target_new'] != '') 
	  { 
	  $osC_target = tep_db_prepare_input($HTTP_POST_VARS['osC_target_new']); 
	  } else { 
	  $osC_target = tep_db_prepare_input($HTTP_POST_VARS['osC_target']); 
	  }
	  
        
		
        $contributions_error = false;
        if (empty($contr_name_version)) {
          $messageStack->add(ERROR_CONTRIBUTIONS_NAME_REQUIRED, 'error');
          $contributions_error = true;
        }


        if ($contributions_error == false) {
          $current_time = date('Y-m-d H:i:s');
          $sql_data_array = array('contr_ref' => $contr_ref,
                                  'forum_ref' => $forum_ref,
                                  'contr_type' => $contr_type,
                                  'contr_name_version' => $contr_name_version,
                                  'config_comments' => $config_comments,
                                  'contr_created' => $current_time,
                                  'status' => $status,
								  'contr_module' => $contr_module,
								  'last_update' => $last_update,
                                  'osC_target' => $osC_target);

          if ($action == 'insert') {
            $insert_sql_data = array('contr_last_modified' => $current_time);
            $sql_data_array = array_merge($sql_data_array, $insert_sql_data);
            tep_db_perform(TABLE_CONTRIBUTIONS_MGR, $sql_data_array);
			$contr_id = tep_db_insert_id();
            $messageStack->add_session(SUCCESS_CONTRIBUTIONS_INSERTED, 'success');
          } elseif ($action == 'update') {
            tep_db_perform(TABLE_CONTRIBUTIONS_MGR, $sql_data_array, 'update', "contr_id = '" . (int)$contr_id . "'");
            $messageStack->add_session(SUCCESS_CONTRIBUTIONS_UPDATED, 'success');
          }
          tep_redirect(tep_href_link(FILENAME_CONTRIBUTIONS_MANAGER, (isset($HTTP_GET_VARS['page']) ? 'page=' . $HTTP_GET_VARS['page'] . '&' : '') . 'cmID=' . $contr_id));
        } else {
          $action = 'new';
        }
        break;
      case 'deleteconfirm':
      $contr_id = tep_db_prepare_input($HTTP_GET_VARS['cmID']);
      $contributions_count = tep_count_contributions_manager();
      if($contributions_count >= 2)
      {
         tep_db_query("delete from " . TABLE_CONTRIBUTIONS_MGR . " where contr_id = '" . tep_db_input($contr_id) . "'");
	  $messageStack->add_session(SUCCESS_CONTRIBUTIONS_REMOVED, 'success');
      }else{
	  $messageStack->add_session(ERROR_CONTRIBUTIONS_REMOVED, 'error');
      }
	  tep_redirect(tep_href_link(FILENAME_CONTRIBUTIONS_MANAGER, 'page=' . $HTTP_GET_VARS['page'] ));
      break;
      
      
    }
  }

  require(DIR_WS_INCLUDES . 'template_top.php');
// set sub title
      if ( $HTTP_GET_VARS['action'] == 'readonly') $HEADING_SUB_TITLE = HEADING_SUB_TITLE_READONLY;
      if ( $HTTP_GET_VARS['action'] == 'delete') $HEADING_SUB_TITLE = HEADING_SUB_TITLE_DELETE;
      if ( $HTTP_GET_VARS['action'] == 'edit') $HEADING_SUB_TITLE = HEADING_SUB_TITLE_EDIT;
      if ( $HTTP_GET_VARS['action'] == 'new') $HEADING_SUB_TITLE = HEADING_SUB_TITLE_INSERT;
      if ( $HTTP_GET_VARS['action'] == '') $HEADING_SUB_TITLE = HEADING_SUB_TITLE;

?>

    <table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE . '<font class="smallText"> - ' . $HEADING_SUB_TITLE; ?>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:NewWindow('<? echo FILENAME_CONTRIBUTIONS_MANAGER_HELP ?>','ic','400','600','center','front');"><?php echo tep_image(DIR_WS_IMAGES . 'icon_help.gif', TABLE_HEADING_HELP); ?></a></font></td>
            <td class="pageHeading" align="right"><?php echo tep_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>
<?php


  if ($action == 'new' || $action =='edit') {
  
      if ($HTTP_POST_VARS['contr_type_new'] != '') 
	  { 
	  tep_db_query("insert into " . TABLE_CONTRIBUTIONS_MGR_TYPE . " (type_id, type_name, status) values ('1', '" . $HTTP_POST_VARS['contr_type_new'] . "','1')"); 
	  }
      
	  
  
    $file_type_array = array(array('id' => '', 'text' => TEXT_SELECT_CATEGORY));
    $file_type_query = tep_db_query("select type_name from " . TABLE_CONTRIBUTIONS_MGR_TYPE . " order by type_name");
    while ($file_type = tep_db_fetch_array($file_type_query)) {
      $file_type_array[] = array('id' => $file_type['type_name'],
                                     'text' => $file_type['type_name']);
    }

    $osC_target_array = array(array('id' => '', 'text' => TEXT_SELECT_RELEASE_TARGET));
    $osC_target_query = tep_db_query("select DISTINCT osC_target from " . TABLE_CONTRIBUTIONS_MGR . " WHERE osC_target != '' order by osC_target");
    while ($new_target = tep_db_fetch_array($osC_target_query)) {
      $osC_target_array[] = array('id' => $new_target['osC_target'],
                                     'text' => $new_target['osC_target']);
    }
  
    $form_action = 'insert';

    $parameters = array('contr_id' => '',
                        'contr_ref' => '',
						'forum_ref' => '',
						'contr_module' => '',
						'contr_type' => '',
						'contr_name_version' => '',
						'status' => '',
						'config_comments' => '',
						'last_update' => '', 
						'osC_target' => '');

    $cmInfo = new objectInfo($parameters);

    if (isset($HTTP_GET_VARS['cmID'])) {
      $form_action = 'update';

      $cmID = tep_db_prepare_input($HTTP_GET_VARS['cmID']);

      $contributions_query = tep_db_query("select contr_id, contr_ref, forum_ref, contr_module, contr_type, contr_name_version, status, config_comments, last_update, osC_target from " . TABLE_CONTRIBUTIONS_MGR . " where contr_id = '" . (int)$cmID . "'");
      $contributions = tep_db_fetch_array($contributions_query);

      $cmInfo->objectInfo($contributions);
    } elseif ($HTTP_POST_VARS) {
      $cmInfo->objectInfo($HTTP_POST_VARS);
    }
?>



       <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr><?php echo tep_draw_form('new_contr', FILENAME_CONTRIBUTIONS_MANAGER, (isset($HTTP_GET_VARS['page']) ? 'page=' . $HTTP_GET_VARS['page'] . '&' : '') . 'action=' . $form_action, 'post', 'enctype="multipart/form-data"'); 
	  if ($form_action == 'update') echo tep_draw_hidden_field('contr_id', $cmID); ?>
        <td><table border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td class="main"><?php echo TEXT_CATEGORY; ?></td>
            <td class="main"><?php echo tep_draw_pull_down_menu('file_type_id', $file_type_array, $cmInfo->contr_type); ?><?php echo tep_draw_input_field('contr_type_new', '', 'size=30 maxlength=40'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_CONTRIBUTION_REF . '<br><font size="-2" color=blue>' . TEXT_INSERT_URL . '<br>' . TEXT_LINK_CONTR . '</font>'; ?>&nbsp;</td>
            <td class="main"><?php echo tep_draw_input_field('contr_ref', $cmInfo->contr_ref, 'size=25 maxlength=30'); ?></td>
          </tr>
          <tr>
            <td class="main" valign="top"><?php echo TEXT_NAME_VERSION; ?></td>
            <td class="main"><?php echo tep_draw_input_field('contr_name_version', $cmInfo->contr_name_version, 'size=50 maxlength=255'); ?></td>
          </tr>
          <tr>
            <td class="main" valign="top"><?php echo TEXT_FORUM_REF . '<br><font size="-2" color=blue>' . TEXT_INSERT_URL . '<br>' . TEXT_LINK_FORUM . '</font>'; ?>&nbsp;</td>
            <td class="main"><?php echo tep_draw_input_field('forum_ref', $cmInfo->forum_ref, 'size=50 maxlength=50'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_INFO_LAST_UPDATE . '<br><font size="-2" color=blue>' . TEXT_INSERT_DATE . '</font>'; ?>&nbsp;</td>
            <td class="main"><?php echo tep_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . tep_draw_input_field('last_update', $cmInfo->last_update, 'id="last_update"') . ' <small>(YYYY-MM-DD)</small>'; ?></td>
                </tr>
          <tr>
            <td valign="top" class="main"><?php echo TEXT_INFO_OSC_TARGET . '<br><font size="-2" color=blue>' . TEXT_INSERT_VERSION . '</font>'; ?>&nbsp;</td>
            <td class="main"><?php echo tep_draw_pull_down_menu('osC_target', $osC_target_array, $cmInfo->osC_target); ?><?php echo tep_draw_input_field('osC_target_new','' , 'size=20 maxlength=20'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_CONTR_MODULE; ?></td>
            <td class="main"><?php echo tep_draw_input_field('contr_module', $cmInfo->contr_module, 'size=25 maxlength=255'); ?></td>
          </tr>
          <tr>
            <td valign="top" class="main"><?php echo TEXT_CONFIG_COMMENTS; ?></td>
            <td class="main"><?php echo tep_draw_textarea_field('config_comments', 'soft', '70', '8', ($cmInfo->config_comments)) ; ?></td>
          </tr>
<?php
		  if ( $HTTP_GET_VARS['action'] == 'edit') {


?>                                        
          <tr class="dataTableRow">
            <td class="dataTableContent"><?php echo TEXT_CONFIG_STATUS; ?>&nbsp;</td>
            <td class="dataTableContent"><?php echo tep_draw_input_field('status', $cmInfo->status, 'size=2 maxlength=1'); ?></td>
          </tr>
<?php
}
?>          
        </table>
<script type="text/javascript">
$('#last_update').datepicker({
  dateFormat: 'yy-mm-dd'
});
</script>


        </td>
      </tr>
      
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
          <tr>
            <td class="main"></td>
            <td class="smallText" align="right" valign="top" nowrap><?php echo tep_draw_button(IMAGE_SAVE, 'disk', null, 'primary') . tep_draw_button(IMAGE_CANCEL, 'close', tep_href_link(FILENAME_CONTRIBUTIONS_MANAGER, (isset($HTTP_GET_VARS['page']) ? 'page=' . $HTTP_GET_VARS['page'] . '&' : '') . (isset($HTTP_GET_VARS['cmID']) ? 'cmID=' . $HTTP_GET_VARS['cmID'] : ''))); ?></td>
          </tr>
        </table></td>
      </form></tr>
<?php
  } elseif ($action == 'readonly') {
    $cmID = tep_db_prepare_input($HTTP_GET_VARS['cmID']);

      $contributions_query = tep_db_query("select contr_id, contr_ref, forum_ref, contr_module, contr_type, contr_name_version, status, config_comments, date_status_change, contr_created, contr_last_modified, last_update, osC_target from " . TABLE_CONTRIBUTIONS_MGR . " where contr_id = '" . $HTTP_GET_VARS['cmID'] . "'");
      $contributions = tep_db_fetch_array($contributions_query);
      $cmInfo = new objectInfo($contributions);
      if ($cmInfo->status == '0') $status_desc = IMAGE_ICON_STATUS_GREEN;
      if ($cmInfo->status == '1') $status_desc = IMAGE_ICON_STATUS_RED;      
      if ($cmInfo->status == '2') $status_desc = IMAGE_ICON_STATUS_YELLOW;
      if ($cmInfo->status == '3') $status_desc = IMAGE_ICON_STATUS_YELLOW_LIGHT;
?>
      <tr>
        <td><br><table border="0" cellspacing="0" cellpadding="2" class="formArea" align="center">
          <tr class="dataTableRow">
            <td class="dataTableContent" NOWRAP><b><?php echo TEXT_NAME_VERSION; ?></b></td>
            <td class="formAreaTitle"><b><font color=blue><?php echo $cmInfo->contr_name_version; ?></font></b></td>
          </tr>
          <tr class="dataTableRowOver">
            <td class="dataTableContent" NOWRAP><b><?php echo TEXT_CATEGORY; ?></b></td>
            <td class="dataTableContent"><?php echo $cmInfo->contr_type; ?></td>
          </tr>
          <tr class="dataTableRow">
            <td class="dataTableContent" NOWRAP><b><?php echo TEXT_CONTRIBUTION_REF; ?></b></td>
            <td class="dataTableContent"><?php if ($cmInfo->contr_ref != '') { echo '<a href="' . TEXT_LINK_CONTR . $cmInfo->contr_ref . '" target="_blank" title="' . TEXT_CHECK_UPDATES . '">' . TEXT_LINK_CONTR . $cmInfo->contr_ref; } ?></a></td>
          </tr>
          <tr class="dataTableRowOver">
            <td class="dataTableContent" NOWRAP><b><?php echo TEXT_CONFIG_COMMENTS; ?></b></td>
            <td class="dataTableContent"><?php echo nl2br($cmInfo->config_comments); ?></td>
          </tr>
          <tr class="dataTableRow">
            <td class="dataTableContent" NOWRAP><b><?php echo TEXT_FORUM_REF; ?></b></td>
            <td class="dataTableContent"><?php if ($cmInfo->forum_ref != '') { echo '<a href="' . TEXT_LINK_FORUM . $cmInfo->forum_ref . '" target="_blank" title="' . TEXT_CHECK_FORUM . '">' . TEXT_LINK_FORUM . $cmInfo->forum_ref; } ?></a></td>
          </tr>
          <tr class="dataTableRowOver">
            <td class="dataTableContent" NOWRAP><b><?php echo TEXT_INFO_LAST_UPDATE; ?></b></td>
            <td class="dataTableContent"><?php echo tep_date_short($cmInfo->last_update); ?></td>
          </tr>
          <tr class="dataTableRow">
            <td class="dataTableContent" NOWRAP><b><?php echo TEXT_INFO_OSC_TARGET; ?></b></td>
            <td class="dataTableContent"><?php echo $cmInfo->osC_target; ?></td>
          </tr>
          <tr class="dataTableRowOver">
            <td class="dataTableContent" NOWRAP><b><?php echo TEXT_CONTR_MODULE; ?></b></td>
            <td class="dataTableContent"><?php echo $cmInfo->contr_module; ?></td>
          </tr>
          <tr class="dataTableRow">
            <td class="dataTableContent" NOWRAP><b><?php echo TEXT_INFO_DATE_ADDED; ?></b></td>
            <td class="dataTableContent"><?php echo tep_date_short($cmInfo->contr_created); ?></td>
          </tr>                    
          <tr class="dataTableRowOver">
            <td class="dataTableContent" NOWRAP><b><?php echo TEXT_INFO_LAST_MODIFIED; ?></b></td>
            <td class="dataTableContent"><?php if ($cmInfo->contr_last_modified != '0000-00-00 00:00:00') echo tep_date_short($cmInfo->contr_last_modified); ?></td>
          </tr>                  
          <tr class="dataTableRow">
            <td class="dataTableContent" NOWRAP><b><?php echo TEXT_INFO_STATUS; ?></b></td>
            <td class="dataTableContent"><?php echo $cmInfo->status . ': &nbsp' . ' ' . $status_desc; ?></td>
          </tr>          
          <tr class="dataTableRowOver">
            <td class="dataTableContent" NOWRAP><b><?php echo TEXT_INFO_STATUS_CHANGE; ?></b></td>
            <td class="dataTableContent"><?php if ($cmInfo->date_status_change != '0000-00-00 00:00:00') echo tep_date_short($cmInfo->date_status_change); ?></td>
          </tr>
       </table>
                 
         </td>
      </tr>
      <tr>
            <td align="center" class="main"><br><?php echo '<a href="' . tep_href_link(FILENAME_CONTRIBUTIONS_MANAGER, 'page=' . $HTTP_GET_VARS['page'] . '&cmID=' . $cmInfo->contr_id, 'NONSSL') . '">' . tep_image_button('button_back.gif', IMAGE_BUTTON_BACK) . '</a>'; ?>
        </td>
      </tr>      


<?php
  } else {
?>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent">



<?php
    $contributions_mgr_table_sort_query = "select sort_column_name from " . TABLE_CONTRIBUTIONS_MGR_TABLE_SORT . " where sort_status = 1";
    $contributions_mgr_sort = tep_db_query($contributions_mgr_table_sort_query);
    while ($contributions_mgr_sort_order = tep_db_fetch_array($contributions_mgr_sort)) 
    {
         $order_name_status = $contributions_mgr_sort_order['sort_column_name'];
	  list($column_name, $sort_direction) = explode("-", $order_name_status);
         if($sort_direction == "a")
	  {
	  $order_by = $column_name . " ASC";
	  }else{
      	  $order_by = $column_name . " DESC";
	  }
    }
?>
				<?php 	echo '<a href="' . tep_href_link(FILENAME_CONTRIBUTIONS_MANAGER, 'action=setcolumnorder&sort_name=contr_ref-a', 'NONSSL') . '">' . tep_image(DIR_WS_IMAGES . tep_get_contributions_manager_sort_image('contr_ref-a',$order_name_status), IMAGE_BUTTON_UPSORT) . '</a>&nbsp;'; ?>
				<?php  echo '<a href="' . tep_href_link(FILENAME_CONTRIBUTIONS_MANAGER, 'action=setcolumnorder&sort_name=contr_ref-d', 'NONSSL') . '">' . tep_image(DIR_WS_IMAGES . tep_get_contributions_manager_sort_image('contr_ref-d',$order_name_status), IMAGE_BUTTON_DOWNSORT) . '</a>&nbsp;'; ?> <br><?php echo TEXT_ID; ?></td>
                <td class="dataTableHeadingContent" align="center">
				<?php 	echo '<a href="' . tep_href_link(FILENAME_CONTRIBUTIONS_MANAGER, 'action=setcolumnorder&sort_name=contr_type-a', 'NONSSL') . '">' . tep_image(DIR_WS_IMAGES . tep_get_contributions_manager_sort_image('contr_type-a',$order_name_status), IMAGE_BUTTON_UPSORT) . '</a>&nbsp;'; ?>
				<?php  echo '<a href="' . tep_href_link(FILENAME_CONTRIBUTIONS_MANAGER, 'action=setcolumnorder&sort_name=contr_type-d', 'NONSSL') . '">' . tep_image(DIR_WS_IMAGES . tep_get_contributions_manager_sort_image('contr_type-d',$order_name_status), IMAGE_BUTTON_DOWNSORT) . '</a>&nbsp;'; ?> <br><?php echo TEXT_CATEGORY; ?></td>
                <td class="dataTableHeadingContent" align="center">
				<?php echo '<a href="' . tep_href_link(FILENAME_CONTRIBUTIONS_MANAGER, 'action=setcolumnorder&sort_name=contr_name_version-a', 'NONSSL') . '">' . tep_image(DIR_WS_IMAGES . tep_get_contributions_manager_sort_image('contr_name_version-a',$order_name_status), IMAGE_BUTTON_UPSORT) . '</a>&nbsp;'; ?>
				<?php echo '<a href="' . tep_href_link(FILENAME_CONTRIBUTIONS_MANAGER, 'action=setcolumnorder&sort_name=contr_name_version-d', 'NONSSL') . '">' . tep_image(DIR_WS_IMAGES . tep_get_contributions_manager_sort_image('contr_name_version-d',$order_name_status), IMAGE_BUTTON_DOWNSORT) . '</a>&nbsp;'; ?><br><?php echo TABLE_HEADING_NAME; ?></td>
                <td class="dataTableHeadingContent" align="right">
				<?php echo '<a href="' . tep_href_link(FILENAME_CONTRIBUTIONS_MANAGER, 'action=setcolumnorder&sort_name=forum_ref-a', 'NONSSL') . '">' . tep_image(DIR_WS_IMAGES . tep_get_contributions_manager_sort_image('forum_ref-a',$order_name_status), IMAGE_BUTTON_UPSORT) . '</a>&nbsp;';  ?><?php echo '<a href="' . tep_href_link(FILENAME_CONTRIBUTIONS_MANAGER, 'action=setcolumnorder&sort_name=forum_ref-d', 'NONSSL') . '">' . tep_image(DIR_WS_IMAGES . tep_get_contributions_manager_sort_image('forum_ref-d',$order_name_status), IMAGE_BUTTON_DOWNSORT) . '</a>&nbsp;';  ?>
				<br><?php echo TEXT_FORUM_REF; ?></td>
                <td class="dataTableHeadingContent" align="center"></td>
                <td class="dataTableHeadingContent" align="center">
				<?php echo '<a href="' . tep_href_link(FILENAME_CONTRIBUTIONS_MANAGER, 'action=setcolumnorder&sort_name=status-a', 'NONSSL') . '">' . tep_image(DIR_WS_IMAGES . tep_get_contributions_manager_sort_image('status-a',$order_name_status), IMAGE_BUTTON_UPSORT) . '</a>&nbsp;';  ?><?php echo '<a href="' . tep_href_link(FILENAME_CONTRIBUTIONS_MANAGER, 'action=setcolumnorder&sort_name=status-d', 'NONSSL') . '">' . tep_image(DIR_WS_IMAGES . tep_get_contributions_manager_sort_image('status-d',$order_name_status), IMAGE_BUTTON_DOWNSORT) . '</a>&nbsp;';  ?>
				<br><?php echo TABLE_HEADING_STATUS; ?></td>
                <td class="dataTableHeadingContent" align="right">
				<br><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
<?php
    $contributions_query_raw = "select contr_id, contr_ref, forum_ref, contr_name_version, contr_type, status, contr_created , contr_last_modified , date_status_change , last_update, osC_target from " . TABLE_CONTRIBUTIONS_MGR . " order by " . $order_by;
    $contributions_split = new splitPageResults($HTTP_GET_VARS['page'], MAX_DISPLAY_SEARCH_RESULTS, $contributions_query_raw, $contributions_query_numrows);
    $contributions_query = tep_db_query($contributions_query_raw);
    while ($contributions = tep_db_fetch_array($contributions_query)) {
    if ((!isset($HTTP_GET_VARS['cmID']) || (isset($HTTP_GET_VARS['cmID']) && ($HTTP_GET_VARS['cmID'] == $contributions['contr_id']))) && !isset($cmInfo) && (substr($action, 0, 3) != 'new')) {
        $cmInfo = new objectInfo($contributions);
      }

      if (isset($cmInfo) && is_object($cmInfo) && ($contributions['contr_id'] == $cmInfo->contr_id) ) {
        echo '                  <tr id="defaultSelected" class="dataTableRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . tep_href_link(FILENAME_CONTRIBUTIONS_MANAGER, 'page=' . $HTTP_GET_VARS['page'] . '&cmID=' . $cmInfo->contr_id . '&action=readonly') . '\'">' . "\n";
      } else {
        echo '                  <tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . tep_href_link(FILENAME_CONTRIBUTIONS_MANAGER, 'page=' . $HTTP_GET_VARS['page'] . '&cmID=' . $contributions['contr_id']) . '\'">' . "\n";
      }
?>
                <td class="dataTableContent"><?php echo '<a href="' . TEXT_LINK_CONTR . $contributions['contr_ref'] . '" target="_blank" title="' . TEXT_CHECK_UPDATES . '">' . $contributions['contr_ref']; ?></a>&nbsp;</td>
                <td class="dataTableContent" align="center"><?php echo $contributions['contr_type']; ?></a>&nbsp;</td>
                <td class="dataTableContent" align="center"><?php echo '<a name="' . $contributions['contr_name_version'] . '" title="' . $contributions['contr_type'] . '">' . $contributions['contr_name_version']; ?>&nbsp;</a></td>                                                                
                <td class="dataTableContent" align="right"><?php if ($contributions['forum_ref'] != '') { echo '<a href="' . TEXT_LINK_FORUM . $contributions['forum_ref'] . '" target="_blank" title="' . TEXT_CHECK_FORUM . '">' . TEXT_MORE_INFO; } ?></a>&nbsp;</td>
                <td class="dataTableContent" align="center"></td>
                <td class="dataTableContent" align="center">
				
				<?php
      if ($contributions['status'] == '0') {
                echo tep_image(DIR_WS_IMAGES . 'icon_status_green.gif', IMAGE_ICON_STATUS_GREEN, 10, 10) . '&nbsp;<a href="' . tep_href_link(FILENAME_CONTRIBUTIONS_MANAGER, 'action=setflag&flag=1&page=' . $HTTP_GET_VARS['page'] . '&cmID=' . $contributions['contr_id'], 'NONSSL') . '">' . tep_image(DIR_WS_IMAGES . 'icon_status_red_light.gif', IMAGE_ICON_STATUS_RED_LIGHT, 10, 10) . '</a>&nbsp;<a href="' . tep_href_link(FILENAME_CONTRIBUTIONS_MANAGER, 'action=setflag&flag=2&page=' . $HTTP_GET_VARS['page'] . '&cmID=' . $contributions['contr_id'], 'NONSSL') . '">' . tep_image(DIR_WS_IMAGES . 'icon_status_yellow_light.gif', IMAGE_ICON_STATUS_YELLOW_LIGHT, 10, 10) . '</a>';
      } elseif ($contributions['status'] == '1') {
                       echo '<a href="' . tep_href_link(FILENAME_CONTRIBUTIONS_MANAGER, 'action=setflag&flag=0&page=' . $HTTP_GET_VARS['page'] . '&cmID=' . $contributions['contr_id'], 'NONSSL') . '">' . tep_image(DIR_WS_IMAGES . 'icon_status_green_light.gif', IMAGE_ICON_STATUS_GREEN_LIGHT, 10, 10) . '</a>&nbsp;' . tep_image(DIR_WS_IMAGES . 'icon_status_red.gif', IMAGE_ICON_STATUS_RED, 10, 10) . '</a>&nbsp;<a href="' . tep_href_link(FILENAME_CONTRIBUTIONS_MANAGER, 'action=setflag&flag=2&page=' . $HTTP_GET_VARS['page'] . '&cmID=' . $contributions['contr_id'], 'NONSSL') . '">' . tep_image(DIR_WS_IMAGES . 'icon_status_yellow_light.gif', IMAGE_ICON_STATUS_YELLOW_LIGHT, 10, 10) . '</a>';
      } elseif ($contributions['status'] == '2') {
                       echo '<a href="' . tep_href_link(FILENAME_CONTRIBUTIONS_MANAGER, 'action=setflag&flag=0&page=' . $HTTP_GET_VARS['page'] . '&cmID=' . $contributions['contr_id'], 'NONSSL') . '">' . tep_image(DIR_WS_IMAGES . 'icon_status_green_light.gif', IMAGE_ICON_STATUS_GREEN_LIGHT, 10, 10) . '</a>&nbsp;<a href="' . tep_href_link(FILENAME_CONTRIBUTIONS_MANAGER, 'action=setflag&flag=1&page=' . $HTTP_GET_VARS['page'] . '&cmID=' . $contributions['contr_id'], 'NONSSL') . '">' . tep_image(DIR_WS_IMAGES . 'icon_status_red_light.gif', IMAGE_ICON_STATUS_RED_LIGHT, 10, 10) . '</a>&nbsp;<a href="' . tep_href_link(FILENAME_CONTRIBUTIONS_MANAGER, 'action=setflag&flag=3&page=' . $HTTP_GET_VARS['page'] . '&cmID=' . $contributions['contr_id'], 'NONSSL') . '">' . tep_image(DIR_WS_IMAGES . 'icon_status_yellow.gif', IMAGE_ICON_STATUS_YELLOW, 10, 10) . '</a>';
      } else {
                if ($contributions['status'] == '3')  {
                        echo '<a href="' . tep_href_link(FILENAME_CONTRIBUTIONS_MANAGER, 'action=setflag&flag=0&page=' . $HTTP_GET_VARS['page'] . '&cmID=' . $contributions['contr_id'], 'NONSSL') . '">' . tep_image(DIR_WS_IMAGES . 'icon_status_green_light.gif', IMAGE_ICON_STATUS_GREEN_LIGHT, 10, 10) . '</a>&nbsp;<a href="' . tep_href_link(FILENAME_CONTRIBUTIONS_MANAGER, 'action=setflag&flag=1&page=' . $HTTP_GET_VARS['page'] . '&cmID=' . $contributions['contr_id'], 'NONSSL') . '">' . tep_image(DIR_WS_IMAGES . 'icon_status_red_light.gif', IMAGE_ICON_STATUS_RED_LIGHT, 10, 10) . '</a>&nbsp;<a href="' . tep_href_link(FILENAME_CONTRIBUTIONS_MANAGER, 'action=setflag&flag=2&page=' . $HTTP_GET_VARS['page'] . '&cmID=' . $contributions['contr_id'], 'NONSSL') . '">' . tep_image(DIR_WS_IMAGES . 'icon_status_yellow_light.gif', IMAGE_ICON_STATUS_YELLOW_LIGHT, 10, 10) . '</a>';
                }
      }
?></td>
				
				
				
				
				
				
                <td class="dataTableContent" align="right"><?php if (isset($cmInfo) && is_object($cmInfo) && ($contributions['contr_id'] == $cmInfo->contr_id) ) { echo tep_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', ''); } else { echo '<a href="' . tep_href_link(FILENAME_CONTRIBUTIONS_MANAGER, 'page=' . $HTTP_GET_VARS['page'] . '&cmID=' . $contributions['contr_id']) . '">' . tep_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
              </tr>
<?php
    }
?>
              <tr>
                <td colspan="6"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText" valign="top"><?php echo $contributions_split->display_count($contributions_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, $HTTP_GET_VARS['page'], TEXT_DISPLAY_NUMBER_OF_CONTRIBUTIONS); ?></td>
                    <td class="smallText" align="right"><?php echo $contributions_split->display_links($contributions_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $HTTP_GET_VARS['page']); ?></td>
                  </tr>
                  <tr>
                    <td class="smallText" align="right" colspan="2"><?php echo tep_draw_button(IMAGE_NEW_CONTRIBUTION, 'plus', tep_href_link(FILENAME_CONTRIBUTIONS_MANAGER, 'action=new')); ?></td>
                  </tr>
                </table></td>
              </tr>
            </table></td>
<?php
  $heading = array();
  $contents = array();

  switch ($action) {
    case 'delete':
      $heading[] = array('text' => '<center><b>' . TEXT_INFO_HEADING_DELETE . '</b></center>');
      $contents = array('form' => tep_draw_form('install_contr_del', FILENAME_CONTRIBUTIONS_MANAGER, 'page=' . $HTTP_GET_VARS['page'] . '&cmID=' . $cmInfo->contr_id . '&action=deleteconfirm'));
      $contents[] = array('text' => TEXT_INFO_DELETE_INTRO);
      $contents[] = array('text' => '<br><b>' . $cmInfo->contr_name_version . '</b>');
      $contents[] = array('align' => 'center', 'text' => '<br>' . tep_image_submit('button_delete.gif', IMAGE_DELETE) . '&nbsp;<a href="' . tep_href_link(FILENAME_CONTRIBUTIONS_MANAGER, 'page=' . $HTTP_GET_VARS['page'] . '&cmID=' . $cmInfo->contr_id) . '">' . tep_image_button('button_cancel.gif', IMAGE_CANCEL) . '</a>');
      break;
    default:
      if (is_object($cmInfo)) {
        $heading[] = array('text' => '<center><b>' . $cmInfo->contr_name_version . '</b></center>');
        $contents[] = array('text' => '' . TEXT_INFO_LAST_UPDATE . ': ' . tep_date_short($cmInfo->last_update));
        $contents[] = array('text' => '' . TEXT_INFO_OSC_TARGET . ': <font color=blue>' . $cmInfo->osC_target . '</font>');
        $contents[] = array('text' => '<br>' . TEXT_INFO_DATE_ADDED . ': ' . tep_date_short($cmInfo->contr_created));        
		$contents[] = array('text' => '' . TEXT_INFO_LAST_MODIFIED . ': ' . tep_date_short($cmInfo->contr_last_modified));
        $contents[] = array('align' => 'center', 'text' => '<a href="' . tep_href_link(FILENAME_CONTRIBUTIONS_MANAGER, 'page=' . $HTTP_GET_VARS['page'] . '&cmID=' . $cmInfo->contr_id . '&action=edit') . '">' . tep_image_button('button_edit.gif', IMAGE_EDIT) . '</a> <a href="' . tep_href_link(FILENAME_CONTRIBUTIONS_MANAGER, 'page=' . $HTTP_GET_VARS['page'] . '&cmID=' . $cmInfo->contr_id . '&action=delete') . '">' . tep_image_button('button_delete.gif', IMAGE_DELETE) . '</a><br><br> <a href="' . tep_href_link(FILENAME_CONTRIBUTIONS_MANAGER, 'page=' . $HTTP_GET_VARS['page'] . '&cmID=' . $cmInfo->contr_id . '&action=readonly') . '">' . tep_image_button('button_preview.gif', IMAGE_PREVIEW) . '</a>');
      }
      break;
  }

  if ( (tep_not_null($heading)) && (tep_not_null($contents)) ) {
    echo '            <td width="25%" valign="top">' . "\n";

    $box = new box;
    echo $box->infoBox($heading, $contents);

    echo '            </td>' . "\n";
  }
?>
          </tr>
        </table></td>
      </tr>
<?php
  }
?>
    </table>

<?php
  require(DIR_WS_INCLUDES . 'template_bottom.php');
  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>
