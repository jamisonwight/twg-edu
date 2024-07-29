<?php
	
// Adding WP Functions & Theme Support
function joints_theme_support() {

	// Add WP Thumbnail Support
	add_theme_support( 'post-thumbnails' );
	
	// Default thumbnail size
	set_post_thumbnail_size(125, 125, true);

	// Add RSS Support
	add_theme_support( 'automatic-feed-links' );
	
	// Add Support for WP Controlled Title Tag
	add_theme_support( 'title-tag' );
	
	// Add HTML5 Support
	add_theme_support( 'html5', 
	         array( 
	         	'comment-list', 
	         	'comment-form', 
	         	'search-form', 
	         ) 
	);
	
	add_theme_support( 'custom-logo', array(
		'height'      => 100,
		'width'       => 400,
		'flex-height' => true,
		'flex-width'  => true,
		'header-text' => array( 'site-title', 'site-description' ),
	) );
	
	// Adding post format support
	 add_theme_support( 'post-formats',
		array(
			'aside',             // title less blurb
			'gallery',           // gallery of images
			'link',              // quick link to other site
			'image',             // an image
			'quote',             // a quick quote
			'status',            // a Facebook like status update
			'video',             // video
			'audio',             // audio
			'chat'               // chat transcript
		)
	); 

	
	// Set the maximum allowed width for any content in the theme, like oEmbeds and images added to posts.
	$GLOBALS['content_width'] = apply_filters( 'joints_theme_support', 1200 );	
	
} /* end theme support */

add_action( 'after_setup_theme', 'joints_theme_support' );


if( function_exists('acf_add_options_page') ) {
   acf_add_options_page();
}

function wordpress_numeric_post_nav() {
    if( is_singular() )
        return;
    global $wp_query;
    /* Stop the code if there is only a single page page */
    if( $wp_query->max_num_pages <= 1 )
        return;
    $paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
    $max   = intval( $wp_query->max_num_pages );
    /*Add current page into the array */
    if ( $paged >= 1 )
        $links[] = $paged;
    /*Add the pages around the current page to the array */
    if ( $paged >= 3 ) {
        $links[] = $paged - 1;
        $links[] = $paged - 2;
    }
    if ( ( $paged + 2 ) <= $max ) {
        $links[] = $paged + 2;
        $links[] = $paged + 1;
    }
    echo '<div class="navigation"><ul>' . "\n";
    /*Display Previous Post Link */
    if ( get_previous_posts_link() )
        printf( '<li class="prev">%s</li>' . "\n", get_previous_posts_link($link = '<span class="heading-4">Previous</span>') );
    /*Display Link to first page*/
    if ( ! in_array( 1, $links ) ) {
        $class = 1 == $paged ? ' class="active"' : '';
        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( 1 ) ), '1' );
        if ( ! in_array( 2, $links ) )
            echo '<li>…</li>';
    }
    /* Link to current page */
    sort( $links );
    foreach ( (array) $links as $link ) {
        $class = $paged == $link ? ' class="active"' : '';
        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $link ) ), $link );
    }
    /* Link to last page, plus ellipses if necessary */
    if ( ! in_array( $max, $links ) ) {
        if ( ! in_array( $max - 1, $links ) )
            echo '<li>…</li>' . "\n";
        $class = $paged == $max ? ' class="active"' : '';
        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $max ) ), $max );
    }
    /** Next Post Link */
    if ( get_next_posts_link() )
        printf( '<li class="next">%s</li>' . "\n", get_next_posts_link($link = '<span class="heading-4">Next</span>') );
    echo '</ul></div>' . "\n";
}

add_filter('script_loader_tag', 'add_defer_tags_to_scripts');

function add_defer_tags_to_scripts($tag){

    # List scripts to add attributes to
    $scripts_to_defer = array('main.js');
    // $scripts_to_async = array('script_c', 'script_d');
 
    # add the defer tags to scripts_to_defer array
    foreach($scripts_to_defer as $current_script){
        if(true == strpos($tag, $current_script))
             return str_replace(' src', ' defer="defer" src', $tag);
    }
     
    return $tag;
 }


 add_filter('matador_template_button_classes', 'add_theme_button_classes');
function add_theme_button_classes( $classes ){
    // add the classes used by your theme to the default Matador classes
    return $classes . ' btn-default';
}


function matador_tutorial_application_fields( $fields ) {
	$fields['name']['attributes']['placeholder'] = 'First Name*';
    $fields['email']['attributes']['placeholder'] = 'Email*';
    $fields['phone']['attributes']['placeholder'] = 'Phone*'; 
	return $fields;
}
add_filter( 'matador_application_fields_structure', 'matador_tutorial_application_fields' );


function get_post_primary_category($post_id, $term='category', $return_all_categories=false){
    $return = array();

    if (class_exists('WPSEO_Primary_Term')){
        // Show Primary category by Yoast if it is enabled & set
        $wpseo_primary_term = new WPSEO_Primary_Term( $term, $post_id );
        $primary_term = get_term($wpseo_primary_term->get_primary_term());

        if (!is_wp_error($primary_term)){
            $return['primary_category'] = $primary_term;
        }
    }

    if (empty($return['primary_category']) || $return_all_categories){
        $categories_list = get_the_terms($post_id, $term);

        if (empty($return['primary_category']) && !empty($categories_list)){
            $return['primary_category'] = $categories_list[0];  //get the first category
        }
        if ($return_all_categories){
            $return['all_categories'] = array();

            if (!empty($categories_list)){
                foreach($categories_list as &$category){
                    $return['all_categories'][] = $category->term_id;
                }
            }
        }
    }

    return $return;
}

add_action('login_enqueue_scripts', function(){
    wp_dequeue_script('user-profile');
    wp_dequeue_script('password-strength-meter');
    wp_deregister_script('user-profile');

    $suffix = SCRIPT_DEBUG ? '' : '.min';
    wp_enqueue_script( 'user-profile', "/wp-admin/js/user-profile$suffix.js", array( 'jquery', 'wp-util' ), false, 1 );
});

function uilogin_func( $args ) {
    $a = shortcode_atts( array(
        'echo' => true,
        'remember' => true,
        'redirect' =>  get_site_url().'/resources',
        'form_id' => 'loginform',
        'id_username' => 'user_login',
        'id_password' => 'user_pass',
        'id_remember' => 'rememberme',
        'id_submit' => 'wp-submit',
        'label_username' => __( 'Username or Email Address' ),
        'label_password' => __( 'Password' ),
        'label_remember' => __( 'Remember Me' ),
        'placeholder_username' => __( 'username' ),
        'placeholder_password' => __( 'password' ),
        'label_log_in' => __( 'Log In' ),
        'value_username' => '',
        'value_remember' => false
    ), $args );

    wp_login_form( $a );
}
add_shortcode( 'uilogin', 'uilogin_func' );

function Redirect($url, $code = 302){
    if (strncmp('cli', PHP_SAPI, 3) !== 0) {
        if (headers_sent() !== true) {
            if (strlen(session_id()) > 0) {// if using sessions
                session_regenerate_id(true); // avoids session fixation 	attacks
                session_write_close(); // avoids having sessions lock other requests
            }

            if (strncmp('cgi', PHP_SAPI, 3) === 0) {
                header(sprintf('Status: %03u', $code), true, $code);
            }

            header('Location: ' . $url, true, (preg_match('~^30[1237]$~', $code) >  0) ? $code : 302);
        }
        exit();
    }
}

add_action( 'login_form_middle', 'add_lost_password_link' );
function add_lost_password_link() {
    return '<a href="/wp-login.php?action=lostpassword">Lost Password?</a>';
}

function yoast_primary_cat_as_first_cat($categories) {
    
    // Check if yoast exists and get the primary category
    if ($categories && class_exists('WPSEO_Primary_Term') ) {

        // Show the post's 'Primary' category, if this Yoast feature is available, & one is set
        $wpseo_primary_term = new WPSEO_Primary_Term( 'category', get_the_id() );
        $wpseo_primary_term = $wpseo_primary_term->get_primary_term();
        $term = get_term( $wpseo_primary_term );
    
        // If no error is returned, get primary yoast term 
        $primary_cat_term_id = (!is_wp_error($term)) ? $term->term_id : null;

        // Loop all categories
        if($primary_cat_term_id !== null) {
            foreach ($categories as $i => $category) {

                // Move the primary category to the top of the array
                if($category->term_id === $primary_cat_term_id) {

                    $out = array_splice($categories, $i, 1);
                    array_splice($categories, 0, 0, $out);

                    break;
                }
            }
        }
    } 
    
    return $categories;
}
add_filter( 'get_the_categories', 'yoast_primary_cat_as_first_cat' );