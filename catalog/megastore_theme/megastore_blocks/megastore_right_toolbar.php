<div id="right_toolbar" class="hidden-phone hidden-tablet">
    <div class="small_logo"><?php echo '<a href="' . tep_href_link(FILENAME_DEFAULT) . '">' . tep_image(DIR_WS_IMAGES .BUYSHOP_THEME. '/store_logo_mini.png', STORE_NAME,'','','style="width:52px;height:164px"') . '</a>'; ?></div>
    <?php include(DC_BLOCKS . 'megastore_right_cart.php'); ?>

    <div class="search_wrapper">
        <?php echo tep_draw_form('form-search-right', tep_href_link(FILENAME_ADVANCED_SEARCH_RESULT, '', 'NONSSL', false), 'get', ' class="form-search" id="form-search-right"');  ?>
            <button type="submit" class="btn_search" onClick="document.getElementById('form-search-right').submit()"><i class="icon-search-2 icon-large"></i></button>
            <?php echo tep_draw_input_field('keywords', ET_SEARCH_KEYWORD, ' class="input-medium search-query" onfocus="if(this.value == \''.ET_SEARCH_KEYWORD.'\') {this.value = \'\';}" onblur="if (this.value == \'\') {this.value = \''.ET_SEARCH_KEYWORD.'\';}"').tep_hide_session_id(); ?>
        </form>
    </div>

    <div id="back-top"> <a href="#top"><i class="icon-up-2"></i></a> </div>
</div>
