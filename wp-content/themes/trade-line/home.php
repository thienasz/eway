<?php
/**
 * The main template file.
 *
 * @package Trade_Line
 */

get_header(); ?>

	<div id="k-primary" class="content-area">
		<main id="k-main" class="site-main container " role="main">
			<!--slider-->
			<div class="row no-gutter fullwidth"><!-- row -->

				<div class="col-lg-12 clearfix"><!-- featured posts slider -->

					<div id="carousel-featured" class="carousel slide" data-interval="4000" data-ride="carousel">
						<!-- featured posts slider wrapper; auto-slide -->

						<ol class="carousel-indicators"><!-- Indicators -->
							<!--                    create sql -->
							<?php
							// going off on my own here
							wp_reset_query();
							$args_my_query = array(
								'category_name' => 'slider-post',
								'posts_per_page' => '5',
							);
							$my_query = new WP_Query($args_my_query); ?>
							<li data-target="#carousel-featured" data-slide-to="0" class="active"></li>
							<?php for ($i = 1; $i < $my_query->post_count; $i++) { ?>
								<li data-target="#carousel-featured" data-slide-to="<?php echo $i ?>"></li>
							<?php } ?>
						</ol><!-- Indicators end -->

						<div class="carousel-inner"><!-- Wrapper for slides -->
							<!--                start loop -->
							<?php
							if ($my_query->have_posts()) {
								$i = 0; ?>
								<?php while ($my_query->have_posts()) {
									$my_query->the_post();
									$image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'single-post-thumbnail');
									?>
									<div class="item <?php if ($i == 0) echo 'active';
									$i++; ?>">
										<img
											src="<?php
											echo $image[0]; ?>"
											alt="<?php the_title() ?>"/>
										<div class="k-carousel-caption <?php
										if ($i == ($my_query->post_count)) echo 'pos-c-2-3 scheme-dark no-bg';
										else if ($i % 2 == 1)
											echo ' pos-' . rand(1, 2) . '-3-right scheme-dark';
										else
											echo ' pos-' . rand(1, 2) . '-3-left scheme-light';
										?>">
											<div class="caption-content">
												<h3 class="caption-title"><?php the_title() ?></h3>
												<p>
													<?php the_excerpt_max_length(150) ?>
												</p>
												<p>
													<a href="<?php echo get_permalink( $post->ID ); ?>" class="btn btn-sm btn-danger btn-k-cus" title="Button">READ MORE</a>
												</p>
											</div>
										</div>
									</div>
								<?php } ?>
							<?php }
							?>
						</div><!-- Wrapper for slides end -->

						<!-- Controls -->
						<a class="left carousel-control" href="#carousel-featured" data-slide="prev"><i
								class="fa fa-chevron-left"></i></a>
						<a class="right carousel-control" href="#carousel-featured" data-slide="next"><i
								class="fa fa-chevron-right"></i></a>
						<!-- Controls end -->

					</div><!-- featured posts slider wrapper end -->

				</div><!-- featured posts slider end -->

			</div><!-- row end -->
			<!--end slider-->

		</main><!-- #main -->
	</div><!-- #primary -->
<?php
/**
 * Hook - trade_line_action_before_content.
 *
 * @hooked trade_line_add_breadcrumb - 7
 * @hooked trade_line_content_start - 10
 */
do_action( 'trade_line_action_before_content' );
?>
<?php
/**
 * Hook - trade_line_action_before_content.
 *
 * @hooked trade_line_add_breadcrumb - 7
 * @hooked trade_line_content_start - 10
 */
do_action( 'trade_line_action_before_content_2' );
?>
<?php
/**
 * Hook - trade_line_action_content.
 */
do_action( 'trade_line_action_content' );
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.isotope/2.2.2/isotope.pkgd.min.js"></script>
<script src="https://npmcdn.com/imagesloaded@4.1/imagesloaded.pkgd.js"></script>
<script type="text/javascript">
	jQuery(document).ready(function ($) {
		$('#main-article').isotope({
			// set itemSelector so .grid-sizer is not used in layout
			itemSelector: '.grid-item',
			percentPosition: true,
			masonry: {
				// use element for option
				columnWidth: '.grid-sizer'
			}
		})


		var $container = $('#main-article'),
			colWidth = function () {
				var w = $container.width(),
					columnNum = 1,
					columnWidth = 0;
				if (w > 1200) {
					columnNum = 4;
				} else if (w > 900) {
					columnNum = 3;
				} else if (w > 600) {
					columnNum = 2;
				} else if (w > 300) {
					columnNum = 1;
				}
				columnWidth = Math.floor(w / columnNum);
				$container.find('.grid-item').each(function () {
					var $item = $(this),
						multiplier_w = $item.attr('class').match(/item-w(\d)/),
						multiplier_h = $item.attr('class').match(/item-h(\d)/),
						width = multiplier_w ? columnWidth * multiplier_w[1] - 10 : columnWidth - 10,
						height = multiplier_h ? columnWidth * multiplier_h[1] * 0.5 - 40 : columnWidth * 0.5 - 40;
					$item.css({
						width: width,
						//height: height
					});
				});
				return columnWidth;
			},

			isotope = function () {

				$container.imagesLoaded(function () {
					$container.isotope({
						resizable: false,
						itemSelector: '.grid-item',
						masonry: {
							columnWidth: colWidth(),
							gutterWidth: 20
						}

					});
				});
			};
		isotope();
	});

	(function ($) {
		$(document).ready(function () {
			$('#sidebar li.widget.widget_nav_menu > div  ul  li > a').click(function () {
				$('#sidebar li.widget.widget_nav_menu > div li').removeClass('active');
				$(this).closest('li').addClass('active');
				var checkElement = $(this).next();
				var checkBeforeElement = $(this).parent().parent();
				console.log(checkBeforeElement);
//                console.log(checkBeforeElement.text());
//                var close =  $('#sidebar li.widget.widget_nav_menu > div > ul > li ul').css('display','none');
				if ((checkElement.is('ul')) && (checkElement.is(':visible'))) {
					$(this).closest('li').removeClass('active');
					checkElement.slideUp('normal');
				}
				if ((checkElement.is('ul')) && (!checkElement.is(':visible')) && (checkBeforeElement.hasClass("sub-menu"))) {
					checkElement.slideDown('normal');
				}
				if ((checkElement.is('ul')) && (!checkElement.is(':visible'))) {
					$('#sidebar li.widget.widget_nav_menu > div ul ul:visible').slideUp('normal');
					checkElement.slideDown('normal');
				}
				if ($(this).closest('li').find('ul').children().length == 0) {
					return true;
				} else {
					return false;
				}
			});
		});
	})(jQuery);
</script>
<?php get_footer(); ?>
