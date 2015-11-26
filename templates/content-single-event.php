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
          <?php the_field("navigation_panel");?>
        </div>
      </div>
      <div class="col-md-8">
          <div class="entry-content">
            <?php the_content(); ?>
          </div>
      </div>
    </div>
  </article>
<?php endwhile; ?>
