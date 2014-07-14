<?php
$x=1;
$counter= 1;
$counter2= 1;
$ban_bottom = array();
$banners_demo = tep_db_query("select * from " . TABLE_BANNERS . " where banners_group = 'bottom'");

if (tep_db_num_rows($banners_demo) == 0 ) {

    $default_banner1 = tep_db_query("insert into " . TABLE_BANNERS . " (banners_title,  banners_url, banners_image, banners_group, date_added, status) values ('banner1', 'index.php?cPath=1', 'bottom-banners/dark_banner_1.png', 'bottom', now(), 1)");
    $default_banner2 = tep_db_query("insert into " . TABLE_BANNERS . " (banners_title,  banners_url, banners_image, banners_group, date_added, status) values ('banner2', 'index.php?cPath=2', 'bottom-banners/dark_banner_2.png', 'bottom', now(), 1)");
    $default_banner3 = tep_db_query("insert into " . TABLE_BANNERS . " (banners_title,  banners_url, banners_image, banners_group, date_added, status) values ('banner3', 'index.php?cPath=3', 'bottom-banners/dark_banner_3.png', 'bottom', now(), 1)");
    $default_banner4 = tep_db_query("insert into " . TABLE_BANNERS . " (banners_title,  banners_url, banners_image, banners_group, date_added, status) values ('banner4', 'index.php?cPath=4', 'bottom-banners/dark_banner_4.png', 'bottom', now(), 1)");
}

$bottom_banners_demo_query = tep_db_query("select * from " . TABLE_BANNERS . " where banners_group = 'bottom' order by banners_title");

if (tep_db_num_rows($bottom_banners_demo_query)) {
    while ($banners2 = tep_db_fetch_array($bottom_banners_demo_query)) {
        $ban_bottom[$counter] = array();
        $ban_bottom[$counter]['banners_id'] = $banners2['banners_id'];
        $ban_bottom[$counter]['banners_title'] = $banners2['banners_title'];
        $ban_bottom[$counter]['banners_url'] = $banners2['banners_url'];
        $ban_bottom[$counter]['banners_image'] = $banners2['banners_image'];
        $counter++;
    }
}
?>

  <div class="container">
      <div class="row">
          <div class="span3 block_img"><?php if (tep_banner_exists('static', $ban_bottom[1]['banners_id'])){ echo str_replace('_blank', '_self', tep_display_banner('static', $ban_bottom[1]['banners_id'])); } ?></div>
          <div class="span3 block_img"><?php if (tep_banner_exists('static', $ban_bottom[2]['banners_id'])){ echo str_replace('_blank', '_self', tep_display_banner('static', $ban_bottom[2]['banners_id'])); } ?></div>
          <div class="span3 block_img"><?php if (tep_banner_exists('static', $ban_bottom[3]['banners_id'])){ echo str_replace('_blank', '_self', tep_display_banner('static', $ban_bottom[3]['banners_id'])); } ?></div>
          <div class="span3 block_img"><?php if (tep_banner_exists('static', $ban_bottom[4]['banners_id'])){ echo str_replace('_blank', '_self', tep_display_banner('static', $ban_bottom[4]['banners_id'])); } ?></div>
      </div>
  </div>