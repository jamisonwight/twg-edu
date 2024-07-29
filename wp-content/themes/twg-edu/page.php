<?php 
/**
 * The template for displaying all pages
 *
 * This is the template that displays all the pages by default.
 */

get_header(); ?>
	
	<div class="grid-x content-page page-default">
		<div class="inner-grid-small">
			<div class="content-container">
				<?php if (have_posts()) : 
					while (have_posts()) : the_post(); ?>
						<?php the_content(); ?>
					<?php endwhile; ?>
				<?php endif; ?>
			</div>
		</div>
	</div>

<?php get_footer(); ?>