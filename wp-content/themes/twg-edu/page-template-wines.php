<?php /** Template Name: Wines */?>

<?php get_header();?>

<?php
class Wines {
    public $title,
           $subtitle,
           $content_blocks,
           $next_page_title,
           $next_page,
           $next_page_icon_class,
           $prev_page_title,
           $prev_page,
           $prev_page_icon_class,
           $theme,
           $quiz_category;

    function __construct() {
        $this->title = get_field('title');
        $this->subtitle = get_field('subtitle');
        $this->next_page_title = get_field('next_page_title');
        $this->next_page = get_field('next_page');
        $this->next_page_icon_class = get_field('next_page_icon_class');
        $this->prev_page_title = get_field('prev_page_title');
        $this->prev_page = get_field('prev_page');
        $this->prev_page_icon_class = get_field('prev_page_icon_class');
        $this->theme = get_field('theme');
        $this->quiz_category = get_field('quiz_category');
    }

    function navigation() {
        echo '
            <div class="wine-navigation">
                <div class="nav-left">
                    <a 
                      href="'.$this->prev_page.'" 
                      class="'.$this->prev_page_icon_class.'">
                        '.$this->prev_page_title.'
                    </a>
                </div>
                <div class="nav-right">
                    <a 
                      href="'.$this->next_page.'" 
                      class="'.$this->next_page_icon_class.'">
                        '.$this->next_page_title.'
                    </a>
                </div>
            </div>
        ';
    }

    function varietal_navigation() {
        if (have_rows('nav_links')) {
            echo '<div class="nav-middle">';
            while (have_rows('nav_links')) {
                the_row();

                $link_title = get_sub_field('link_title');
                $link_id = get_sub_field('wine_target_id');

                echo '
                    <a href="'.$link_id.'">'.$link_title.'</a>
                ';
            }
            echo '</div>';
        }
    }

    function content_blocks() {
        if (have_rows('content_block')) {
            while (have_rows('content_block')) {
                the_row();

                $title = get_sub_field('title');
                $subtitle = get_sub_field('subtitle');
                $description = get_sub_field('description');
                $image = get_sub_field('image');
                $profile = get_sub_field('profile');
                $body_width = get_sub_field('body_width');
                $sweetness_width = get_sub_field('sweetness_width');
                $growing_regions = get_sub_field('growing_regions');

                echo '<div class="content-target" id="content-target-'.get_row_index().'"></div>';

                echo '<div class="content-block" id="content-block-'.get_row_index().'">
                    <div class="image show-for-large">
                        <img src="'.$image['url'].'" alt="'.$image['alt'].'">';

                        if (have_rows('pairings')) {
                            echo '<div class="pairings">';
                            while (have_rows('pairings')) {
                                the_row();
                                $icon = get_sub_field('icon');
                
                                echo '
                                    <img src="'.$icon.'" alt="Category Icon">
                                ';
                            }
                            echo '</div>';
                        }   
                    echo '
                    </div>

                    <div class="content-wrap">
                        <div class="description-title">
                            <span class="heading-2">'.$title.'</span>
                        </div>
                        <div class="image hide-for-large">
                            <img src="'.$image['url'].'" alt="'.$image['alt'].'">';

                            if (have_rows('pairings')) {
                                echo '<div class="pairings">';
                                while (have_rows('pairings')) {
                                    the_row();
                                    $icon = get_sub_field('icon');
                    
                                    echo '
                                        <img src="'.$icon.'" alt="Category Icon">
                                    ';
                                }
                                echo '</div>';
                            }
                        echo 
                        '</div>';
                        
                        echo '<div class="content-row">
                            <div class="title">
                                <span class="heading-4">'.$subtitle.'</span>
                                <p>'.$description.'</p>
                            </div>
                        </div>';

                        echo '<div class="content-row">
                            <div class="title">
                                <span class="heading-4">Profile</span>
                                <p>'.$profile.'</p>
                            </div>
                        </div>';

                        echo '<div class="content-row">
                            <div class="title">
                                <span class="heading-4">Body</span>
                                <div class="progress" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                    <div class="progress-meter" style="width: '.$body_width.';"></div>
                                </div>
                            </div>
                        </div>';

                        echo '<div class="content-row">
                            <div class="title">
                                <span class="heading-4">Sweetness</span>
                                <div class="progress" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                    <div class="progress-meter" style="width: '.$sweetness_width.';"></div>
                                </div>
                            </div>
                        </div>';

                        echo '<div class="content-row">
                            <div class="title">
                                <span class="heading-4">Notable Growing Regions</span>
                                <p>'.$growing_regions.'</p>
                            </div>
                        </div>';

                    echo '
                    </div>
                </div>
                ';
            }
        }
    }
}
$wines = new Wines();
?>


<div class="grid-container full page-wines theme-<?php echo $wines->theme; ?>">
    <div class="wrapper">
        <div class="grid-x container">
            <!-- Navigation -->
            <?php $wines->navigation() ?>

            <div class="intro-description">
                <span class="heading-1"><?php echo $wines->title; ?></span>
                <span class="heading-4"><?php echo $wines->subtitle; ?></span>

                <!-- Varietal Navigation -->
                <?php $wines->varietal_navigation(); ?>
            </div>
            <div class="content-blocks-container">
                <?php $wines->content_blocks(); ?>
            </div>
           
            <!-- Quiz: Category -->
            <?php quiz($wines->quiz_category, $wines->next_page); ?>
        </div>
    </div>
</div>

<?php get_footer();?>