<?php /** Template Name: Home */?>

<?php get_header();?>

<?php
class Home {
    public $hero_title,
           $hero_subtitle,
           $hero_description,
           $hero_image,
           $hero_cta_text,
           $hero_cta_url,
           $serve_title,
           $serve_description,
           $serve_image,
           $serve_cta_text,
           $serve_cta_url,
           $learn_title,
           $learn_description,
           $learn_wines,
           $cert_title,
           $cert_description,
           $cert_cta_text,
           $cert_cta_url;

    function __construct() {
        $this->hero_title = get_field('hero_title');
        $this->hero_subtitle = get_field('hero_subtitle');
        $this->hero_description = get_field('hero_description');
        $this->hero_image = get_field('hero_image');
        $this->hero_cta_text = get_field('hero_cta_text');
        $this->hero_cta_url = get_field('hero_cta_url');
        $this->serve_title = get_field('serve_title');
        $this->serve_description = get_field('serve_description');
        $this->serve_image = get_field('serve_image');
        $this->serve_cta_text = get_field('serve_cta_text');
        $this->serve_cta_url = get_field('serve_cta_url');
        $this->learn_title = get_field('learn_title');
        $this->learn_description = get_field('learn_description');
        $this->cert_title = get_field('cert_title');
        $this->cert_description = get_field('cert_description');
        $this->cert_cta_text = get_field('cert_cta_text');
        $this->cert_cta_url = get_field('cert_cta_url');

    }

    function get_wines() {
        if (have_rows('wines')) {
            while (have_rows('wines')) {
                the_row();

                $title = get_sub_field('title');
                $image = get_sub_field('image');
                $link = get_sub_field('link');

                echo '<div class="wine-item">
                        <a href="'.$link.'">
                            <div class="title">
                                <span class="heading-3">'.$title.'</span>
                            </div>
                            <div class="image">
                                <img src="'.$image['url'].'" alt="'.$image['alt'].'">
                            </div>
                        </a>
                    </div>';
            }
        }
    }
}

$home = new Home();
?>

<div class="grid-container full page-home">
    <div class="wrapper">
        <div class="grid-x container">

            <!-- Hero -->
            <div class="hero-content">
                <div class="content-left">
                    <h1 class="heading-1"><?php echo $home->hero_title; ?></h1>
                    <img 
                        class="logo"
                        src="<?php echo get_template_directory_uri(); ?>/assets/images/logo-twg-slate.svg" 
                        alt="The Wine Group Logo">

                    <span class="heading-3"><?php echo $home->hero_subtitle; ?></span>
                    <p><?php echo $home->hero_description; ?></p>
                    <div class="btn-container">
                        <a class="btn-default" href="<?php echo $home->hero_cta_url; ?>">
                            <?php echo $home->hero_cta_text; ?>
                        </a>
                    </div>
                </div>

                <div class="content-right">
                    <div class="image">
                        <img 
                        src="<?php echo $home->hero_image['url']; ?>" 
                        alt="<?php echo $home->hero_image['alt']; ?>">
                    </div>
                </div>
            </div>

            <!-- How to Serve -->
            <div class="how-to-serve">
                <div class="content-container">
                    <div class="content-left">
                        <div class="title">
                            <span class="heading-2"><?php echo $home->serve_title; ?></span>
                        </div>
                        <div class="image hide-for-large">
                            <img 
                                src="<?php echo $home->serve_image['url']; ?>" 
                                alt="<?php echo $home->serve_image['alt']; ?>">
                        </div>
                        <div class="content">
                            <p><?php echo $home->serve_description; ?></p>
                            <div class="btn-container">
                                <a href="<?php echo $home->serve_cta_url; ?>" class="btn-small">
                                    <?php echo $home->serve_cta_text; ?>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="content-right show-for-large">
                        <div class="image">
                            <img 
                                src="<?php echo $home->serve_image['url']; ?>" 
                                alt="<?php echo $home->serve_image['alt']; ?>">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Learn About Wines -->
            <div class="learn-about-wines">
                <div class="content-container">
                    <div class="description">
                        <span class="heading-2"><?php echo $home->learn_title; ?></span>
                        <p><?php echo $home->learn_description; ?></p>
                    </div>
                    <div class="wines">
                        <?php echo $home->get_wines(); ?>
                    </div>
                </div>
            </div>

            <!-- Certification -->
            <div class="certification">
                <div class="content-container">
                    <div class="title">
                        <span class="heading-2"><?php echo $home->cert_title; ?></span>
                    </div>
                    <div class="content">
                        <p><?php echo $home->cert_description; ?></p>
                        <a href="<?php echo $home->cert_cta_url ?>" class="btn-small">
                            <?php echo $home->cert_cta_text; ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer();?>