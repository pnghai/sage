<?php while (have_posts()) : the_post(); ?>
  <h3 class="text-uppercase entry-categories"><?php _e('Category:','ug-2015'); the_category(', ');?></h3>
  <article <?php post_class(); ?>>
    <header>
      <time class="h5 updated text-uppercase entry-post-date" datetime="<?= get_post_time('c', true); ?>"><?= get_the_date(); ?></time>
      <h1 class="text-uppercase entry-title"><?php the_title(); ?></h1>
    </header>
    <figure class="feature-image"><?php the_post_thumbnail("full");?></figure>
    <div class="entry-content">
      <?php the_content(); ?>
    </div>
    <footer>
      <?php wp_link_pages(['before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']); ?>
    </footer>
    <?php comments_template('/templates/comments.php'); ?>
  </article>
<?php endwhile; ?>
