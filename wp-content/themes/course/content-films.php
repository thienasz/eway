<!--in here wp process to show post to be redirected from page index and single or other page if you want-->
<pre>
    <?php print_r(wp_get_attachment_url('1932') ) ?>
</pre>

</div>
<article id="post-<?php the_ID() ?>" class="grid-item row" >
    <header class="film-title ">
        <h1 class="archive-title">
            <?php the_title() ?>
        </h1>
        <section id="film-view" class="col-md-8">
            <?php
            $link_film = get_post_meta($post->ID, 'film_source', true);
            print_r($link_film);
            if(isset($link_film)){
                if (strpos($link_film, 'embed') !== false) {
                    global $wp_embed;
                    $post_embed = $wp_embed->run_shortcode($link_film);
                    echo $post_embed;
                }else{
                    echo '<iframe src="'.$link_film.'"></iframe>';
                }
            }
            ?>
        </section>
        <section id="film-sub" class="col-md-4"></section>
    </header>
    <div class="clearfix"></div>
    <section id="film-content" class="">
        <?php
            the_content();
        ?>
    </section>
<!---->
<!--    <section id="sidebar" class="col-md-4">-->
<!--        --><?php //get_sidebar($post->post_type) ?>
<!--    </section>-->
</article>
<div class="clearfix" ></div>
<!--<div class="clearfix"></div>-->
<!--you can create special page for type post how to create file name content-$name type by-->
<!--it is more professional-->
<script type="text/javascript">
    $(document).ready(function ()
    {
        $('#myVideo_demo').videocontrols();
    });
</script>