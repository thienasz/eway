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

			<section class="goal">
				<h1><i class="fa fa-quote-left"></i> Mỗi ngày đến lớp là một ngày vui <i class="fa fa-quote-right"></i></h1>
				<!--<p>	A (free) responsive site template by <a href="http://html5up.net">HTML5 UP</a>.
                        Built on skel and released under the <a href="http://html5up.net/license">CCA</a> license.-->
				<p></p>
			</section>
			<div class="body">
				<div class="body_home">
					<div class="box_content_home">
						<div class="box_product col-md-12 no-padding">
							<div class="col-lg-3 col-md-6 col-sm-12">
								<div class="">
									<a href="http://tree.edu.vn/Khoa-hoc/1722/Khoa-Zero-tai-TREE.html" title="Tiến bộ từng ngày không phải chờ đến cuối khóa"><img src="http://tree.edu.vn/uploads/product/11417621324.jpg" alt="Tiến bộ từng ngày không phải chờ đến cuối khóa" name="Tiến bộ từng ngày không phải chờ đến cuối khóa" onerror="this.src='http://tree.edu.vn/themes/default/images/root/no-image.gif';" width="100%"></a>
									<br class="clear">
								</div>
								<div class="w292_title">
									<a href="http://tree.edu.vn/Khoa-hoc/1722/Khoa-Zero-tai-TREE.html" title="Tiến bộ từng ngày không phải chờ đến cuối khóa">Tiến bộ từng ngày không phải chờ đến cuối khóa</a>
								</div>
								<div class="w292_des">
									<p class="w292_des_text"></p><p><span style="color:#000000">TREE mang đến cho học viên cảm nhận mình tiến bộ từng ngày mà không phải chờ đến cuối khóa. Kết thúc khóa học, sự thay đổi dần dần&nbsp;trong tư duy và phương pháp học khiến Tiếng Anh không còn là nỗi sợ hay sự tự ti của bất kỳ ai. Cam kết đầu ra, nếu không sẽ hoàn trả học phí.</span></p>
									<p></p>
								</div>
								<!--<div class="button_reg">
                                    <a href="#form_reg" title="Tiến bộ từng ngày không phải chờ đến cuối khóa" class="view_all">Đăng ký học thử</a>
                                    <br class="clear" />
                                </div>-->
							</div>
							<div class="col-lg-3 col-md-6 col-sm-12">
								<div class="">
									<a href="http://tree.edu.vn/Khoa-hoc/1722/Khoa-Zero-tai-TREE.html" title="Học tiếng Anh như Toán - Tưởng không vui mà vui không tưởng!"><img src="http://tree.edu.vn/uploads/product/11417621339.jpg" alt="Học tiếng Anh như Toán - Tưởng không vui mà vui không tưởng!" name="Học tiếng Anh như Toán - Tưởng không vui mà vui không tưởng!" onerror="this.src='http://tree.edu.vn/themes/default/images/root/no-image.gif';" width="100%"></a>
									<br class="clear">
								</div>
								<div class="w292_title">
									<a href="http://tree.edu.vn/Khoa-hoc/1722/Khoa-Zero-tai-TREE.html" title="Học tiếng Anh như Toán - Tưởng không vui mà vui không tưởng!">Học tiếng Anh như Toán - Tưởng không vui mà vui không tưởng!</a>
								</div>
								<div class="w292_des">
									<p class="w292_des_text"></p><p><span style="color:#000000">TREE hướng dẫn&nbsp;những bí quyết "siêu đẳng"&nbsp;của ngữ pháp tiếng Anh. Áp dụng quy tắc “bí mật bàn tay” làm chủ ngữ pháp tiếng Anh trong từng lời nói. Học ngữ pháp qua các trò chơi vui nhộn. Nắm vững các tips ngữ pháp siêu dễ nhớ, dễ sử dụng.</span></p>
									<p></p>
								</div>
								<!--<div class="button_reg">
                                    <a href="#form_reg" title="Học tiếng Anh như Toán - Tưởng không vui mà vui không tưởng!" class="view_all">Đăng ký học thử</a>
                                    <br class="clear" />
                                </div>-->
							</div>
							<div class="col-lg-3 col-md-6 col-sm-12">
								<div class="">
									<a href="http://tree.edu.vn/Khoa-hoc/1722/Khoa-Zero-tai-TREE.html" title="Viết tâm thư, nhật kí và dịch báo chỉ sau 10 buổi học"><img src="http://tree.edu.vn/uploads/product/11417621368.jpg" alt="Viết tâm thư, nhật kí và dịch báo chỉ sau 10 buổi học" name="Viết tâm thư, nhật kí và dịch báo chỉ sau 10 buổi học" onerror="this.src='http://tree.edu.vn/themes/default/images/root/no-image.gif';" width="100%"></a>
									<br class="clear">
								</div>
								<div class="w292_title">
									<a href="http://tree.edu.vn/Khoa-hoc/1722/Khoa-Zero-tai-TREE.html" title="Viết tâm thư, nhật kí và dịch báo chỉ sau 10 buổi học">Viết tâm thư, nhật kí và dịch báo chỉ sau 10 buổi học</a>
								</div>
								<div class="w292_des">
									<p class="w292_des_text"></p><p><span style="color:#000000">TREE hướng dẫn Học viên thực hành thành thạo tiếng Anh qua các bài luận, viết thư, nhật ký và&nbsp;dịch báo. Đội ngũ giảng viên và trợ giảng nhiệt tình sửa bài chi tiết từng ngày, sát sao theo dõi Học viên và kịp thời chỉnh sửa những lỗi sai. Chỉ sau 10 tuần, Học viên dễ dàng sử dụng tiếng Anh để tự&nbsp;viết các văn bản hoàn thiện.</span></p>
									<p></p>
								</div>
								<!--<div class="button_reg">
                                    <a href="#form_reg" title="Viết tâm thư, nhật kí và dịch báo chỉ sau 10 buổi học" class="view_all">Đăng ký học thử</a>
                                    <br class="clear" />
                                </div>-->
							</div>
							<div class="col-lg-3 col-md-6 col-sm-12">
								<div class="">
									<a href="http://tree.edu.vn/Khoa-hoc/1722/Khoa-Zero-tai-TREE.html" title="Biết tiếng Việt là học được tiếng Anh"><img src="http://tree.edu.vn/uploads/product/11417621380.jpg" alt="Biết tiếng Việt là học được tiếng Anh" name="Biết tiếng Việt là học được tiếng Anh" onerror="this.src='http://tree.edu.vn/themes/default/images/root/no-image.gif';" width="100%"></a>
									<br class="clear">
								</div>
								<div class="w292_title">
									<a href="http://tree.edu.vn/Khoa-hoc/1722/Khoa-Zero-tai-TREE.html" title="Biết tiếng Việt là học được tiếng Anh">Biết tiếng Việt là học được tiếng Anh</a>
								</div>
								<div class="w292_des">
									<p class="w292_des_text"></p><p><span style="color:#000000">TREE dạy kỹ năng để bạn nói tiếng Anh theo phản xạ tự nhiên nhờ áp dụng những nguyên tắc riêng gắn kết giữa ngoại ngữ và tiếng mẹ đẻ. TREE chỉ ra sự liên kết chặt chẽ giữa tiếng Việt và tiếng Anh – những nguyên tắc mà chính những người học tiếng Anh lâu năm chưa chắc đã biết hết.</span></p>
									<p></p>
								</div>
								<!--<div class="button_reg">
                                    <a href="#form_reg" title="Biết tiếng Việt là học được tiếng Anh" class="view_all">Đăng ký học thử</a>
                                    <br class="clear" />
                                </div>-->
							</div>
						</div>
					</div>
					<div class="clear"></div>
				</div>
				<div class="center-txt" style="background: #f0f4f4; padding: 0px 30px 40px;"><a href="http://tree.edu.vn/tuyensinh" title="Đăng ký ngay" class="register-btn btn"><b>ĐĂNG KÝ NGAY</b></a></div>&nbsp;
				<br class="clear">
				<div class="company_intro">
					<h2>Giảng viên của TREE</h2>
					<div class="col-md-12">
						<div class="w637 col-md-12 col-lg-6">
							<h3><a href="http://tree.edu.vn/Giang-vien/22/Ms-Bui-Thi-Hai-Yen-Nguoi-truyen-lua.html" title="Ms. Bùi Thị Hải Yến - Người truyền lửa">Ms. Bùi Thị Hải Yến - Người truyền lửa</a></h3>
							<br class="clear">
							<div class="teacher_img col-md-6 col-sm-12 no-padding margin-bottom">
								<a href="http://tree.edu.vn/Giang-vien/22/Ms-Bui-Thi-Hai-Yen-Nguoi-truyen-lua.html" title="Ms. Bùi Thị Hải Yến - Người truyền lửa"><img src="http://tree.edu.vn/uploads/advertise/1422370185-phucthinh-1422370185-chi yen2.png" alt="Ms. Bùi Thị Hải Yến - Người truyền lửa" name="Ms. Bùi Thị Hải Yến - Người truyền lửa" style="display: none !important;"></a>
							</div>
							<div class="company_des col-md-6 col-sm-12">
								<p>Được mệnh danh là "Người truyền lửa" tại TREE, Ms. Yến hiện đang giữ trọng trách lớn giúp đội ngũ "trồng cây" tại TREE lớn mạnh về chuyên môn và tràn trề nhiệt huyết. Nắm giữ một "profile" khủng khiến bao người ngưỡng mộ:</p>

								<ul>
									<li style="text-align:justify">Người&nbsp;đầu tiên tại Việt Nam sáng tạo ra phương pháp học LOGIC giúp các Học viên biết được bí quyết làm chủ ngôn ngữ tiếng Anh</li>
									<li style="text-align:justify">Tốt nghiệp chuyên ngành tiếng Anh tại ĐH Đà Nẵng</li>
									<li style="text-align:justify"><span... <a="" class="seemore" href="http://tree.edu.vn/Giang-vien/22/Ms-Bui-Thi-Hai-Yen-Nguoi-truyen-lua.html" title="Ms. Bùi Thị Hải Yến - Người truyền lửa">See more...
										</span...></li></ul></div>

							<br class="clear">
						</div>
						<div class="w637 col-md-12 col-lg-6">
							<h3><a href="http://tree.edu.vn/Giang-vien/22/Ms-Bui-Thi-Hai-Yen-Nguoi-truyen-lua.html" title="Ms. Bùi Thị Hải Yến - Người truyền lửa">Ms. Bùi Thị Hải Yến - Người truyền lửa</a></h3>
							<br class="clear">
							<div class="teacher_img col-md-6 col-sm-12 no-padding margin-bottom" style="min-height: 200px;">
								<iframe width="100%" height="auto" src="https://www.youtube.com/embed/aJtBzsq-NFw?rel=0&amp;showinfo=0" frameborder="0" allowfullscreen="" class=" clip-frame"></iframe>
							</div>
							<div class="fl company_des col-md-6 col-sm-12">
								<p>Được mệnh danh là "Người truyền lửa" tại TREE, Ms. Yến hiện đang giữ trọng trách lớn giúp đội ngũ "trồng cây" tại TREE lớn mạnh về chuyên môn và tràn trề nhiệt huyết. Nắm...
								</p></div>
						</div>
					</div>
					<br class="clear">
				</div>
				<div class="box_product_3">
					<h2>Tin tức</h2>
					<div class="col-md-12">
						<div class="hot_news_wapper col-md-12 col-lg-6">
							<h3>Tin tức nổi bật</h3>
							<!--            <br class="clear">-->
							<div class="col_news col-md-12 no-padding">
								<div class="hot_news_img col-md-6 col-sm-12 no-padding margin-bottom">
									<a href="http://tree.edu.vn/Tin/2170/Tung-bung-khai-giang-cac-lop-Zero-trong-thang-5/2016.html" title="Tưng bừng khai giảng các lớp Zero trong tháng 5/2016"><img src="http://tree.edu.vn/uploads/news/1466652139-phu-kien-dien-thoai-1466652139-Thumb.jpg" onerror="this.src='http://tree.edu.vn/themes/default/images/root/no-image.gif';" alt="Tưng bừng khai giảng các lớp Zero trong tháng 5/2016" name="Tưng bừng khai giảng các lớp Zero trong tháng 5/2016"></a>
								</div>

								<div class="hot_news_des col-md-6 col-sm-12">
									<a href="http://tree.edu.vn/Tin/2170/Tung-bung-khai-giang-cac-lop-Zero-trong-thang-5/2016.html" title="Tưng bừng khai giảng các lớp Zero trong tháng 5/2016"><span>Tưng bừng khai giảng các lớp Zero trong tháng 5/2016</span></a>
									<br><br>
									<p>   Trong tháng 6, hàng trăm các lớp ZERO đã tưng bừng khai giảng. Mọi học viên đều hào hứng bước vào chinh phục một chặng đường mới để đảm bảo thành thạo cả 4 kỹ năng&nbsp;NGHE NÓI ĐỌC VIẾT.
									</p>
									<a class="seemore" href="http://tree.edu.vn/Tin/2170/Tung-bung-khai-giang-cac-lop-Zero-trong-thang-5/2016.html" title="Tưng bừng khai giảng các lớp Zero trong tháng 5/2016">See more</a>
								</div>

								<div class="other_news col-md-12">
									<ul>
										<li><a href="http://tree.edu.vn/Tin/2164/Tung-bung-khai-giang-cac-lop-Zero-trong-thang-4/2016.html" title="Tưng bừng khai giảng các lớp Zero trong tháng 4/2016"><i class="fa fa-caret-right"></i> &nbsp; <span>Tưng bừng khai giảng các lớp Zero trong tháng 4/2016</span></a></li>
										<li><a href="http://tree.edu.vn/Tin/2163/Be-giang-module-1-Z65.html" title="Bế giảng module 1 Z65"><i class="fa fa-caret-right"></i> &nbsp; <span>Bế giảng module 1 Z65</span></a></li>
										<li><a href="http://tree.edu.vn/Tin/2162/Be-giang-G11.html" title="Bế giảng G11"><i class="fa fa-caret-right"></i> &nbsp; <span>Bế giảng G11</span></a></li>
										<li><a href="http://tree.edu.vn/Tin/2159/Tam-thu-cuoi-khoa-cua-GS1.html" title="Tâm thư cuối khóa của GS1"><i class="fa fa-caret-right"></i> &nbsp; <span>Tâm thư cuối khóa của GS1</span></a></li>
									</ul>
								</div>
							</div>
							<div class="clear"></div>
						</div>
						<div class="hot_news_wapper col-md-12 col-lg-6">
							<h3>Chia sẻ nổi bật</h3>
							<div class="col_news col-md-12 no-padding">
								<div class="hot_news_img col-md-6 col-sm-12 no-padding margin-bottom">
									<a href="http://tree.edu.vn/Tin/2167/Kha-nang-tap-trung-co-han-Hoc-cang-nhieu-cang-can-y-tuong.html" title="Khả năng tập trung có hạn - Học càng nhiều càng cạn ý tưởng"><img src="http://tree.edu.vn/uploads/news/1465983268-phu-kien-dien-thoai-1465983268-Thumb.jpg" onerror="this.src='http://tree.edu.vn/themes/default/images/root/no-image.gif';" alt="Khả năng tập trung có hạn - Học càng nhiều càng cạn ý tưởng" name="Khả năng tập trung có hạn - Học càng nhiều càng cạn ý tưởng"></a>
								</div>

								<div class="hot_news_des col-md-6 col-sm-12">
									<a href="http://tree.edu.vn/Tin/2167/Kha-nang-tap-trung-co-han-Hoc-cang-nhieu-cang-can-y-tuong.html" title="Khả năng tập trung có hạn - Học càng nhiều càng cạn ý tưởng"><span>Khả năng tập trung có hạn - Học càng nhiều càng cạn ý tưởng</span></a>
									<br><br>
									<p>   Giờ học tại TREE thông thường kéo dài trong 75 phút. Nhiều học viên thắc mắc tại sao không dài hơn hay ngắn hơn mà lại là con số “75 phút”. Bởi đây là thời lượng học vừa đủ nhất mà TREE đã dựa trên nhiều nghiên cứu cũng như...</p>
									<a class="seemore" href="http://tree.edu.vn/Tin/2167/Kha-nang-tap-trung-co-han-Hoc-cang-nhieu-cang-can-y-tuong.html" title="Khả năng tập trung có hạn - Học càng nhiều càng cạn ý tưởng">See more</a>
								</div><div class="clear"></div>
								<div class="other_news col-md-12">
									<ul>
										<li><a href="http://tree.edu.vn/Tin/2165/“Bat-mi”-hoc-tieng-Anh-tai-TREE-thay-doi-hoan-toan-tu-duy-truoc-do.html" title="“Bật mí” học tiếng Anh tại TREE, thay đổi hoàn toàn tư duy trước đó"><i class="fa fa-caret-right"></i> &nbsp; <span>“Bật mí” học tiếng Anh tại TREE, thay đổi hoàn toàn tư duy trước đó</span></a></li>
										<li><a href="http://tree.edu.vn/Tin/2161/5-sai-lam-khien-nguoi-mat-goc-tieng-Anh-hoc-bao-nam-ma-khong-gioi.html" title="5 sai lầm khiến người mất gốc tiếng Anh học bao năm mà không giỏi"><i class="fa fa-caret-right"></i> &nbsp; <span>5 sai lầm khiến người mất gốc tiếng Anh học bao năm mà không giỏi</span></a></li>
										<li><a href="http://tree.edu.vn/Tin/2160/Tai-sao-nguoi-mat-goc-tieng-Anh-phai-hoc-theo-lo-trinh.html" title="Tại sao người mất gốc tiếng Anh phải học theo lộ trình?"><i class="fa fa-caret-right"></i> &nbsp; <span>Tại sao người mất gốc tiếng Anh phải học theo lộ trình?</span></a></li>
										<li><a href="http://tree.edu.vn/Tin/2158/Nguyen-ly-hoc-tieng-Anh-cho-nguoi-mat-goc.html" title="Nguyên lý học tiếng Anh cho người mất gốc"><i class="fa fa-caret-right"></i> &nbsp; <span>Nguyên lý học tiếng Anh cho người mất gốc</span></a></li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>	       	        </div>

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
