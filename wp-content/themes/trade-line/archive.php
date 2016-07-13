<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Trade_Line
 */

get_header(); ?>

	<div id="k-primary" class="content-area container">
		<div class="row">
		<main id="k-main" class="site-main col-sm-8" role="main">

		<?php if ( have_posts() ) : ?>

			<header class="k-header">
				<?php
					the_archive_title( '<h1 class="k-page-title">', '</h1>' );
					the_archive_description( '<div class="taxonomy-description">', '</div>' );
				?>
			</header><!-- .page-header -->

			<?php /* Start the Loop */
			$i= 0;
			$count = count(get_posts());
			?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php
					/*
					 * Include the Post-Format-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
				$a = $i % 3;
				$b = $i % 6;
				if($b == 0 && $i != 0){
					echo '</div>';
					get_template_part( 'template-parts/content', get_post_format() );

				} elseif ($a == 0 ){
					if($i == 3) echo '</div>';
					echo '<div class="haiz clearfix">';
					get_template_part( 'template-parts/content', get_post_format() );

				} elseif(($i+1) == $count && $i > 3) {
					get_template_part( 'template-parts/content', get_post_format() );
					echo '</div>';
				} else {
					get_template_part( 'template-parts/content', get_post_format() );
				}
				$i++;

				?>

			<?php endwhile; ?>

		<?php
		/**
		 * Hook - trade_line_action_posts_navigation.
		 *
		 * @hooked: trade_line_custom_posts_navigation - 10
		 */
		do_action( 'trade_line_action_posts_navigation' ); ?>


		<?php else : ?>

			<?php get_template_part( 'template-parts/content', 'none' ); ?>

		<?php endif; ?>

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
