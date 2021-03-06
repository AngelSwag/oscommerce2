<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2013 osCommerce

  Released under the GNU General Public License
*/

  class tp_account {
    var $group = 'account';

    function prepare() {
      global $oscTemplate, $currencies, $customer_id;

	  // Account Section
      $oscTemplate->_data[$this->group]['account'] = array('title' => MY_ACCOUNT_TITLE,
                                                           'links' => array('edit' => array('title' => MY_ACCOUNT_INFORMATION,
                                                                                            'link' => tep_href_link(FILENAME_ACCOUNT_EDIT, '', 'SSL'),
                                                                                            'icon' => 'person'),
                                                                            'address_book' => array('title' => MY_ACCOUNT_ADDRESS_BOOK,
                                                                                                    'link' => tep_href_link(FILENAME_ADDRESS_BOOK, '', 'SSL'),
                                                                                                    'icon' => 'note'),
                                                                            'password' => array('title' => MY_ACCOUNT_PASSWORD,
                                                                                                'link' => tep_href_link(FILENAME_ACCOUNT_PASSWORD, '', 'SSL'),
                                                                                                'icon' => 'key')));
      $oscTemplate->_data[$this->group]['orders'] = array('title' => MY_ORDERS_TITLE,
                                                          'links' => array('history' => array('title' => MY_ORDERS_VIEW,
                                                                                              'link' => tep_href_link(FILENAME_ACCOUNT_HISTORY, '', 'SSL'),
                                                                                              'icon' => 'cart')));

	  // CCGV Section
	  $gv_query = tep_db_query("select amount from " . TABLE_COUPON_GV_CUSTOMER . " where customer_id = '" . (int)$customer_id . "'");
	  $gv_result = tep_db_fetch_array($gv_query);
	 // if ($gv_result['amount'] > 0 ) {
		  $oscTemplate->_data[$this->group]['ccgv'] = array('title' => GIFT_VOUCHER_COUPON,
															'links' => array('history' => array('title' => CCGV_BALANCE .':'.$currencies->format($gv_result['amount']),
																								'icon' => 'tag'),
																	         'send' => array('title' => CCGV_SENDVOUCHER,
																			                    'link' => tep_href_link(FILENAME_GV_SEND, '', 'SSL'),
																								'icon' => 'arrowthick-1-e'),
																	         'faq' => array('title' => CCGV_FAQ,
																			                    'link' => tep_href_link(FILENAME_GV_FAQ, '', 'SSL'),
																								'icon' => 'comment')
																								));
	  //}

	  // Notification Section   
      $oscTemplate->_data[$this->group]['notifications'] = array('title' => EMAIL_NOTIFICATIONS_TITLE,
                                                                 'links' => array('newsletters' => array('title' => EMAIL_NOTIFICATIONS_NEWSLETTERS,
                                                                                                         'link' => tep_href_link(FILENAME_ACCOUNT_NEWSLETTERS, '', 'SSL'),
                                                                                                         'icon' => 'mail-closed'),
                                                                                  'products' => array('title' => EMAIL_NOTIFICATIONS_PRODUCTS,
                                                                                                       'link' => tep_href_link(FILENAME_ACCOUNT_NOTIFICATIONS, '', 'SSL'),
                                                                                                       'icon' => 'heart')));

	
	}

    function build() {
      global $oscTemplate;

      $output = '';

      foreach ( $oscTemplate->_data[$this->group] as $group ) {
        $output .= '<h2>' . $group['title'] . '</h2>' .
                   '<div class="contentText">' .
                   '  <ul class="accountLinkList">';

        foreach ( $group['links'] as $entry ) {
          $output .= '    <li><span class="';

          if ( isset($entry['icon']) ) {
            $output .= ' ui-icon ui-icon-' . $entry['icon'] . ' ';
          }
          // If link was not provided only display the title. Useful for addon integration which do not have a target page
          if ( isset($entry['link']) ) {
            $output .= 'accountLinkListEntry"></span><a href="' . $entry['link'] . '">' . $entry['title'] . '</a></li>';
          } else {
            $output .= 'accountLinkListEntry"></span>' . $entry['title'] . '</li>';
          }          
        }

        $output .= '  </ul>' .
                   '</div>';
      }

      $oscTemplate->addContent($output, $this->group);
    }
  }
?>