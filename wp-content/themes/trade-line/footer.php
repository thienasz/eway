<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Trade_Line
 */

	/**
	 * Hook - trade_line_action_after_content.
	 *
	 * @hooked trade_line_content_end - 10
	 */
	do_action( 'trade_line_action_after_content' );
?>

	<?php
	/**
	 * Hook - trade_line_action_before_footer.
	 *
	 * @hooked trade_line_footer_start - 10
	 */
	do_action( 'trade_line_action_before_footer' );
	?>
    <?php
	  /**
	   * Hook - trade_line_action_footer.
	   *
	   * @hooked trade_line_footer_copyright - 10
	   */
	  do_action( 'trade_line_action_footer' );
	?>
	<?php
	/**
	 * Hook - trade_line_action_after_footer.
	 *
	 * @hooked trade_line_footer_end - 10
	 */
	do_action( 'trade_line_action_after_footer' );
	?>

<?php
	/**
	 * Hook - trade_line_action_after.
	 *
	 * @hooked trade_line_page_end - 10
	 * @hooked trade_line_footer_goto_top - 20
	 */
	do_action( 'trade_line_action_after' );
?>

<!-- jQuery -->
<script src="<?php bloginfo('template_directory'); ?>/jQuery/jquery-2.1.1.min.js"></script>
<script src="<?php bloginfo('template_directory'); ?>/jQuery/jquery-migrate-1.2.1.min.js"></script>

<!-- Bootstrap -->
<script src="<?php bloginfo('template_directory'); ?>/bootstrap/js/bootstrap.min.js"></script>

<!-- Drop-down -->
<script src="<?php bloginfo('template_directory'); ?>/js/dropdown-menu/dropdown-menu.js"></script>

<!-- Fancybox -->
<script src="<?php bloginfo('template_directory'); ?>/js/fancybox/jquery.fancybox.pack.js"></script>
<script src="<?php bloginfo('template_directory'); ?>/js/fancybox/jquery.fancybox-media.js"></script><!-- Fancybox media -->

<!-- Responsive videos -->
<script src="<?php bloginfo('template_directory'); ?>/js/jquery.fitvids.js"></script>

<!-- Pie charts -->
<script src="<?php bloginfo('template_directory'); ?>/js/jquery.easy-pie-chart.js"></script>

<!-- Theme -->
<script src="<?php bloginfo('template_directory'); ?>/js/theme.js"></script>
<script>
	$(window).bind('scroll', function () {
		if ($(window).scrollTop() > $('#masthead').outerHeight()) {
			$('#main-nav').addClass('f-menu');
		} else {
			$('#main-nav').removeClass('f-menu');
		}
	});
</script>
<?php wp_footer(); ?>
</body>
</html>
