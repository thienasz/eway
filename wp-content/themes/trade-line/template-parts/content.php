<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Trade_Line
 */

?>

<div class="box-article-wrapper ">
	<article id="post-<?php the_ID(); ?>" class="col-sm-4 box-article">
		<div class="entry-content">
			<?php if ( has_post_thumbnail() ) { ?>

				<?php
				$archive_image           = trade_line_get_option( 'archive_image' );
				$archive_image_alignment = trade_line_get_option( 'archive_image_alignment' );
				?>
					<a href="<?php the_permalink(); ?>">
					<?php the_post_thumbnail( esc_attr( $archive_image ), array( 'class' => 'align'. esc_attr( $archive_image_alignment ) ) ); ?>
					</a>

			<?php } else { ?>
				<a href="<?php the_permalink(); ?>">
					<img src="<?php bloginfo('template_directory'); ?>/images/noimg.jpg" class="aligncenter wp-post-image">
				</a>
			<?php } ?>
		</div><!-- .entry-content -->
		<footer class="entry-footer">
			<?php the_title( sprintf( '<h3 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>
		</footer><!-- .entry-footer -->
	</article><!-- #post-## -->
</div>
