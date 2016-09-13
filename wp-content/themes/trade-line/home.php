<?php
/**
 * The main template file.
 *
 * @package Trade_Line
 */

get_header(); ?>

	<div id="khome-primary" class="content-area">
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
								'category_name' => get_option('value_section_3'),
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
										<img style="max-height: 400px; min-height: 400px"
											src="<?php
											if($image[0]) {
												echo $image[0];
											} else { ?>
												<?php bloginfo('template_directory'); ?>/images/slider-default.jpg"
											<?php } ?>"
											alt="<?php the_title() ?>"/>
										<div class="k-carousel-caption <?php
										if ($i == ($my_query->post_count)) echo 'pos-c-2-3 scheme-dark box-33';
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
			<br class="clear">
			<section class="goal">
				<h1><i class="fa fa-quote-left"></i> <?php echo get_option('title_section_1') ?> <i class="fa fa-quote-right"></i></h1>
				<!--<p>	A (free) responsive site template by <a href="http://html5up.net">HTML5 UP</a>.
                        Built on skel and released under the <a href="http://html5up.net/license">CCA</a> license.-->
				<p></p>
			</section>
			<div class="body">
				<div class="body_home clearfix">
					<div class="box_content_home clearfix">
						<div class="box_product col-md-12 no-padding clearfix">
							<?php
							// going off on my own here
							wp_reset_query();
							$args_my_query = array(
								'category_name' => get_option('value_section_1'),
								'posts_per_page' => '4',
							);
							$my_query = new WP_Query($args_my_query); ?>
							<?php
							if ($my_query->have_posts()) {
								$i = 0; ?>
								<?php while ($my_query->have_posts()) {
									$my_query->the_post();
									$image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'single-post-thumbnail');
									?>
							<div class="col-lg-3 col-md-6 col-sm-12">
								<div class="">
									<a href="<?php echo get_permalink($post->ID) ?>" title="<?php the_title()?>">
										<?php
										if (has_post_thumbnail()) { // check if the post has a Post Thumbnail assigned to it.
											the_post_thumbnail('large');
										} else { ?>
											<img src="<?php bloginfo('template_directory'); ?>/images/noimg.jpg"" alt="<?php the_title()?>" name="<?php the_title()?>" width="100%">
										<?php } ?>
									</a>
									<br class="clear">
								</div>
								<div class="w292_title top10">
									<a href="<?php echo get_permalink($post->ID) ?>" title="<?php the_title()?>"><?php the_title()?></a>
								</div>
								<div class="w292_des">
									<p class="top5 bt0" style="color:#000000"><?php the_excerpt_max_length(150) ?></p>
									<p class="latest-news-read-more"><a href="<?php echo get_permalink($post->ID) ?>" class="read-more" title="a">Read more</a></p>
								</div>
							</div>
								<?php } ?>
							<?php }
							?>
						</div>
					</div>
					<div class="clear"></div>
				</div>
				<div class="widget trade_line_widget_call_to_action"><h2 class="widget-title"><span>Đăng Ký Khóa Học</span></h2>			<div class="call-to-action-content">
						<p>
							Đăng ký để nhận tư vấn và học trải nghiệm 03 buổi MIỄN PHÍ khóa AA và BB S tại Eway
						</p>
					</div><!-- .call-to-action-content -->
					<div class="call-to-action-buttons">
						<a href="#" class="button cta-button cta-button-primary">Đăng ký</a>
					</div><!-- .call-to-action-buttons -->

				</div>
				<br class="clear">

				<div class="box_product_3">
					<?php
					// going off on my own here
					wp_reset_query();
					$args_my_query = array(
						'category_name' => get_option('value_section_21'),
						'posts_per_page' => '5',
						'meta_key' => 'malked_post',
						'orderby' => array( 'meta_value' => 'DESC', 'modified' => 'DESC' ) ,
					);
					$my_query = new WP_Query($args_my_query);
					?>

					<h2><?php echo get_option('title_section_2') ?></h2>
					<div class="col-md-12">
						<div class="hot_news_wapper col-md-12 col-lg-6">
							<h3><?php echo get_option('title_section_21') ?></h3>
							<!--            <br class="clear">-->
							<?php
							if ($my_query->have_posts()) {
								$i = 0; ?>
								<?php while ($my_query->have_posts()) {
									$my_query->the_post();
									$image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'single-post-thumbnail');
									?>
									<div class="col_news col-md-12 no-padding">
										<?php if( $my_query->current_post == 0) { ?>
										<div class="hot_news_img col-md-6 col-sm-12 no-padding margin-bottom">
											<a href="<?php echo get_permalink($post->ID) ?>" title="<?php the_title()?>"><img src="
											<?php
												if (has_post_thumbnail()) { // check if the post has a Post Thumbnail assigned to it.
													the_post_thumbnail_url('medium');
												} else { ?>
										<?php bloginfo('template_directory'); ?>/images/noimg.jpg"
												<?php } ?>
											" alt="<?php the_title()?>" name="<?php the_title()?>" width="100%"></a>
										</div>

										<div class="hot_news_des col-md-6 col-sm-12">
											<a class="k-title" href="<?php echo get_permalink($post->ID) ?>" title="<?php the_title()?>"><span><?php the_title()?></span></a>
											<p class="top5 bt0"> <?php the_excerpt_max_length(150) ?></p>
											<p class="latest-news-read-more"><a href="<?php echo get_permalink($post->ID) ?>" class="read-more" title="a">Read more</a></p>
										</div>
												<?php } else { ?>
													<li><a href="<?php echo get_permalink($post->ID) ?>" title="<?php the_title()?>"><i class="fa fa-caret-right"></i> &nbsp; <span><?php the_title()?></span></a></li>
												<?php } ?>
									</div>
								<?php } ?>
							<?php }
							?>
							<div class="clear"></div>
						</div>
						<div class="hot_news_wapper col-md-12 col-lg-6">
							<?php
							// going off on my own here
							wp_reset_query();
							$args_my_query = array(
								'category_name' => get_option('value_section_22'),
								'posts_per_page' => '5',
								'meta_key' => 'malked_post',
								'orderby' => array( 'meta_value' => 'DESC', 'modified' => 'DESC' ) ,
							);
							$my_query = new WP_Query($args_my_query);
							?>
							<h3><?php echo get_option('title_section_22') ?> </h3>
							<div class="col_news col-md-12 no-padding">
								<?php
								if ($my_query->have_posts()) {
									$i = 0; ?>
									<?php while ($my_query->have_posts()) {
										$my_query->the_post();
										$image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'single-post-thumbnail');
										?>
										<div class="col_news col-md-12 no-padding">
											<?php if( $my_query->current_post == 0) { ?>
											<div class="hot_news_img col-md-6 col-sm-12 no-padding margin-bottom">
												<a href="<?php echo get_permalink($post->ID) ?>" title="<?php the_title()?>"><img src="
												<?php
													if (has_post_thumbnail()) { // check if the post has a Post Thumbnail assigned to it.
														the_post_thumbnail_url('medium');
													} else { ?>
										<?php bloginfo('template_directory'); ?>/images/noimg.jpg"
													<?php } ?>
												" alt="<?php the_title()?>" name="<?php the_title()?>" width="100%"></a>
											</div>

											<div class="hot_news_des col-md-6 col-sm-12">
												<a class="k-title" href="<?php echo get_permalink($post->ID) ?>" title="<?php the_title()?>"><span><?php the_title()?></span></a>
												<p class="top5 bt0"> <?php the_excerpt_max_length(150) ?></p>
												<p class="latest-news-read-more"><a href="<?php echo get_permalink($post->ID) ?>" class="read-more" title="a">Read more</a></p>
											</div>

											<div class="other_news col-md-12">
												<ul>
													<?php } else { ?>
														<li><a href="<?php echo get_permalink($post->ID) ?>" title="<?php the_title()?>"><i class="fa fa-caret-right"></i> &nbsp; <span><?php the_title()?></span></a></li>
													<?php } ?>
													<?php if( $my_query->current_post == 0) { ?>
												</ul>
											</div>
										<?php } ?>
										</div>
									<?php } ?>
								<?php }
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</main><!-- #main -->
	</div><!-- #primary -->
<br class="clear">
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
<script src="https://unpkg.com/imagesloaded@4.1/imagesloaded.pkgd.js"></script>
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
