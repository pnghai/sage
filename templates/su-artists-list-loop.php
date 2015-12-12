<div class="row su-artists su-artists-list-loop">
<?php
// Posts are found
if ( $posts->have_posts() ) {
	while ( $posts->have_posts() ) {
		$posts->the_post();
		global $post;
?>
<div id="su-artists-<?php the_ID(); ?>" class="col-md-3 col-sm-6 su-artist">
	<a href="<?php the_permalink(); ?>">
		<?php if (has_post_thumbnail()): the_post_thumbnail("thumbnail"); endif;?>
		<?php the_title(); ?>
	</a>
</div>
<?php
	}
}
// Posts not found
else {
?>
<div><?php _e( 'Artist not found', 'shortcodes-ultimate' ) ?></div>
<?php
}
?>
</div>
