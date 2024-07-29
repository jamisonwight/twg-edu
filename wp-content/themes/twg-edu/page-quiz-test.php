<?php
    /** Template Name: Quiz Test */

    get_header();

    $retest = $_GET['retest'];
    $first_name = $_GET['first_name'];
    $last_name = $_GET['last_name'];
    $email = $_GET['email'];
    $date_of_birth = $_GET['date_of_birth'];
?>


<div class="grid-container full page-quiz-test">
    <div class="wrapper">
        <div class="grid-x container">
            <div class="intro-description">
                <span class="heading-1"><?php echo $serving->serving_title; ?></span>
                <span class="heading-4"><?php echo $serving->serving_subtitle; ?></span>
            </div>
            <div class="content-blocks-container">
                <?php echo $serving->content_blocks(); ?>
            </div>
           
            <!-- Quiz: Category -->
            <?php quiz('serving'); ?>
        </div>
    </div>
</div>



<?php get_footer() ?>