<?php

function tep_set_contributions_manager_status($contr_id, $status) {
   $current_time = date('Y-m-d H:i:s'); 
   if ($status == '0') {
      return tep_db_query("update " . TABLE_CONTRIBUTIONS_MGR . " set status = '0', date_status_change = NULL where contr_id = '" . $contr_id . "'");
    } elseif ($status == '1') {
      return tep_db_query("update " . TABLE_CONTRIBUTIONS_MGR . " set status = '1', date_status_change ='" . $current_time . "' where contr_id = '" . $contr_id . "'");
    } elseif ($status == '2') {
      return tep_db_query("update " . TABLE_CONTRIBUTIONS_MGR . " set status = '2', date_status_change ='" . $current_time . "' where contr_id = '" . $contr_id . "'");
    } else {
      return -1;
    }
  }

function tep_set_contributions_manager_sort_order($sort_name) {

      tep_db_query("update " . TABLE_CONTRIBUTIONS_MGR_TABLE_SORT . " set sort_status = 0 where sort_status = 1");
      tep_db_query("update " . TABLE_CONTRIBUTIONS_MGR_TABLE_SORT . " set sort_status = 1 where sort_column_name = '" . $sort_name . "'");
     }

function tep_get_contributions_manager_sort_image($sort_name, $order_name_status){
  	list($column_name, $sort_direction) = explode("-", $sort_name);
  	if ($sort_direction == "a")
  	{
		if($sort_name == $order_name_status)
		{
			$sort_image = "icon_up_not_selected.gif";
		}else{
			$sort_image = "icon_up_selected.gif";
		}
	}else{
		if($sort_name == $order_name_status)
		{
			$sort_image = "icon_down_not_selected.gif";
		}else{
			$sort_image = "icon_down_selected.gif";
		}
       }
  return $sort_image;
}

function tep_count_contributions_manager() {
    
    $contributions_count_query = tep_db_query("select count(*) as total from " . TABLE_CONTRIBUTIONS_MGR);
    $contributions_count = tep_db_fetch_array($contributions_count_query);

    return $contributions_count['total'];
  }
?>