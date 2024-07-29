<?php /** Template Name: Serving Wine 101 */?>

<?php get_header();?>

<?php
class Serving {
    public $serving_title,
           $serving_subtitle,
           $serving_content_blocks,
           $serving_next_page,
           $next_page_title,
           $next_page,
           $next_page_icon_class,
           $prev_page_title,
           $prev_page,
           $prev_page_icon_class;

    function __construct() {
        $this->serving_title = get_field('serving_title');
        $this->serving_subtitle = get_field('serving_subtitle');
        $this->serving_next_page = get_field('next_page');
        $this->next_page_title = get_field('next_page_title');
        $this->next_page = get_field('next_page');
        $this->next_page_icon_class = get_field('next_page_icon_class');
        $this->prev_page_title = get_field('prev_page_title');
        $this->prev_page = get_field('prev_page');
        $this->prev_page_icon_class = get_field('prev_page_icon_class');
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
                $image = get_sub_field('image');

                echo '<div class="content-target" id="content-target-'.get_row_index().'"></div>';

                echo '<div class="content-block" id="content-block-'.get_row_index().'">
                    <div class="image show-for-large">
                        <img src="'.$image['url'].'" alt="'.$image['alt'].'">
                    </div>
                    <div class="content-wrap">
                        <div class="description-title">
                            <span class="heading-2">'.$title.'</span>
                        </div>
                        <div class="image hide-for-large">
                            <img src="'.$image['url'].'" alt="'.$image['alt'].'">
                        </div>';
                        

                        if (have_rows('content_rows')) {
                            while (have_rows('content_rows')) {
                                the_row();
                
                                $row_title = get_sub_field('title');
                                $row_description = get_sub_field('description');
                
                                echo '<div class="content-row">
                                    <div class="title">
                                        <span class="heading-4">'.$row_title.'</span>
                                        <p>'.$row_description.'</p>
                                    </div>
                                </div>';
                            }
                        }
                echo '
                    </div>
                </div>
                ';
            }
        }
    }
}
$serving = new Serving();
?>

<div class="grid-container full page-serving">
    <div class="wrapper">
        <div class="grid-x container">
            <!-- Navigation -->
            <?php $serving->navigation() ?>

            <div class="intro-description">
                <span class="heading-1"><?php echo $serving->serving_title; ?></span>
                <span class="heading-4"><?php echo $serving->serving_subtitle; ?></span>

                <!-- Varietal Navigation -->
                <?php $serving->varietal_navigation(); ?>
            </div>
            <div class="content-blocks-container">
                <?php echo $serving->content_blocks(); ?>
            </div>
           
            <!-- Quiz: Category -->
            <?php quiz('serving wine 101', $serving->next_page); ?>
        </div>
    </div>
</div>

<?php get_footer();?>