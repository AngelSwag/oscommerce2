<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

if ( !defined('MYSQLI_ASSOC') ) {
	define('MYSQLI_ASSOC', MYSQL_ASSOC);
}

if ( !defined('MYSQLI_BOTH') ) {
	define('MYSQLI_BOTH', MYSQL_BOTH);
}

if ( !function_exists('mysqli_insert_id') ) {
	function mysqli_insert_id($link) {
	  return mysql_insert_id($link);
	}
}

if ( !function_exists('mysqli_num_fields') ) {
	function mysqli_num_fields($link) {
	  return mysql_num_fields($link);
	}
}

if ( !function_exists('mysqli_num_fields') ) {
	function mysqli_fetch_field($link) {
	  return mysql_field_name($link);
	}
}

if ( !function_exists('mysqli_result') ) {
	function mysqli_result($res,$row,$field) {
		tep_db_data_seek($res, $row);
		$data = mysqli_fetch_array($res, MYSQLI_NUM);
		return $data[$field];
	}
}
  
?>