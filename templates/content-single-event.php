<?php while (have_posts()) : the_post(); ?>
  <h3 class="text-uppercase entry-categories"><?php _e('Category','ug-2015');?> : <? the_category(', ');?></h3>
  <article <?php post_class(); ?>>
    <div class="row">
      <div class="col-md-4">
        <header>
          <h1 class="text-uppercase entry-title"><?php the_title(); ?></h1>
          <?php
          global $EM_Event, $post;
            $EM_Event = em_get_event($post->ID, 'post_id');
          var_dump($EM_Event);
            echo $EM_Event->output('<div class="datetime-range">#_EVENTDATES . #_EVENTTIMES</div><div class="location">#_LOCATIONNAME<br>#_LOCATIONFULLBR</div>');
          //$EM_Event->output_single();
          ?>
        </header>
      </div>
      <div class="col-md-8">
          <div class="entry-content">
            <?php the_content(); ?>
          </div>
          <?php comments_template('/templates/comments.php'); ?>
      </div>
    </div>
  </article>
<?php endwhile; ?>
