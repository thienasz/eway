<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Trade_Line
 */

get_header(); ?>

	<div id="k-primary" class="content-area container">
<div class="row">
	<main id="k-main" class="site-main col-sm-8" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'template-parts/content', 'single' ); ?>

			<?php the_post_navigation(); ?>

			<?php
//for use in the loop, list 5 post titles related to first tag on current post
			$tags = wp_get_post_tags($post->ID);
			if ($tags) {
				echo 'Related Posts';
				$first_tag = $tags[0]->term_id;
				$args=array(
					'tag__in' => array($first_tag),
					'post__not_in' => array($post->ID),
					'posts_per_page'=>5,
					'caller_get_posts'=>1
				);
				$my_query = new WP_Query($args);
				if( $my_query->have_posts() ) {
					while ($my_query->have_posts()) : $my_query->the_post(); ?>
						<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a>

						<?php
					endwhile;
				}
				wp_reset_query();
			}
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
</div><!-- #primary -->
</div>

<?php get_footer(); ?>
