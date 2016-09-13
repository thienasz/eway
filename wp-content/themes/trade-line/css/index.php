<div id="content" class="container">
    <div class="row"><!-- row -->

        <div id="k-top-search" class="col-lg-12 clearfix"><!-- top search -->

            <form action="#" id="top-searchform" method="get" role="search">
                <div class="input-group">
                    <input type="text" name="s" id="sitesearch" class="form-control" autocomplete="off"
                           placeholder="Type in keyword(s) then hit Enter on keyboard"/>
                </div>
            </form>

            <div id="bt-toggle-search" class="search-icon text-center"><i class="s-open fa fa-search"></i><i
                    class="s-close fa fa-times"></i></div><!-- toggle search button -->

        </div><!-- top search end -->

        <div class="k-breadcrumbs col-lg-12 clearfix"><!-- breadcrumbs -->

            <ol class="breadcrumb">
                <li><a href="#">Home</a></li>
                <li class="active">Page Example</li>
            </ol>

        </div><!-- breadcrumbs end -->

    </div><!-- row end -->
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
                                            <?php the_excerpt() ?>
                                        </p>
                                        <p>
                                            <a href="#" class="btn btn-sm btn-danger" title="Button">READ MORE</a>
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
    <!--    strart content with 4 col -->
    <div class="row no-gutter"><!-- row -->
        <!--    start events-->
        <div class="col-lg-4 col-md-4"><!-- upcoming events wrapper -->

            <div class="col-padded col-shaded"><!-- inner custom column -->

                <ul class="list-unstyled clear-margins"><!-- widgets -->

                    <li class="widget-container widget_up_events"><!-- widgets list -->
                        <?php
                        // start sql get post
                        $events = 'events';// create var to change after
                        wp_reset_query();
                        $args_my_query = array(
                            'post_type' => 'events', // need to customize
                            'posts_per_page' => '3',
                        );
                        $events_query = new WP_Query($args_my_query);
                        ?>

                        <h1 class="title-widget"><?php echo get_post_type_object($events)->title; ?></h1>

                        <ul class="list-unstyled">

                            <?php
                            //                            start foreach
                            if ($events_query->have_posts()) {
                                while ($events_query->have_posts()) {
                                    $events_query->the_post();
                                    ?>
                                    <li class="up-event-wrap">

                                        <h1 class="title-median"><a href="#"
                                                                    title="<?php the_title() ?>"><?php the_title() ?></a>
                                        </h1>
                                        <div class="up-event-meta clearfix">
                                            <div
                                                class="up-event-date"><?php echo get_post_meta($post->ID, 'event_date', true); ?></div>
                                            <div
                                                class="up-event-time"><?php echo get_post_meta($post->ID, 'event_time_begin', true) ?>
                                                - <?php echo get_post_meta($post->ID, 'event_time_end', true); ?></div>
                                        </div>
                                        <p>
                                            <?php the_excerpt_max_length(145) ?>
                                            <!--                                            ... <a href="#" class="moretag" title="read more">MORE</a>-->
                                        </p>

                                    </li>
                                    <?php
                                }
                            }
                            ?>

                        </ul>

                    </li><!-- widgets list end -->

                </ul><!-- widgets end -->

            </div><!-- inner custom column end -->

        </div><!-- upcoming events wrapper end -->
        <!--        end events-->

        <div class="col-lg-4 col-md-4"><!-- recent news wrapper -->

            <div class="col-padded"><!-- inner custom column -->

                <ul class="list-unstyled clear-margins"><!-- widgets -->

                    <li class="widget-container widget_recent_news"><!-- widgets list -->
                        <?php
                        // start sql get post
                        wp_reset_query();
                        $args_news_query = array(
                            'post_type' => 'news', // need to customize
                            'posts_per_page' => '3',
                        );
                        $news_query = new WP_Query($args_news_query);
                        ?>
                        <h1 class="title-widget"><?php echo get_post_type_object('news')->title; ?></h1>

                        <ul class="list-unstyled">
                            <?php
                            // start foreach
                            if ($news_query->have_posts()) {
                                while ($news_query->have_posts()) {
                                    $news_query->the_post();
                                    ?>
                                    <li class="recent-news-wrap">

                                        <h1 class="title-median"><a href="#"
                                                                    title="Megan Boyle flourishes..."><?php the_title() ?></a>
                                        </h1>

                                        <div class="recent-news-meta">
                                            <div class="recent-news-date"><?php echo get_the_date( 'M d,Y', $post->ID ); ?></div>
                                        </div>

                                        <div class="recent-news-content clearfix">
                                            <figure class="recent-news-thumb">
                                                <a href="#" title="Megan Boyle flourishes..."><img
                                                        src="<?php echo get_the_post_thumbnail_url($post->ID, 'thumbnail'); ?>"
                                                        class="attachment-thumbnail wp-post-image"
                                                        alt="Thumbnail 1"/></a>
                                            </figure>
                                            <div class="recent-news-text">
                                                <p>
                                                    <?php the_excerpt_max_length(120); ?> <!--other way the_excerpt()-->
                                                </p>
                                            </div>
                                        </div>

                                    </li>
                                    <?php
                                }
                            }
                            ?>
                        </ul>

                    </li><!-- widgets list end -->

                </ul><!-- widgets end -->

            </div><!-- inner custom column end -->

        </div><!-- recent news wrapper end -->

        <div class="col-lg-4 col-md-4"><!-- misc wrapper -->

            <div class="col-padded col-shaded"><!-- inner custom column -->

                <ul class="list-unstyled clear-margins"><!-- widgets -->

                    <li class="widget-container widget_course_search"><!-- widget -->

                        <h1 class="title-titan">Course Finder</h1>

                        <form role="search" method="get" id="course-finder" action="#">
                            <div class="input-group">
                                <input type="text" placeholder="Find a course..." autocomplete="off"
                                       class="form-control" id="find-course" name="find-course"/>
                                <span class="input-group-btn"><button type="submit" class="btn btn-default">GO!</button></span>
                            </div>
                            <span class="help-block">* Enter course ID, title or the course instructor name</span>
                        </form>

                    </li><!-- widget end -->

                    <li class="widget-container widget_text"><!-- widget -->

                        <a href="#" class="custom-button cb-green" title="How to apply?">
                            <i class="custom-button-icon fa fa-check-square-o"></i>
                                    <span class="custom-button-wrap">
                                    	<span class="custom-button-title">How to apply?</span>
                                        <span class="custom-button-tagline">Join us whenewer you feel it’s time!</span>
                                    </span>
                            <em></em>
                        </a>

                        <a href="#" class="custom-button cb-gray" title="Campus tour">
                            <i class="custom-button-icon fa  fa-play-circle-o"></i>
                                    <span class="custom-button-wrap">
                                    	<span class="custom-button-title">Campus tour</span>
                                        <span
                                            class="custom-button-tagline">Student's life at the glance. Take a tour...</span>
                                    </span>
                            <em></em>
                        </a>

                        <a href="#" class="custom-button cb-yellow" title="Prospectus">
                            <i class="custom-button-icon fa  fa-leaf"></i>
                                    <span class="custom-button-wrap">
                                    	<span class="custom-button-title">Prospectus</span>
                                        <span class="custom-button-tagline">Request a free School Prospectus!</span>
                                    </span>
                            <em></em>
                        </a>

                    </li><!-- widget end -->

                    <li class="widget-container widget_sofa_twitter"><!-- widget -->

                        <ul class="k-twitter-twitts list-unstyled">

                            <li class="twitter-twitt">
                                <p>
                                    <a href="https://twitter.com/DanielleFilson">@MattDeamon</a> Why it always has to be
                                    so complicated? Try to get it via this link <a href="http://usap.co/potter">mama.co/hpot</a>
                                    Good luck mate!
                                </p>
                            </li>

                        </ul>

                        <div class="k-twitter-twitts-footer">
                            <a href="#" class="k-twitter-twitts-follow" title="Follow!"><i class="fa fa-twitter"></i>&nbsp;
                                Follow us!</a>
                        </div>

                    </li><!-- widget end -->

                </ul><!-- widgets end -->

            </div><!-- inner custom column end -->

        </div><!-- misc wrapper end -->

    </div><!-- row end -->

</div>
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
