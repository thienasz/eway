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

<!--			--><?php //the_post_navigation(); ?>

			<div class="relatedposts">
				<h3 class="bt0">CÁC TIN KHÁC:</h3>
				<div class="box-relate top5">
				<?php
				$orig_post = $post;
				global $post;
				$tags = wp_get_post_tags($post->ID);
				$cates = wp_get_post_categories($post->ID);

				if (!empty($tags) || !empty($cates)) {
					if(!empty($tags)){
						$tag_ids = array();
						foreach($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;
						$args=array(
							'tag__in' => $tag_ids,
							'post__not_in' => array($post->ID),
							'posts_per_page'=>4, // Number of related posts to display.
							'caller_get_posts'=>1
						);
					} else {
						$args=array(
							'category__in' => $cates,
							'post__not_in' => array($post->ID),
							'posts_per_page'=>4, // Number of related posts to display.
							'caller_get_posts'=>1
						);
					}
					$my_query = new wp_query( $args );
					while( $my_query->have_posts() ) {
						$my_query->the_post();
						?>
						<?php if(!empty(get_the_title())) {?>
						<div class="relatedthumb">
							<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><i class="fa fa-circle"></i> &nbsp;<span><?php the_title(); ?></span></a>
						</div>
<?php } ?>
					<? }
				}
				$post = $orig_post;
				wp_reset_query();
				?>
				</div>
			</div>

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
