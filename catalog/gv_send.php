<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2014 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');
  require('includes/classes/http_client.php');

// if the customer is not logged on, redirect them to the login page
  if (!tep_session_is_registered('customer_id')) {
    $navigation->set_snapshot();
    tep_redirect(tep_href_link(FILENAME_LOGIN, '', 'SSL'));
  }

  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_GV_SEND);

if (($HTTP_POST_VARS['back_x']) || ($HTTP_POST_VARS['back_y'])) {
    $HTTP_GET_VARS['action'] = '';
  }
  if ($HTTP_GET_VARS['action'] == 'send') {
    $error = false;
    if (!tep_validate_email(trim($HTTP_POST_VARS['email']))) {
      $error = true;
      $error_email = ERROR_ENTRY_EMAIL_ADDRESS_CHECK;
    }
    $gv_query = tep_db_query("select amount from " . TABLE_COUPON_GV_CUSTOMER . " where customer_id = '" . $customer_id . "'");
    $gv_result = tep_db_fetch_array($gv_query);
    $customer_amount = $gv_result['amount'];
    $gv_amount = trim($HTTP_POST_VARS['amount']);
    // if (preg_match('/^0-9/', $gv_amount)) {
      // $error = true;
      // $error_amount = ERROR_ENTRY_AMOUNT_CHECK; 
    // }
    // if ($gv_amount>$customer_amount || $gv_amount == 0) {
      // $error = true; 
      // $error_amount = ERROR_ENTRY_AMOUNT_CHECK; 
    // } 
  }
  if ($HTTP_GET_VARS['action'] == 'process') {
    $id1 = create_coupon_code($mail['customers_email_address']);
    $gv_query = tep_db_query("select amount from " . TABLE_COUPON_GV_CUSTOMER . " where customer_id='".$customer_id."'");
    $gv_result = tep_db_fetch_array($gv_query);
    $new_amount = 10;//$gv_result['amount'] - $HTTP_POST_VARS['amount'];
    if ($new_amount < 0) {
      $error= true;
      $error_amount = ERROR_ENTRY_AMOUNT_CHECK; 
      $HTTP_GET_VARS['action'] = 'send';
    } else {
      $gv_query=tep_db_query("update " . TABLE_COUPON_GV_CUSTOMER . " set amount = '" . $new_amount . "' where customer_id = '" . $customer_id . "'");
      $gv_query=tep_db_query("select customers_firstname, customers_lastname from " . TABLE_CUSTOMERS . " where customers_id = '" . $customer_id . "'");
      $gv_customer=tep_db_fetch_array($gv_query);
      $gv_query=tep_db_query("insert into " . TABLE_COUPONS . " (coupon_type, coupon_code, date_created, coupon_amount) values ('G', '" . $id1 . "', NOW(), '" . $HTTP_POST_VARS['amount'] . "')");
      $insert_id = tep_db_insert_id();
      $gv_query=tep_db_query("insert into " . TABLE_COUPON_EMAIL_TRACK . " (coupon_id, customer_id_sent, sent_firstname, sent_lastname, emailed_to, date_sent) values ('" . $insert_id . "' ,'" . $customer_id . "', '" . addslashes($gv_customer['customers_firstname']) . "', '" . addslashes($gv_customer['customers_lastname']) . "', '" . $HTTP_POST_VARS['email'] . "', now())");

      $gv_email = STORE_NAME . "\n" .
              EMAIL_SEPARATOR . "\n" .
              sprintf(EMAIL_GV_TEXT_HEADER, $currencies->format($HTTP_POST_VARS['amount'])) . "\n" .
              EMAIL_SEPARATOR . "\n" . 
              sprintf(EMAIL_GV_FROM, stripslashes($HTTP_POST_VARS['send_name'])) . "\n";
      if (isset($HTTP_POST_VARS['message'])) {
        $gv_email .= EMAIL_GV_MESSAGE . "\n";
        if (isset($HTTP_POST_VARS['to_name'])) {
          $gv_email .= sprintf(EMAIL_GV_SEND_TO, stripslashes($HTTP_POST_VARS['to_name'])) . "\n\n";
        }
        $gv_email .= stripslashes($HTTP_POST_VARS['message']) . "\n\n";
      } 
      $gv_email .= sprintf(EMAIL_GV_REDEEM, $id1) . "\n\n";
      $gv_email .= EMAIL_GV_LINK . tep_href_link(FILENAME_GV_REDEEM, 'gv_no=' . $id1,'NONSSL',false);;
      $gv_email .= "\n\n";  
      $gv_email .= EMAIL_GV_FIXED_FOOTER . "\n\n";
      $gv_email .= EMAIL_GV_SHOP_FOOTER . "\n\n";;
      $gv_email_subject = sprintf(EMAIL_GV_TEXT_SUBJECT, stripslashes($HTTP_POST_VARS['send_name']));             
      tep_mail('', $HTTP_POST_VARS['email'], $gv_email_subject, nl2br($gv_email), STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS, '');
    }
  }

  $breadcrumb->add(NAVBAR_TITLE, tep_href_link(FILENAME_GV_SEND));

  require(DIR_WS_INCLUDES . 'template_top.php');
?>

<h1><?php echo HEADING_TITLE; ?></h1>

<?php

  if (isset($HTTP_GET_VARS['action']) && ($HTTP_GET_VARS['action'] == 'success')) {
?>

<div class="contentContainer">
  <div class="contentText">
    <?php echo TEXT_SUCCESS; ?>
  </div>

  <div style="float: right;">
    <?php echo tep_draw_button(IMAGE_BUTTON_CONTINUE, 'triangle-1-e', tep_href_link(FILENAME_DEFAULT)); ?>
  </div>
</div>

<?php
  }
?>

<?php
var_dump($error);
  if ($HTTP_GET_VARS['action'] == 'send' && !$error) {
    // validate entries
      $gv_amount = (double) $gv_amount;
      $gv_query = tep_db_query("select customers_firstname, customers_lastname from " . TABLE_CUSTOMERS . " where customers_id = '" . $customer_id . "'");
      $gv_result = tep_db_fetch_array($gv_query);
      $send_name = $gv_result['customers_firstname'] . ' ' . $gv_result['customers_lastname'];

	  echo tep_draw_form('gv_send', tep_href_link(FILENAME_GV_SEND, 'action=process'), 'post', '', true);
	  
?>

<div class="contentContainer">
  <div class="contentText">
	<table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td class="main"><?php echo sprintf(MAIN_MESSAGE, $currencies->format($HTTP_POST_VARS['amount']), stripslashes($HTTP_POST_VARS['to_name']), $HTTP_POST_VARS['email'], stripslashes($HTTP_POST_VARS['to_name']), $currencies->format($HTTP_POST_VARS['amount']), $send_name); ?></td>
      </tr>
 <?php
      if ($HTTP_POST_VARS['message']) {
?>
      <tr>
        <td class="main"><?php echo sprintf(PERSONAL_MESSAGE, $gv_result['customers_firstname']); ?></td>
      </tr>
	  <tr>
        <td class="main"><?php echo stripslashes($HTTP_POST_VARS['message']); ?></td>
      </tr>
<?php
      }

      echo tep_draw_hidden_field('send_name', $send_name) . tep_draw_hidden_field('to_name', stripslashes($HTTP_POST_VARS['to_name'])) . tep_draw_hidden_field('email', $HTTP_POST_VARS['email']) . tep_draw_hidden_field('amount', $gv_amount) . tep_draw_hidden_field('message', stripslashes($HTTP_POST_VARS['message']));
?>
    </table>
  </div>
	
  <div class="buttonSet">
    <span class="buttonAction"><?php echo tep_draw_button(IMAGE_BUTTON_CONTINUE, 'triangle-1-e', null, 'primary'); ?></span>
  </div>
</div> 

<?php
  } elseif ($HTTP_GET_VARS['action']== '' || $error) {
?>

<?php echo tep_draw_form('gv_send', tep_href_link(FILENAME_GV_SEND, 'action=send'), 'post', '', true); ?>

<div class="contentContainer">
  <div class="contentText">
	<table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td class="main" colspan=2><?php echo HEADING_TEXT; ?></td>
      </tr>
      <tr>
        <td class="fieldKey"><?php echo ENTRY_NAME; ?></td>
        <td class="fieldValue"><?php echo tep_draw_input_field('to_name'); ?></td>
      </tr>
      <tr>
        <td class="fieldKey"><?php echo ENTRY_EMAIL; ?></td>
        <td class="fieldValue"><?php echo tep_draw_input_field('email'); if ($error) echo $error_email;?></td>
      </tr>
      <tr>
        <td class="fieldKey"><?php echo ENTRY_AMOUNT; ?></td>
        <td class="fieldValue"><?php echo tep_draw_input_field('amount'); if ($error) echo $error_amount;?></td>
      </tr>
      <tr>
        <td class="fieldKey" valign="top"><?php echo ENTRY_MESSAGE; ?></td>
        <td class="fieldValue"><?php echo tep_draw_textarea_field('message', 'soft', 50, 15); ?></td>
      </tr>
    </table>
  </div>
 
  <div class="buttonSet">
    <span class="buttonAction"><?php echo tep_draw_button(IMAGE_BUTTON_CONTINUE, 'triangle-1-e', null, 'primary'); ?></span>
  </div>
</div>
<?php
  }
?>
</form>

<?php

  require(DIR_WS_INCLUDES . 'template_bottom.php');
  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>