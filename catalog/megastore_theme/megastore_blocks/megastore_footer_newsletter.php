<div class="span3">
    <h4><?php echo NEWSLETTERS; ?></h4>
        <?php echo tep_draw_form('index_newsletter', tep_href_link('boxnewsletter.php', '', 'SSL'), 'post', 'onsubmit="return validate();" class="form-mail"', true) . tep_draw_hidden_field('action', 'process'); ?>
        <input name="email_address" id="newsletter" class="input-text required-entry validate-email input-medium" type="text" value="enter your e-mail..."  onfocus="if(this.value=='enter your e-mail...'){this.value=''}" onblur="if(this.value==''){this.value='enter your e-mail...'}" />
        <button name="newsletter" type="submit" class="btn"><i class="icon-email"></i></button>
    </form>
</div>