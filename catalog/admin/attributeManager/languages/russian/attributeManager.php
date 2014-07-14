<?php
/*
  $Id: attributeManager.php,v 1.0 21/02/06 Sam West$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Released under the GNU General Public License
  
  English translation to AJAX-AttributeManager-V2.7
  
  by Shimon Doodkin
  http://help.me.pro.googlepages.com
  helpmepro1@gmail.com
*/

//attributeManagerPrompts.inc.php

define('AM_AJAX_YES', 'Äà');
define('AM_AJAX_NO', 'Íåò');
define('AM_AJAX_UPDATE', 'Îáíîâèòü');
define('AM_AJAX_CANCEL', 'Îòìåíèòü');
define('AM_AJAX_OK', 'ÎÊ');

define('AM_AJAX_SORT', 'Ïîðÿäîê ñîðòèðîâêè:');
define('AM_AJAX_TRACK_STOCK', 'Îòñëåæèâàòü êîë-âî?');
define('AM_AJAX_TRACK_STOCK_IMGALT', 'Îòñëåæèâàòü êîë-âî äàííîãî àòðèáóòà?');

define('AM_AJAX_ENTER_NEW_OPTION_NAME', 'Ââåäèòå íàçâàíèå íîâîé îïöèè');
define('AM_AJAX_ENTER_NEW_OPTION_VALUE_NAME', 'Ââåäèòå íàçâàíèå íîâîé îïöèè');
define('AM_AJAX_ENTER_NEW_OPTION_VALUE_NAME_TO_ADD_TO', 'Ââåäèòå íàçâàíèå íîâîé îïöèè äîáàâëÿåìîé ê %s');

define('AM_AJAX_PROMPT_REMOVE_OPTION_AND_ALL_VALUES', 'Âû óâåðåíû, ÷òî õîòèòå óäàëèòü %s è âñå ñâÿçàííûå çíà÷åíèÿ äëÿ ýòîãî òîâàðà?');
define('AM_AJAX_PROMPT_REMOVE_OPTION', 'Âû óâåðåíû, ÷òî õîòèòå óäàëèòü %s äëÿ ýòîãî òîâàðà?');
define('AM_AJAX_PROMPT_STOCK_COMBINATION', 'Âû óâåðåíû, ÷òî õîòèòå óäàëèòü ýòó êîìáèíàöèþ îïöèé äëÿ òîâàðà?');

define('AM_AJAX_PROMPT_LOAD_TEMPLATE', 'Âû óâåðåíû, ÷òî õîòèòå çàãðóçèòü øàáëîí %s? <br />Âñå òåêóùèé îïöèè òîâàðà áóäóò èçìåíåíû. Èçìåíåíèÿ íåâîçìîæíî áóäåò îòìåíèòü.');
define('AM_AJAX_NEW_TEMPLATE_NAME_HEADER', 'Ââåäèòå íàçâàíèå äëÿ íîâîãî øàáëîíà. Èëè...');
define('AM_AJAX_NEW_NAME', 'Íîâîå íàèìåíîâàíèå:');
define('AM_AJAX_CHOOSE_EXISTING_TEMPLATE_TO_OVERWRITE', ' ...<br /> ... âûáåðèòå ñóùåñòâóþùèé äëÿ åãî çàìåíû');
define('AM_AJAX_CHOOSE_EXISTING_TEMPLATE_TITLE', 'Ñóùåñòâóþùèé:'); 
define('AM_AJAX_RENAME_TEMPLATE_ENTER_NEW_NAME', 'Ââåäèòå íîâîå íàçâàíèå äëÿ øàáëîíà %s');
define('AM_AJAX_PROMPT_DELETE_TEMPLATE', 'Âû óâåðåíû, ÷òî õîòèòå óäàëèòü øàáëîí %s?<br>Èçìåíåíèÿ íåëüçÿ áóäåò îòìåíèòü!');

//attributeManager.php

define('AM_AJAX_ADDS_ATTRIBUTE_TO_OPTION', 'Äîáàâèòü óêàçàííûé àòðèáóò ê îïöèè %s');
define('AM_AJAX_ADDS_NEW_VALUE_TO_OPTION', 'Äîáàâèòü íîâîå çíà÷åíèå ê îïöèè %s');
define('AM_AJAX_PRODUCT_REMOVES_OPTION_AND_ITS_VALUES', 'Óäàëèòü îïöèþ %1$s è %2$d çíà÷åíèé äàííîé îïöèè ñ ýòîãî òîâàðà');
define('AM_AJAX_CHANGES', 'Èçìåíåíèÿ'); 
define('AM_AJAX_LOADS_SELECTED_TEMPLATE', 'Çàãðóçèòü óêàçàííûé øàáëîí');
define('AM_AJAX_SAVES_ATTRIBUTES_AS_A_NEW_TEMPLATE', 'Ñîõðàíèòü òåêóùèå íàñòðîéêè â êà÷åñòâå øàáëîíà');
define('AM_AJAX_RENAMES_THE_SELECTED_TEMPLATE', 'Ïåðåèìåíîâàòü âûáðàííûé øàáëîí');
define('AM_AJAX_DELETES_THE_SELECTED_TEMPLATE', 'Óäàëèòü âûáðàííûé øàáëîí');
define('AM_AJAX_NAME', 'Íàèìåíîâàíèå');
define('AM_AJAX_ACTION', 'Äåéñòâèå');
define('AM_AJAX_PRODUCT_REMOVES_VALUE_FROM_OPTION', 'Óäàëèòü %1$s èç îïöèè %2$s ýòîãî òîâàðà');
define('AM_AJAX_MOVES_VALUE_UP', 'Ïåðåìåñòèòü îïöèþ ââåðõ');
define('AM_AJAX_MOVES_VALUE_DOWN', 'Ïåðåìåñòèòü îïöèþ âíèç');
define('AM_AJAX_ADDS_NEW_OPTION', 'Äîáàâèòü íîâóþ îïöèþ â ñïèñîê');
define('AM_AJAX_MOVES_VALUE_UP', 'Moves option value up');
define('AM_AJAX_MOVES_VALUE_DOWN', 'Moves option value down');
define('AM_AJAX_ADDS_NEW_OPTION', 'Adds a new option to the list');
define('AM_AJAX_OPTION', 'Îïöèÿ:');
define('AM_AJAX_VALUE', 'Çíà÷åíèå:');
define('AM_AJAX_PREFIX', 'Ïðåô.öåíû:');
define('AM_AJAX_PRICE', 'Öåíà:');
define('AM_AJAX_ATTRIBUTE_CODE', 'Code Suffix:');
define('AM_AJAX_WEIGHT_PREFIX', 'Ïðåô.âåñ:');
define('AM_AJAX_WEIGHT', 'Âåñ:');
define('AM_AJAX_SORT', 'Ïîçèöèÿ:');
define('AM_AJAX_ADDS_NEW_OPTION_VALUE', 'Äîáàâèòü íîâîå çíà÷åíèå îïöèè â ñïèñîê');
define('AM_AJAX_ADDS_ATTRIBUTE_TO_PRODUCT', 'Äîáàâèòü íîâóþ îïöèþ ê òîâàðó');
define('AM_AJAX_DELETES_ATTRIBUTE_FROM_PRODUCT', 'Óäàëèòü ýòó îïöèþ èëè êîìáèíàöèþ îïöèé');
define('AM_AJAX_QUANTITY', 'Êîëè÷åñòâî:');
define('AM_AJAX_PRODUCT_REMOVE_ATTRIBUTE_COMBINATION_AND_STOCK', 'Óäàëèòü êîìáèíàöèþ îïöèé è èõ êîëè÷åñòâî äëÿ ýòîãî òîâàðà');
define('AM_AJAX_UPDATE_OR_INSERT_ATTRIBUTE_COMBINATIONBY_QUANTITY', 'Îáíîâèòü èëè âñòàâèòü êîìáèíàöèþ îïöèé ñ óêàçàííûì êîëè÷åñòâîì');
define('AM_AJAX_UPDATE_PRODUCT_QUANTITY', 'Óñòàíîâèòü óêàçàííîå êîëè÷åñòâî òîâàðà');

//attributeManager.class.php
define('AM_AJAX_TEMPLATES', '-- Øàáëîíû --');

//----------------------------
// Change: download attributes for AM
//
// author: mytool
//-----------------------------
define('AM_AJAX_FILENAME', 'Ôàéë');
define('AM_AJAX_FILE_DAYS', 'Äíåé');
define('AM_AJAX_FILE_COUNT', 'Ìàêñèìóì ñêà÷èâàíèé');
define('AM_AJAX_DOWLNOAD_EDIT', 'Ðåäàêòèðîâàòü îïöèþ ñêà÷èâàíèÿ');
define('AM_AJAX_DOWLNOAD_ADD_NEW', 'Äîáàâèòü îïöèþ ñêà÷èâàíèÿ');
define('AM_AJAX_DOWLNOAD_DELETE', 'Óäàëèòü îïöèþ ñêà÷èâàíèÿ');
define('AM_AJAX_HEADER_DOWLNOAD_ADD_NEW', 'Äîáàâèòü îïöèþ ñêà÷èâàíèÿ äëÿ \"%s\"');
define('AM_AJAX_HEADER_DOWLNOAD_EDIT', 'Ðåäàêòèðîâàòü îïöèþ ñêà÷èâàíèÿ äëÿ \"%s\"');
define('AM_AJAX_HEADER_DOWLNOAD_DELETE', 'Óäàëèòü îïöèþ ñêà÷èâàíèÿ äëÿ \"%s\"');
define('AM_AJAX_FIRST_SAVE', 'Ñîõðàíèòå òîâàð ïåðåä äîáàâëåíèåì îïöèé.');

//----------------------------
// EOF Change: download attributes for AM
//-----------------------------

define('AM_AJAX_OPTION_NEW_PANEL','Íîâàÿ îïöèÿ:');
define('AM_AJAX_SORT_NUMERIC', 'Sort Numerically');
define('AM_AJAX_SORT_ALPHABETIC', 'Sort Alphabetically');

?>
