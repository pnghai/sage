<div class="row">
    <div class="col-md-5 col-sm-4">
        <header>
            <h1 class="text-uppercase entry-title"><?php the_title(); ?></h1>
        </header>
        <?php $parent_id = $post->post_parent;
        $post = get_post($parent_id);
        $artists_page = get_page_by_title("Artists");
        if ($post->post_parent == $artists_page->ID):
            setup_postdata( $post );
        endif;?>
        <div class="post-nav">
            <ul>
                <li><a href="<?php the_permalink();?>"><?php _e("Artist Biography","sage");?></a></li>
                <?php $link = get_field("artist_exhibitions_link");
                if ($link):?>
                    <li><a href="<?php echo $link ?>">ARTIST EXHIBITIONS</a></li>
                <?php endif;?>
                <?php $link = get_field("artist_related_items");
                if ($link):?>
                    <li><a hef="<?php echo $link;?>">SHOP ITEMS</a></li>
                <?php endif;?>
            </ul>
        </div>
        <?php if ($post->post_parent == $artists_page->ID):
            wp_reset_postdata();
        endif;?>
    </div>

    <div class="col-md-7 col-sm-8">
        <?php the_content(); ?>
    </div>
</div>
