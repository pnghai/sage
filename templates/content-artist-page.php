<div class="row">
    <div class="col-md-5 col-sm-4">
        <header>
            <h1 class="text-uppercase entry-title"><?php the_title(); ?></h1>
        </header>
        <?php
        global $post;
        $parent_id = $post->post_parent;
        $artist_id = get_the_ID();
        $parent = get_post($parent_id);
        $artists_page = get_page_by_title("Artists");
        $artist_id = ($parent->post_parent == $artists_page->ID)?$parent->ID:get_the_ID();
        ?>
        <div class="post-nav">
            <ul>
                <li><a href="<?php echo get_permalink($artist_id);?>"><?php _e("Artist Biography","sage");?></a></li>
                <?php $link = get_field("artist_exhibitions_link",$artist_id);
                if ($link):?>
                    <li><a href="<?php echo $link; ?>">ARTIST EXHIBITIONS</a></li>
                <?php endif;?>
                <?php $link = get_field("artist_related_items",$artist_id);
                if ($link):?>
                    <li><a href="<?php echo $link;?>">SHOP ITEMS</a></li>
                <?php endif;?>
            </ul>
        </div>
    </div>

    <div class="col-md-7 col-sm-8">
        <?php the_content(); ?>
    </div>
</div>
