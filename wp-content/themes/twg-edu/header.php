<?php
/**
 * The template for displaying the header
 *
 * This is the template that displays all of the <head> section
 *
 */
?>

<!doctype html>

<html class="no-js" <?php language_attributes(); ?>>

<head>
	<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-1QNL94WKHC"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-1QNL94WKHC');
</script>
    <title><?php wp_title(); ?></title>
    <meta charset="utf-8">

    <!-- Force IE to use the latest rendering engine available -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Mobile Meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta class="foundation-mq">

    <!-- Favicons -->
    <link rel="icon" type="image/svg+xml" href="/wp-content/themes/untold/assets/images/favicon.svg">
    <link rel="icon" type="image/png" href="/wp-content/themes/untold/assets/images/favicon.svg">


    <!-- Share This -->
    <script type='text/javascript' src='https://platform-api.sharethis.com/js/sharethis.js#property=60db7e150081ca0012478261&product=sop' async='async'></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.debug.js" ></script>
    
    <!-- If Site Icon isn't set in customizer -->
    <!--
		<?php if (!function_exists('has_site_icon') || !has_site_icon()) { ?>
	
			<link rel="icon" href="<?php echo get_template_directory_uri(); ?>/favicon.png">
			<link href="<?php echo get_template_directory_uri(); ?>/assets/images/apple-icon-touch.png" rel="apple-touch-icon" />	
	    <?php 
	} ?>
-->

    <link rel="stylesheet" href="https://use.typekit.net/cls6vgr.css">

    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous"

    <?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>

    <header class="header" role="banner">
        <div class="wrapper">
            <?php get_template_part('parts/nav', 'title-bar') ?>
        </div>
    </header> <!-- end .header -->