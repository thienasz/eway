<!--in here wp process to show post to be redirected from page index and single or other page if you want-->
<article id="post-<?php the_ID() ?>" class="grid-item col-md-4" >
<!--<article id="post---><?php //the_ID() ?><!--" --><?php //post_class() ?><!-- >-->
    <div class=" thumbnail-cus"><?php
        if(!has_post_thumbnail()&& !is_single())
        {
            echo '<figure class="thumbnail"><img src="' . THEME_URL . '/images/nophoto-thumbnail.png"></figure>';
        }else{
            if(!is_single())
                david_thumbnail('thumbnail');
        }?>
    </div>
    <header class="entry-header">
        <?php david_entry_header(); ?>
        <?php david_entry_meta(); ?>
    </header>
    <summary class="entry-content">
        <?php david_entry_content() ?>
    </summary>
    <footer>
        <?php david_entry_tag() ?>
    </footer>
    <hr>
</article>
<!--<div class="clearfix"></div>-->
<!--you can create special page for type post how to create file name content-$name type by-->
<!--it is more professional-->