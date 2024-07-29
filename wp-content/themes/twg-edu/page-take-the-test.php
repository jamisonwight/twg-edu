<?php
    /** Template Name: Take The Quiz */

    get_header();
?>

<div class="grid-container full page-take-the-test">
    <div class="wrapper">
        <div class="grid-x container">
            <!-- Quiz -->
            <?php quiz(); ?>
        </div>
    </div>
</div>

<?php get_footer() ?>