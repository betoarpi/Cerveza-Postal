<?php
/**
 * The Template for displaying all single posts.
 *
 * @package Trizzy
 */

get_header(); ?>
<section class="titlebar">
<div class="container">
	<div class="sixteen columns">
		<h1><?php the_title(); ?></h1>

		<nav id="breadcrumbs">
             <?php if(ot_get_option('pp_breadcrumbs','on') == 'on') echo dimox_breadcrumbs(); ?>
        </nav>
	</div>
</div>
</section>
<?php $layout  = get_post_meta($post->ID, 'pp_sidebar_layout', true); ?>

<!-- Container -->
<div class="container <?php echo $layout; ?>">
	<div class="twelve columns">
		<div class="extra-padding">
			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'single' ); ?>

				<?php trizzy_post_nav(); ?>

				<?php
					// If comments are open or we have at least one comment, load up the comment template
					if ( comments_open() || '0' != get_comments_number() ) :
						comments_template();
					endif;
				?>

			<?php endwhile; // end of the loop. ?>

		</div>
	</div>
	<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>