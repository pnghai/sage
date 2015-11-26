<?php
/**
 * Template Name: Artist Template
 */
?>

<?php while (have_posts()) : the_post(); ?>
  <?php get_template_part('templates/content', 'artist-page'); ?>
<?php endwhile; ?>
