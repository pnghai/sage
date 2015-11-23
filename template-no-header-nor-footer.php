<?php
/**
 * Template Name: No Header and Footer Template
 */
?>

<?php while (have_posts()) : the_post(); ?>
  <?php the_content();?>
<?php endwhile; ?>
