<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/
?>


<?php
  if ($oscTemplate->hasBlocks('boxes_column_left')) {

      if (!$product_page_url && !$main_page_url){
?>

</div>

<!-- sidebar enable / disable -->
<?php if (SIDEBAR_STATUS !== 'disable') { ?>
<div id="column_left" class="span3">
    <div class="row">
        <div class="span3">
            <?php echo $oscTemplate->getBlocks('boxes_column_left'); ?>
        </div>
    </div>
</div>
      <?php } ?>

      <!-- sidebar enable / disable -->



      <?php

    }
  }
?>


<!-- blocks for all pages-->
<?php if (!$main_page_url) { ?>
            </div>
         </div>
<?php } ?>
    <!-- end blocks for all pages-->




    </section>
<div id="push"></div>

</div>
<!-- end wrap //-->

<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>


<!-- bodyWrapper //-->

<?php echo $oscTemplate->getBlocks('footer_scripts'); ?>

</body>
</html>
