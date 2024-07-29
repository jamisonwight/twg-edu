<?php
/** Template Name: Contact */

get_header();
?>

<div class="grid-container contact">
    <div class="wrapper">
        <div class="intro">
            <h1 class="heading-2"></h1>
        </div>

        <div class="form">
            <?php echo do_shortcode('[contact-form-7 id="193" title="CCPA Request"]'); ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>