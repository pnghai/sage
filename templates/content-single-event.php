<?php while (have_posts()) : the_post(); ?>
  <article <?php post_class(); ?>>
    <div class="row">
      <div class="col-md-4">
        <header class="text-uppercase">
          <h1 class="entry-title"><?php the_title(); ?></h1>
          <?php global $EM_Event, $post;
            $EM_Event = em_get_event($post->ID, 'post_id');
          ?>
          <div class="subtitle"><?php echo $EM_Event->output("#_EVENTEXCERPT");?></div>
          <div class="datetime-range">
            <?php echo $EM_Event->output("#_EVENTDATES . #_EVENTTIMES");?>
          </div>
          <div class="contact-info">
            <div class="location-name">
              <?php echo $EM_Event->output("#_LOCATIONNAME");?>
            </div>
            <div class="localtion-fullbr">
              <?php echo $EM_Event->output("#_LOCATIONFULLBR");?>
            </div>
            T. <?php echo $EM_Event->output("#_CONTACTPHONE");?><br>
            <a href="mailto:<?php echo $EM_Event->output("#_CONTACTEMAIL");?>"><?php echo $EM_Event->output("#_CONTACTEMAIL");?></a><br>
            <?php echo $EM_Event->output("#_LOCATIONNOTES");?>
            <a href="<?php echo get_permalink(get_page_by_title("Contact"));?>"><?php _e("Gallery Infomation","sage");?></a><br>
            <a href="<?php echo $EM_Event->output("#_LOCATIONURL");?>"><?php _e("Gallery Map","sage");?></a><br>
          </div>
        </header>
        <div class="post-nav">
          <ul>
            <li><a href="<?php the_permalink();?>"><b><?php _e("About Exhibition","sage");?></b></a></li>
            <?php $categories = get_the_terms(get_the_ID(),'event-categories');
            if ( ! empty( $categories ) ) {
              foreach( $categories as $category ) {
                $artist_link = get_field("artist_page", $category);
                if ($artist_link):
                  $post = $artist_link;
                  setup_postdata( $post );
                  ?>
                  <li><a href="<?php the_permalink(); ?>"><?php _e("Artist Info", "sage"); ?></a>
                  </li><?php wp_reset_postdata();
                endif;
              }
            }
            ?>
          </ul>
        </div>
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
