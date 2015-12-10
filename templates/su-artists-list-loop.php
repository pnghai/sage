<div class="su-jobs su-jobs-list-loop">
<?php
// Posts are found
if ( $posts->have_posts() ) {
	while ( $posts->have_posts() ) {
		$posts->the_post();
		global $post;
?>
<div id="su-jobs-<?php the_ID(); ?>" class="su-job"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
<?php
	}
}
// Posts not found
else {
?>
<div><?php _e( 'Jobs not found', 'shortcodes-ultimate' ) ?></div>
<?php
}
?>
</div>
