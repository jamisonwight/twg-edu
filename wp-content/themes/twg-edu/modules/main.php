<!-- For each module add a name for indexing -->
<?php
    $modules = [
        'split_image_slider_content',
        'hero',
        'instagram_feed',
        'products',
        'banner',
    ];

    $moduleIndex = array();
    foreach ($modules as $module) {
        $moduleIndex[$module] = -1;
    }

    if ( have_rows('modules') ) {
        while (have_rows('modules')) {
            the_row();

            foreach ($modules as $module) {
                if (get_row_layout() == $module) {
                    $moduleIndex[$module]++;
                    include 'templates/'.$module.'.php';
                }
            }
        }
    }