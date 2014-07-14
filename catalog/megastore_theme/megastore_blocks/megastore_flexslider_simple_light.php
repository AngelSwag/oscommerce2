<?php
$x=1;
$counter= 1;
$counter2= 1;
$ban = array();
$banners_demo = tep_db_query("select * from " . TABLE_BANNERS . " where banners_group = 'slider-light'");

if (tep_db_num_rows($banners_demo) == 0 ) {

    $default_banner1 = tep_db_query("insert into " . TABLE_BANNERS . " (banners_title,  banners_url, banners_image, banners_group, date_added, status) values ('slide1', 'index.php?cPath=1', 'slider-simple/dark/slider1.jpg', 'slider-light', now(), 1)");
    $default_banner2 = tep_db_query("insert into " . TABLE_BANNERS . " (banners_title,  banners_url, banners_image, banners_group, date_added, status) values ('slide2', 'index.php?cPath=2', 'slider-simple/dark/slider2.jpg', 'slider-light', now(), 1)");
    $default_banner3 = tep_db_query("insert into " . TABLE_BANNERS . " (banners_title,  banners_url, banners_image, banners_group, date_added, status) values ('slide3', 'index.php?cPath=3', 'slider-simple/dark/slider3.jpg', 'slider-light', now(), 1)");
}
$banners_demo_query = tep_db_query("select * from " . TABLE_BANNERS . " where banners_group = 'slider-light' order by banners_order, banners_title");

if (tep_db_num_rows($banners_demo_query)) {
?>

<section class="slider">
    <div class="flexslider big">
        <ul class="slides">
<?php
    while ($banners1 = tep_db_fetch_array($banners_demo_query)) {

		echo '<li>'. str_replace('_blank', '_self', tep_display_banner('static', $banners1['banners_id'])).'</li>';
    }
?> 
        </ul>
    </div>
</section>
<?php
}
?>

