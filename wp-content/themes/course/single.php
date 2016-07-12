<!--process post detail-->
<?php get_header(); ?>
<?php
?>
<div id="content">
    <section id="main-content" class="">
        <?php if( have_posts()) : while( have_posts()) : the_post(); ?>
            <?php get_template_part('content', $post->post_type);

            ?>
            <!--                it load file by type post if you don't define it use content.php -->
            <?php get_template_part( 'author-box' ); ?>
            <?php comments_template(); ?>
        <?php endwhile; ?>
        <?php else : ?>
            <?php get_template_part('content','none') ?>
            <!--                it load file content-none.php-->
        <?php endif; ?>
    </section>
</div>

<?php get_footer(); ?>
