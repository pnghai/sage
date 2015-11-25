<?php while (have_posts()) : the_post(); ?>
  <article <?php post_class(); ?>>
    <div class="row">
      <div class="col-md-6 col-sm-4">
        <header>
          <h1 class="text-uppercase entry-title"><?php the_title(); ?></h1>
          <div class="subtitle"><?php the_field("subtitle");?></div>
          <time class="h5 updated text-uppercase entry-post-date" datetime="<?= get_post_time('c', true); ?>"><?= get_the_date(); ?></time>
        </header>
        <div class="post-nav">
          <ul>
            <li><a href="<?php the_permalink();?>"><?php _e("Press Release","sage");?></a></li>
            <?php $categories = get_the_category();
            if ( ! empty( $categories ) ) {
              foreach( $categories as $category ) {
                ?>
                <li><a href="<?php the_field("artist_page", $category); ?>"><?php _e("Artist Info", "sage"); ?></a>
                </li><?php
              }
            }
            ?>
          </ul>
        </div>
      </div>
      <div class="col-md-6 col-sm-8">

          <figure class="feature-image"><?php the_post_thumbnail("full");?>
            <figcaption>
              <?php echo get_post(get_post_thumbnail_id())->post_excerpt; ?>
            </figcaption>
          </figure>
          <div class="entry-content">
            <?php the_content(); ?>
          </div>
          <footer>
            <?php wp_link_pages(['before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']); ?>
          </footer>
          <?php comments_template('/templates/comments.php'); ?>
      </div>
    </div>
  </article>
<?php endwhile; ?>
