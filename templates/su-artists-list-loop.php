<div class="row su-artists su-artists-list-loop">
<?php
// Posts are found
if ( $posts->have_posts() ) {
	$count=0;
	while ( $posts->have_posts() ) {
		$posts->the_post();
		global $post;
?>
<div id="su-artists-<?php the_ID(); ?>" class="col-md-3 col-sm-6 su-artist">
	<a href="<?php the_permalink(); ?>">
		<?php if (has_post_thumbnail()): the_post_thumbnail("thumbnail", array( 'class' => 'alignleft' )); endif;?>
		<?php the_title(); ?>
	</a>
</div>
<div class="clearfix visible-xs-block"></div>
<?php if ($count%2==1):?><div class="clearfix visible-sm-block"></div><?php endif;?>
<?php if ($count%4==3):?><div class="clearfix visible-md-block"></div><?php endif;?>
<?php
		$count++;
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
