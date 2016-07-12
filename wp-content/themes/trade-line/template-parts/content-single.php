<?php
/**
 * Template part for displaying single posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Trade_Line
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

		<div class="entry-meta">
			<?php trade_line_posted_on(); ?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<div class="entry-content">
    <?php
	  /**
	   * Hook - trade_line_single_image.
	   *
	   * @hooked trade_line_add_image_in_single_display -  10
	   */
	  do_action( 'trade_line_single_image' );
	?>
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'trade-line' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php trade_line_entry_footer(); ?>
	</footer><!-- .entry-footer -->
	<?php
		/**
		 * Hook - trade_line_author_bio.
		 *
		 * @hooked trade_line_add_author_bio_in_single -  10
		 */
		do_action( 'trade_line_author_bio' );
	?>

</article><!-- #post-## -->

