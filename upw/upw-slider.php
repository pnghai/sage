<?php
/**
 * Standard ultimate posts widget template
 *
 * @version     2.0.0
 */
?>

<?php if ($instance['before_posts']) : ?>
  <div class="upw-before">
    <?php echo wpautop($instance['before_posts']); ?>
  </div>
<?php endif; ?>

<?php if ($upw_query->have_posts()) : ?>
  <div class="upw-posts-slider hfeed">
    <div id="upw-carousel" class="carousel slide" data-ride="carousel">

      <!-- Wrapper for slides -->
      <div class="carousel-inner" role="listbox">
          <?php
          $index=0;
          while ($upw_query->have_posts()) : $upw_query->the_post(); $index ++;?>

            <article <?php post_class('item '.(($index == 1 )?'active':'')); ?>>

              <header>

                <?php if (current_theme_supports('post-thumbnails') && $instance['show_thumbnail'] && has_post_thumbnail()) : ?>
                  <div class="entry-image">
                    <a href="<?php the_permalink(); ?>" rel="bookmark">
                      <?php the_post_thumbnail($instance['thumb_size']); ?>
                    </a>
                  </div>
                <?php endif; ?>

                <?php if (get_the_title() && $instance['show_title']) : ?>
                  <h5 class="entry-title">
                    <a href="<?php the_permalink(); ?>" rel="bookmark">
                      <?php the_title(); ?>
                    </a>
                  </h5>
                <?php endif; ?>

              <footer>

                <?php
                $categories = get_the_term_list($post->ID, 'category', '', ', ');
                $artists = get_the_terms($post->ID,'category');
                if ($instance['show_cats'] && $categories) :
                  ?>
                  <div class="entry-artists">
                    <span class="entry-cats-list"><?php echo $categories; ?></span>
                    <a class="entry-artist-link" href="<?php echo get_permalink(get_page_by_title($artists[0]->name));?>"><?php _e('&gt;&gt; VIEW ARTIST');?></a>
                  </div>
                <?php endif; ?>

              </footer>

            </article>

          <?php endwhile; ?>
      </div>

      <!-- Controls -->
      <a class="left carousel-control" href="#upw-carousel" role="button" data-slide="prev">
        <i class="icon-left-open-big" aria-hidden="true"></i>
        <span class="sr-only"><?php _e('Previous','ug-2015');?></span>
      </a>
      <a class="right carousel-control" href="#upw-carousel" role="button" data-slide="next">
        <i class="icon-right-open-big" aria-hidden="true"></i>
        <span class="sr-only"><?php _e('Next','ug-2015');?></span>
      </a>
    </div>

  </div>

<?php else : ?>

  <p class="upw-not-found">
    <?php _e('No posts found.', 'upw'); ?>
  </p>

<?php endif; ?>
<?php if ($instance['after_posts']) : ?>
  <div class="upw-after">
    <?php echo wpautop($instance['after_posts']); ?>
  </div>
<?php endif; ?>