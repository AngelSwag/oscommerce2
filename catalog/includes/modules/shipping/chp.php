<?php
/*
  $Id: chp.php,v 1.02 2003/02/18 03:37:00 harley_vb Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 - 2003 osCommerce

  Released under the GNU General Public License

  Patches:
  - tom 001: Prices changed per 27.7.2006

*/

/********************************************************************
*	Copyright (C) 2001 - 2003 TheMedia, Dipl.-Ing Thomas Plänkers
*       http://www.themedia.at & http://www.oscommerce.at
*
*                    All rights reserved
*
* This program is free software licensed under the GNU General Public License (GPL).
*
*    This program is free software; you can redistribute it and/or modify
*    it under the terms of the GNU General Public License as published by
*    the Free Software Foundation; either version 2 of the License, or
*    (at your option) any later version.
*
*    This program is distributed in the hope that it will be useful,
*    but WITHOUT ANY WARRANTY; without even the implied warranty of
*    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
*    GNU General Public License for more details.
*
*    You should have received a copy of the GNU General Public License
*    along with this program; if not, write to the Free Software
*    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307
*    USA
*
*********************************************************************/

  class chp {
    var $code, $title, $description, $icon, $enabled, $num_chp, $types;

// class constructor
    function chp() {
      global $order;

      $this->code         = 'chp';
      $this->title        = MODULE_SHIPPING_CHP_TEXT_TITLE;
      $this->description  = MODULE_SHIPPING_CHP_TEXT_DESCRIPTION;
      $this->sort_order   = MODULE_SHIPPING_CHP_SORT_ORDER;
      $this->icon         = DIR_WS_ICONS . 'shipping_chp.gif';
      $this->tax_class    = MODULE_SHIPPING_CHP_TAX_CLASS;
      $this->enabled      = ((MODULE_SHIPPING_CHP_STATUS == 'True') ? true : false);

      if (   ($this->enabled == true)
          && ((int)MODULE_SHIPPING_CHP_ZONE > 0) ) {
        $check_flag = false;
        $check_query = tep_db_query("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_SHIPPING_CHP_ZONE . "' and zone_country_id = '" . $order->delivery['country']['id'] . "' order by zone_id");
        while ($check = tep_db_fetch_array($check_query)) {
          if ($check['zone_id'] < 1) {
            $check_flag = true;
            break;
          } elseif ($check['zone_id'] == $order->delivery['zone_id']) {
            $check_flag = true;
            break;
          }
        }

        if ($check_flag == false) {
          $this->enabled = false;
        }
      }

      $this->types = array('ECO' => 'Economy',
                           'PRI' => 'Priority');


      // CUSTOMIZE THIS SETTING FOR THE NUMBER OF ZONES NEEDED
      $this->num_chp = 6;   // ch + 5 Zonen
    }

// class methods
    function quote($method = '') {
      global $HTTP_POST_VARS, $order, $shipping_weight, $shipping_num_boxes;

      $dest_country = $order->delivery['country']['iso_code_2'];
      $dest_zone = 0;
      $error = false;

      for ($j=1; $j<=$this->num_chp; $j++) {
        $countries_table = constant('MODULE_SHIPPING_CHP_COUNTRIES_' . $j);
        $country_zones =  preg_split('"[,]"', $countries_table);
        if (in_array($dest_country, $country_zones)) {
          $dest_zone = $j;
          break;
        }
      }

      if ($dest_zone == 0) {
        $error = true;
      } else {
        $shipping = -1;
        $chp_cost_eco = @constant('MODULE_SHIPPING_CHP_COST_ECO_' . $j);
        $chp_cost_pri = @constant('MODULE_SHIPPING_CHP_COST_PRI_' . $j);


        $methods = array();

        if ($chp_cost_eco != '') {
          $chp_table_eco =  preg_split('"[:,]"' , $chp_cost_eco);

          for ($i=0; $i<sizeof($chp_table_eco); $i+=2) {
            if ($shipping_weight <= $chp_table_eco[$i]) {
              $shipping_eco = $chp_table_eco[$i+1];
              break;
            }
          }

          if ($shipping_eco == -1) {
            $shipping_cost = 0;
            $shipping_method = MODULE_SHIPPING_CHP_UNDEFINED_RATE;
          } else {
            $shipping_cost_1 = ($shipping_eco + MODULE_SHIPPING_CHP_HANDLING);
          }

          if ($shipping_eco != 0) {
            $methods[] = array('id' => 'ECO',
                               'title' => 'Economy',
                               'cost' => (MODULE_SHIPPING_CHP_HANDLING + $shipping_cost_1) * $shipping_num_boxes);
          }
        }

        if ($chp_cost_pri != '') {
          $chp_table_pri =  preg_split('"[:,]"' , $chp_cost_pri);

          for ($i=0; $i<sizeof($chp_table_pri); $i+=2) {
            if ($shipping_weight <= $chp_table_pri[$i]) {
              $shipping_pri = $chp_table_pri[$i+1];
              break;
            }
          }

          if ($shipping_pri == -1) {
            $shipping_cost = 0;
            $shipping_method = MODULE_SHIPPING_CHP_UNDEFINED_RATE;
          } else {
            $shipping_cost_2 = ($shipping_pri + MODULE_SHIPPING_CHP_HANDLING);
          }

          if ($shipping_pri != 0) {
            $methods[] = array('id' => 'PRI',
                               'title' => 'Priority',
                               'cost' => (MODULE_SHIPPING_CHP_HANDLING + $shipping_cost_2) * $shipping_num_boxes);
          }
        }
      }

      $this->quotes = array('id' => $this->code,
                            'module' => $this->title . ' (' . $shipping_num_boxes . ' x ' . $shipping_weight . ' ' . MODULE_SHIPPING_CHP_TEXT_UNITS .')');
      $this->quotes['methods'] = $methods;

      if ($this->tax_class > 0) {
        $this->quotes['tax'] = tep_get_tax_rate($this->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);
      }

      if (tep_not_null($this->icon)) $this->quotes['icon'] = tep_image($this->icon, $this->title);

      if ($error == true) $this->quotes['error'] = MODULE_SHIPPING_CHP_INVALID_ZONE;

      if ( (tep_not_null($method)) && (isset($this->types[$method])) ) {

        for ($i=0; $i<sizeof($methods); $i++) {
          if ($method == $methods[$i]['id']) {
            $methodsc = array();
            $methodsc[] = array('id' => $methods[$i]['id'],
                                'title' => $methods[$i]['title'],
                                'cost' => $methods[$i]['cost']);
            break;
          }
        }
        $this->quotes['methods'] = $methodsc;
      }

      return $this->quotes;
    }

    function check() {
      if (!isset($this->_check)) {
        $check_query = tep_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_SHIPPING_CHP_STATUS'");
        $this->_check = tep_db_num_rows($check_query);
      }
      return $this->_check;
    }

    function install() {
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Schweizerische Post', 'MODULE_SHIPPING_CHP_STATUS', 'True', 'Wollen Sie den Versand über die schweizerische Post anbieten?', '6', '0', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Bearbeitungsgebühr', 'MODULE_SHIPPING_CHP_HANDLING', '0', 'Bearbeitungsgebühr für diese Versandart in CHF', '6', '0', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('Steuersatz', 'MODULE_SHIPPING_CHP_TAX_CLASS', '0', 'Wählen Sie den MwSt.-Satz für diese Versandart aus.', '6', '0', 'tep_get_tax_class_title', 'tep_cfg_pull_down_tax_classes(', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('Versand Zone', 'MODULE_SHIPPING_CHP_ZONE', '0', 'Wenn Sie eine Zone auswählen, wird diese Versandart nur in dieser Zone angeboten.', '6', '0', 'tep_get_zone_class_title', 'tep_cfg_pull_down_zone_classes(', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Reihenfolge der Anzeige', 'MODULE_SHIPPING_CHP_SORT_ORDER', '0', 'Niedrigste wird zuerst angezeigt.', '6', '0', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Tarifzone 0 Länder', 'MODULE_SHIPPING_CHP_COUNTRIES_1', 'CH,LI', 'Inlandszone', '6', '0', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Tariftabelle für Zone 0 bis 30 kg ECO', 'MODULE_SHIPPING_CHP_COST_ECO_1', '2:6.00,5:8.00,10:11.00,20:16.00,30:23.00', 'Tarif Tabelle für die Inlandszone, basiered auf <b>\'ECO\'</b> bis 30 kg Versandgewicht.', '6', '0', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Tariftabelle für Zone 0 bis 30 kg PRI', 'MODULE_SHIPPING_CHP_COST_PRI_1', '2:8.00,5:10.00,10:13.00,20:19.00,30:26.00', 'Tarif Tabelle für die Inlandszone, basiered auf <b>\'PRI\'</b> bis 30 kg Versandgewicht.', '6', '0', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Tarifzone 1 Länder', 'MODULE_SHIPPING_CHP_COUNTRIES_2', 'AD,AT,BE,FR,DE,VA,IT,LU,MC,NL', 'Durch Komma getrennt Liste der Länder als zwei Zeichen ISO-Code Landeskennzahlen, die Teil der Zone 1 sind.', '6', '0', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Tariftabelle für Zone 1 bis 30 kg ECO', 'MODULE_SHIPPING_CHP_COST_ECO_2', '2:32,3:35,4:38,5:40,6:41,7:42,8:43,9:44,10:45,11:46,12:47,13:48,14:49,15:50,16:51,17:52,18:53,19:54,20:55,21:56,22:57,23:58,24:59,25:60,26:61,27:62,28:63,29:64,30:65', 'Tarif Tabelle für die Zone 1, basiered auf <b>\'ECO\'</b> bis 30 kg Versandgewicht.', '6', '0', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Tariftabelle für Zone 1 bis 30 kg PRI', 'MODULE_SHIPPING_CHP_COST_PRI_2', '2:36,3:40,4:44,5:47,6:51,7:54,8:56,9:58,10:60,11:61,12:62,13:63,14:64,15:65,16:66,17:67,18:68,19:69,20:70,21:71,22:72,23:73,24:74,25:75,26:76,27:77,28:78,29:79,30:80', 'Tarif Tabelle für die Zone 1, basiered auf <b>\'PRI\'</b> bis 30 kg Versandgewicht.', '6', '0', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Tarifzone 2 Länder', 'MODULE_SHIPPING_CHP_COUNTRIES_3', 'AL,BA,BG,HR,CZ,DK,EE,FI,GI,GR,HU,IS,IE,LV,LT,MK,MT,MH,NO,PL,PT,RO,SK,SI,ES,SE,GB,YU', 'Durch Komma getrennt Liste der Länder als zwei Zeichen ISO-Code Landeskennzahlen, die Teil der Zone 2 sind.', '6', '0', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Tariftabelle für Zone 2 bis 30 kg ECO', 'MODULE_SHIPPING_CHP_COST_ECO_3', '2:37,3:41,4:45,5:49,6:52,7:55,8:58,9:61,10:64,11:66,12:68,13:70,14:72,15:74,16:75,17:76,18:77,19:78,20:79,21:80,22:81,23:82,24:83,25:84,26:85,27:86,28:87,29:88,30:89', 'Tarif Tabelle für die Zone 2, basiered auf <b>\'ECO\'</b> bis 30 kg Versandgewicht.', '6', '0', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Tariftabelle für Zone 2 bis 30 kg PRI', 'MODULE_SHIPPING_CHP_COST_PRI_3', '2:42,3:47,4:52,5:56,6:60,7:64,8:68,9:72,10:76,11:79,12:82,13:85,14:88,15:91,16:93,17:95,18:97,19:98,20:99,21:100,22:101,23:102,24:103,25:104,26:105,27:106,28:107,29:108,30:109', 'Tarif Tabelle für die Zone 2, basiered auf <b>\'PRI\'</b> bis 30 kg Versandgewicht.', '6', '0', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Tarifzone 3 Länder', 'MODULE_SHIPPING_CHP_COUNTRIES_4', 'DZ,BY,CA,CY,EG,IL,JO,LB,LY,MD,MA,RU,PM,SY,TN,TR,UA,US', 'Durch Komma getrennt Liste der Länder als zwei Zeichen ISO-Code Landeskennzahlen, die Teil der Zone 3 sind.', '6', '0', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Tariftabelle für Zone 3 bis 30 kg ECO', 'MODULE_SHIPPING_CHP_COST_ECO_4', '2:38,3:44,4:50,5:56,6:62,7:68,8:74,9:80,10:86,11:92,12:98,13:104,14:110,15:116,16:121,17:126,18:131,19:136,20:141,21:145,22:149,23:153,24:157,25:161,26:165,27:169,28:173,29:177,30:181', 'Tarif Tabelle für die Zone 3, basiered auf <b>\'ECO\'</b> bis 30 kg Versandgewicht.', '6', '0', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Tariftabelle für Zone 3 bis 30 kg PRI', 'MODULE_SHIPPING_CHP_COST_PRI_4', '2:46,3:55,4:66,5:77,6:86,7:95,8:104,9:113,10:122,11:130,12:138,13:146,14:154,15:162,16:170,17:178,18:186,19:194,20:202,21:209,22:216,23:223,24:230,25:237,26:244,27:251,28:258,29:265,30:272', 'Tarif Tabelle für die Zone 3, basiered auf <b>\'PRI\'</b> bis 30 kg Versandgewicht.', '6', '0', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Tarifzone 4 Länder', 'MODULE_SHIPPING_CHP_COUNTRIES_5', 'AF,AO,AI,AG,AM,AZ,BS,BH,BD,BB,BZ,BJ,BM,BT,BW,BF,BI,KY,KH,CM,CV,CF,TD,CN,KM,CG,CR,CI,CU,DJ,DM,DO,SV,GQ,ER,ET,GA,GM,GE,GH,GD,GP,GT,GN,GW,HT,HN,HK,IN,IR,IQ,JM,JP,YE,KZ,KE,KP,KR,KW,KG,LA,LS', 'Durch Komma getrennt Liste der Länder als zwei Zeichen ISO-Code Landeskennzahlen, die Teil der Zone 4 sind.', '6', '0', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Tariftabelle für Zone 4 bis 30 kg ECO', 'MODULE_SHIPPING_CHP_COST_ECO_5', '2:43,3:50,4:57,5:64,6:71,7:78,8:85,9:92,10:99,11:104,12:109,13:114,14:119,15:124,16:129,17:134,18:139,19:144,20:149,21:153,22:157,23:161,24:165,25:169,26:173,27:177,28:181,29:185,30:189', 'Tarif Tabelle für die Zone 4, basiered auf <b>\'ECO\'</b> bis 30 kg Versandgewicht.', '6', '0', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Tariftabelle für Zone 4 bis 30 kg PRI', 'MODULE_SHIPPING_CHP_COST_PRI_5', '2:53,3:67,4:80,5:94,6:107,7:120,8:133,9:146,10:159,11:167,12:177,13:187,14:197,15:207,16:215,17:223,18:231,19:239,20:247,21:255,22:263,23:271,24:279,25:287,26:295,27:303,28:311,29:319,30:327', 'Tarif Tabelle für die Zone 4, basiered auf <b>\'PRI\'</b> bis 30 kg Versandgewicht.', '6', '0', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Tarifzone 5 Länder', 'MODULE_SHIPPING_CHP_COUNTRIES_6', 'LR,MO,MG,MW,MY,MV,ML,MQ,MR,MU,YT,MX,MN,MS,MZ,MM,NA,NP,NI,NE,NG,OM,PK,PA,QA,RE,RW,KN,LC,VC,SH,ZM,SM,ST,SA,SN,SC,SL,SG,SO,ZA,LK,SD,SZ,TW,TJ,TZ,TH,TG,TM,TC,UG,AE,UZ,VN,VG,VI,ZW,AR,AW,AU,BO,BR,BN,CL,CO,CK,EC,FK,FJ,GF,PF,GY,ID,KI,NR,AN,NC,NZ,NF,PG,PY,PE,PH,PN,WS,SB,SR,TP,TO,TT,TV,UY,VU,VE,WF', 'Durch Komma getrennt Liste der Länder als zwei Zeichen ISO-Code Landeskennzahlen, die Teil der Zone 5 sind.', '6', '0', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Tariftabelle für Zone 4 bis 30 kg ECO', 'MODULE_SHIPPING_CHP_COST_ECO_6', '2:47,3:55,4:63,5:71,6:79,7:87,8:95,9:103,10:111,11:118,12:125,13:132,14:139,15:146,16:152,17:160,18:166,19:172,20:178,21:184,22:190,23:196,24:202,25:206,26:211,27:216,28:221,29:226,30:231', 'Tarif Tabelle für die Zone 4, basiered auf <b>\'ECO\'</b> bis 30 kg Versandgewicht.', '6', '0', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Tariftabelle für Zone 4 bis 30 kg PRI', 'MODULE_SHIPPING_CHP_COST_PRI_6', '2:65,3:83,4:101,5:119,6:136,7:153,8:170,9:187,10:204,11:219,12:234,13:249,14:264,15:279,16:294,17:309,18:324,19:339,20:354,21:367,22:380,23:393,24:406,25:419,26:432,27:445,28:458,29:471,30:484', 'Tarif Tabelle für die Zone 4, basiered auf <b>\'PRI\'</b> bis 30 kg Versandgewicht.', '6', '0', now())");
    }

    function remove() {
      tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      $keys = array('MODULE_SHIPPING_CHP_STATUS', 'MODULE_SHIPPING_CHP_HANDLING', 'MODULE_SHIPPING_CHP_TAX_CLASS', 'MODULE_SHIPPING_CHP_ZONE', 'MODULE_SHIPPING_CHP_SORT_ORDER');

      for ($i=1; $i <= $this->num_chp; $i++) {
        $keys[count($keys)] = 'MODULE_SHIPPING_CHP_COUNTRIES_' . $i;
        $keys[count($keys)] = 'MODULE_SHIPPING_CHP_COST_ECO_' . $i;
        $keys[count($keys)] = 'MODULE_SHIPPING_CHP_COST_PRI_' . $i;
      }

      return $keys;
    }
  }
?>
