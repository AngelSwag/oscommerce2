<?php
//echo '<pre>';
//var_dump($currencies);
//echo '</pre>';




if (isset($currencies) && is_object($currencies)) {
    reset($currencies->currencies);

      while (list($key, $value) = each($currencies->currencies)) {
          if  ($value['symbol_right'] !== '') {
              $symbol = $value['symbol_right'];
          }  elseif ($value['symbol_left'] !== '') {
              $symbol = $value['symbol_left'];
          }  else {
             $symbol = $key;
          }

          $currency_name = $value['title'];

          $currency_string .= '<li><a href="' . tep_href_link(basename($PHP_SELF), tep_get_all_get_params(array('language', 'currency')) . 'currency=' . $key, $request_type) . '">('.$symbol.')&nbsp;'.$currency_name.'</a></li>';
    }

  }
?>


<span class="link_label currency_label"><?php echo HEADER_CURRENCY; ?></span>
<div class="fadelink currencies_block"><a><?php echo HEADER_CURRENCY_SELECT; ?></a>
    <div class="ul_wrapper">
        <ul>
            <?php echo  $currency_string; ?>
        </ul>
    </div>
</div>


