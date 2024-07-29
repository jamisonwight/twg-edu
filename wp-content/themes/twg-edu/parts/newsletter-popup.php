<?php if (get_field('enable_newsletter', 'option')) : ?>
    <div id="newsletter-popup" class="newsletter-popup">
        <div class="newsletter-wrapper">
            <div class="popup">
                <h1 class="heading-2"><?php the_field('newsletter_title', 'option'); ?></h1>
                <p><?php the_field('newsletter_content', 'option'); ?></p>
                <div class="newsletter-form">
                    <!-- Begin Mailchimp Signup Form -->
                    <link href="//cdn-images.mailchimp.com/embedcode/slim-10_7.css" rel="stylesheet" type="text/css">
                    <form action="https://buzzbox.us16.list-manage.com/subscribe/post?u=84df7d76598dfd6667fd9f6e7&amp;id=0ad33c0d5c" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
                        <input type="email" value="" name="EMAIL" class="email" id="mce-EMAIL" placeholder="email address" required>
                        <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
                        <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_84df7d76598dfd6667fd9f6e7_0ad33c0d5c" tabindex="-1" value=""></div>
                        <button type="submit" name="subscribe" id="mc-embedded-subscribe" class="btn-default">Submit</button>
                    </form>
                    <!--End mc_embed_signup-->
                </div>
                <div class="close"><span><?php the_field('newsletter_close_text', 'option'); ?></span></div>
            </div>
        </div>
    </div>
<?php endif; ?>