

<?php
  if (!isset($lng) || (isset($lng) && !is_object($lng))) {
    include(DIR_WS_CLASSES . 'language.php');
    $lng = new language;
  }
  reset($lng->catalog_languages);

  while (list($key, $value) = each($lng->catalog_languages)) {
    $languages_string .= '<li><img data-retina="true" width="14" height="10" src="'.DIR_WS_LANGUAGES .  $value['directory'] . '/images/icon.gif" alt />'.
        '<a href="' . tep_href_link(basename($PHP_SELF), tep_get_all_get_params(array('language', 'currency')) . 'language=' . $key, $request_type) . '">'.$value['name'].'</a></li>';
  }
?>
<span class="link_label"><?php echo HEADER_LANGUAGE; ?></span>
<div class="fadelink"><a><?php echo HEADER_LANGUAGE_SELECT; ?></a>
    <div class="ul_wrapper">
        <ul>
            <?php echo $languages_string; ?>
        </ul>
    </div>
</div>