<div class="container">
    <div class="row">
        <div class="span6">
            <div class="row">
                <!-- theme info -->
                <div class="span3">
                    <h4>
                        <span class="bgcolor_icon">
                            <i class="icon-vcard"></i>
                        </span>
                        <?php echo TEXT_THEME_INFO; ?>
                    </h4>
                    <div class="cleancode">
                        <?php echo THEME_INFO; ?>
                    </div>
                </div>
                <!-- theme info -->

                <!-- facebook -->
                <div class="span3">
                    <h4>
                        <span class="bgcolor_icon bgcolor_icon_facebook">
                            <i class="icon-facebook"></i>
                        </span>
                        <?php echo FOOTER_FACEBOOK; ?>
                    </h4>


                        <div class="fb-like-box" data-href="https://www.facebook.com/<?php echo FACEBOOK_ACCOUNT; ?>" data-height="215" data-show-faces="true" data-stream="false" data-show-border="false" data-header="false"></div>
                    <script>(function(d, s, id) {
                        var js, fjs = d.getElementsByTagName(s)[0];
                        if (d.getElementById(id)) return;
                        js = d.createElement(s); js.id = id;
                        js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
                        fjs.parentNode.insertBefore(js, fjs);
                    }(document, 'script', 'facebook-jssdk'));</script>


                </div>
                <!-- facebook -->

            </div>
        </div>
        <div class="span6">
            <div class="row">

                <!-- TWITTER -->
                <div class="span3">
                    <h4><i class="icon-twitter-bird"></i><?php echo FOOTER_TWITTER_FEEDS; ?></h4>
                    <?php
                        if (isset($theme_options["option_themecolor"]) && ($theme_options["option_themecolor"] !== '')) {
                            $color = $theme_options["option_themecolor"];
                        } else {
                            $color = '#FF7E00';
                        }
                    ?>

                    <a class="twitter-timeline" data-widget-id="375593032344563712"
                       data-tweet-limit="3"
                       data-dnt="true"
                       data-screen-name="<?php echo TWITTER_ACCOUNT; ?>"
                       data-link-color="<?php echo $color; ?>"
                       data-theme="light"
                       data-aria-polite="assertive"
                       data-chrome="noheader nofooter noborders noscrollbar transparent">
                        &nbsp;
                    </a>
                    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

                </div>
                <!-- TWITTER -->

                <!-- CONTACT INFO -->
                <div class="span3">
                    <h4>
                        <span class="bgcolor_icon bgcolor_icon_email">
                            <i class="icon-email"></i>
                        </span>
                        <?php echo FOOTER_TITLE_CONTACT_INFO; ?>
                    </h4>
                    <div class="cleancode">
                        <ul class="icons">
                            <li><i class="icon-call"></i><strong><?php echo FOOTER_TITLE_CONTACT_PHONE; ?></strong><br>
                                <?php echo FOOTER_CONTACT_PHONES; ?></li>
                            <li><i class="icon-mobile-alt"></i><strong><?php echo FOOTER_TITLE_CONTACT_CELL_PHONE; ?></strong><br>
                                <?php echo FOOTER_CONTACT_PHONES; ?></li>
                            <li><i class="icon-mail"></i><strong><?php echo FOOTER_TITLE_CONTACT_MAIL; ?></strong><br>
                                <a href="mailto:<?php echo FOOTER_CONTACT_MAIL1; ?>"><?php echo FOOTER_CONTACT_MAIL1; ?></a> <br>
                                <a href="mailto:<?php echo FOOTER_CONTACT_MAIL2; ?>"><?php echo FOOTER_CONTACT_MAIL2; ?></a> </li>
                            <li><i class="icon-skype"></i><strong><?php echo FOOTER_CONTACT_SKYPE; ?></strong><br>
                                <?php echo FOOTER_CONTACT_SKYPE_ACCOUNT; ?></li>
                        </ul>
                    </div>
                </div>
                <!-- CONTACT INFO -->

            </div>
        </div>
    </div>
</div>