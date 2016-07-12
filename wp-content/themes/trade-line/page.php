<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Trade_Line
 */

get_header(); ?>

	<div id="k-primary" class="content-area container">
		<div class="row">
			<main id="k-main" class="site-main col-sm-8" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'template-parts/content', 'page' ); ?>

				<?php
					// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
					endif;
				?>

			<?php endwhile; // End of the loop. ?>

		</main><!-- #main -->
			<div class="col-sm-4">

				<?php
				/**
				 * Hook - trade_line_action_sidebar.
				 *
				 * @hooked: trade_line_add_sidebar - 10
				 */
				do_action( 'trade_line_action_sidebar' );
				?>
			</div>
		</div>
	</div><!-- #primary -->

<?php get_footer(); ?>
