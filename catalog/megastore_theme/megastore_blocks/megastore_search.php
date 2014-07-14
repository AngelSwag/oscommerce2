<div class="pull-right padding-1 top_search_block">
    <div class="form-search-wrapper">
        <?php echo tep_draw_form('form-search-top', tep_href_link(FILENAME_ADVANCED_SEARCH_RESULT, '', 'NONSSL', false), 'get', ' class="form-search" id="form-search"');  ?>
            <?php echo tep_draw_input_field('keywords', ET_SEARCH_KEYWORD, ' class="input-medium search-query" onfocus="if(this.value == \''.ET_SEARCH_KEYWORD.'\') {this.value = \'\';}" onblur="if (this.value == \'\') {this.value = \''.ET_SEARCH_KEYWORD.'\';}"').tep_hide_session_id(); ?>
            <button type="submit" class="btn btn-top-search" onClick="document.getElementById('form-search-top').submit()"><i class="icon-search-2 icon-large"></i></button>
        </form>
    </div>
</div>