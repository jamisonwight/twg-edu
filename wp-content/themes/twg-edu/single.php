<?php

get_header();

$primary_category = '';
?>

<div class="grid-container product-single">
    <div class="wrapper inner-grid">
        <?php if (have_posts()) : ?>
            <?php while (have_posts()) : the_post(); ?>
                <?php
                    $pid = get_the_id();
                    $permalink = get_permalink($pid);
                    $type = get_field('type', $pid);
                    $price = get_field('price', $pid);
                    $type_branch_image = get_field('type_branch_image', $pid);
                    $name = get_field('name', $pid);
                    $description = get_field('description', $pid);
                    $information = get_field('information', $pid);
                    $purchase_inquiries = get_field('purchase_inquiries', $pid);
                    $style = get_field('style', $pid);
                    $dimensions = get_field('dimensions', $pid);
                    $weight = get_field('weight', $pid);
                    $tree_image = get_field('tree_image', $pid);
                    $origin_city = get_field('origin_city', $pid);
                    $origin_state = get_field('origin_state', $pid);
                    $feature_image = wp_get_attachment_url( get_post_thumbnail_id($pid));
                    $coming_soon = has_category('coming-soon', $pid);
                    $collection_name = get_field('collection_name', $pid);
                    $collection_category = get_field('collection_category', $pid);
                    $collection_description = get_field('collection_description', $pid);
                    $collection_icon = get_field('collection_icon', $pid);
                    $category = get_the_category();
                    $primary_category = get_the_category()[0]->cat_name;
                ?>

                <!-- Intro -->
                <div class="intro">
                    <div class="content hide-for-large">
                        <div class="content-container">
                            <div class="name">
                                <span class="heading-4"><?php echo $name; ?></span>
                            </div>

                            <div class="information">
                                <p class="paragraph-alt"><?php echo $information; ?></p>
                            </div>
                        </div>
                    </div>


                    <div class="slider">
                        <div class="slider-container">
                            <div class="swiper-wrapper">
                                <?php if (have_rows('slides')) : ?>
                                    <?php while (have_rows('slides')) :
                                        the_row();
                                        $slider_image = get_sub_field('image');
                                        ?>
                                        <div class="swiper-slide image">
                                            <img src="<?php echo $slider_image; ?>" alt="Feature Image">
                                        </div>
                                    <?php endwhile; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="bullets-container"></div>
                    </div>

                    <div class="content">
                        <div class="content-container">
                            <div class="name show-for-large">
                                <span class="heading-4"><?php echo $name; ?></span>
                            </div>

                            <div class="information show-for-large">
                                <p class="paragraph-alt"><?php echo $information; ?></p>
                            </div>

                            <div class="description">
                                <p><?php echo $description; ?></p>
                            </div>

                            <div class="details">
                                <div class="column-left">
                                    <img src="<?php echo $tree_image; ?>" alt="Tree Icon">
                                    <span class="heading-7"><?php echo $type; ?></span>
                                </div>

                                <div class="column-center">
                                    <div class="content-top">
                                        <span class="heading-6"><?php echo $collection_name; ?></span>
                                    </div>

                                    <div class="content-bottom">
                                        <div class="dimensions">
                                            <span class="heading-italic">Dimensions</span>
                                            <span class="heading-7"><?php echo $dimensions; ?></span>
                                        </div>

                                        <div class="weight">
                                            <span class="heading-italic">Weight</span>
                                            <span class="heading-7"><?php echo $weight; ?></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="column-right">
                                    <div class="sustainably-sourced">
                                        <img src="<?php echo $type_branch_image; ?>" alt="Collection Image">
                                        <span class="heading-9">Sustainably Sourced</span>
                                        <hr>
                                    </div>

                                    <div class="origin">
                                        <span class="city heading-5"><?php echo $origin_city; ?></span>
                                        <span class="state"><?php echo $origin_state; ?></span>
                                    </div>
                                </div>
                            </div>

                            <div class="purchase-inquiries">
                                <p><?php echo $purchase_inquiries; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>
</div>

<div class="grid-container product-single">
    <div class="wrapper inner-grid">
        <div class="collection-products">
            <div class="collection-content">
                <div class="collection-content-container">
                    <div class="icon">
                        <img src="<?php echo $collection_icon; ?>" alt="Collection Icon">
                    </div>
                    <span class="heading-2"><?php echo $collection_name; ?></span>
                    <hr>
                    <p><?php echo $collection_description; ?></p>
                </div>
            </div>

            <div class="collection-content-wrapper">
                <div class="collection-product-content-container">
                    <?php
                    $collection_loop = new WP_Query(array(
                        'posts_per_page' => -1,
                        'post_type' => 'products',
                        'category_name' => $primary_category,
                    ));
                    ?>
                    <div class="swiper-wrapper">
                        <?php while ( $collection_loop->have_posts() ) : $collection_loop->the_post(); ?>
                        <?php
                        $product_id = get_the_ID();
                        $permalink = get_permalink();
                        $name = get_field('name', $product_id);
                        $type = get_field('type', $product_id);
                        $price = get_field('price', $product_id);
                        $type_branch_image = get_field('type_branch_image', $product_id);
                        $image = wp_get_attachment_url( get_post_thumbnail_id($product_id));
                        $tree_image = get_field('tree_image', $product_id);
                        $collection_name = get_field('collection_name', $product_id);
                        $collection_tree_image = get_field('collection_type_branch_image', $product_id);
                        $coming_soon = has_category('coming-soon', $product_id);
                        $coming_soon_image = get_template_directory_uri().'/assets/images/coming-soon.svg';
                        ?>

                        <?php if ($pid != $product_id) : ?>
                        <div class="collection-product swiper-slide <?php if ($coming_soon) echo 'collection-product-item__coming-soon'; ?>">
                            <?php if (!$coming_soon) : ?><a href="<?php echo $permalink; ?>"><?php endif; ?>
                                <div class="collection-product-item-container">
                                    <div class="collection-product-item-image">
                                        <?php if ($coming_soon) : ?>
                                            <img class="coming-soon" src="<?php echo $coming_soon_image; ?>" alt="Coming Soon Image">
                                        <?php endif; ?>
                                        <img src="<?php echo $image; ?>" alt="<?php echo $name; ?> Product Image">
                                    </div>

                                    <div class="collection-product-item-content">
                                        <?php if (!$coming_soon) : ?>
                                            <div class="divider">
                                                <img src="<?php echo $type_branch_image; ?>" alt="Type Branch Image">
                                            </div>
                                        <?php endif; ?>

                                        <div class="content-container">
                                            <?php if (!$coming_soon) : ?>
                                                <span class="heading-2"><?php echo $collection_name; ?></span>
                                                <span class="heading-4"><?php echo $name; ?></span>
                                                <span class="heading-italic"><?php echo $type; ?> | <?php echo $price; ?></span>
                                            <?php else : ?>
                                                <div class="content-coming-soon">
                                                    <span class="heading-4">COMING SOON</span>
                                                    <span class="heading-italic"><a href="https://www.instagram.com/untold_american_hardwoods/">Follow us</a> <span>on Instagram for updates</span></span>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php if (!$coming_soon) : ?></a><?php endif; ?>
                        </div>
                    <?php endif; ?>
                    <?php endwhile; $collection_loop->wp_reset_postdata(); ?>
                    </div>
                </div>
                <div class="products-navigation">
                    <div class="prev">
                        <img src="<?php echo get_template_directory_uri().'/assets/images/arrow-left.png'; ?>" alt="Previous Arrow Button">
                    </div>
                    <div class="next">
                        <img src="<?php echo get_template_directory_uri().'/assets/images/arrow-right.png'; ?>" alt="Next Arrow Button">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<?php get_footer(); ?>