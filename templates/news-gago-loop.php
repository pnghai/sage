<div class="su-posts su-news-loop">
	<?php
		// Posts are found
		if ( $posts->have_posts() ) {
			while ( $posts->have_posts() ) :
				$posts->the_post();
				global $post;
				?>

				<div id="su-post-<?php the_ID(); ?>" class="su-post">
					<?php if ( has_post_thumbnail() ) : ?>
						<div class="right-col pull-right">
							<a class="su-post-thumbnail" href="<?php the_permalink(); ?>"><?php the_post_thumbnail("medium"); ?></a>
							<br>
							<a href="<?php the_permalink();?>">Permalink</a>
						</div>
					<?php endif; ?>
					<h2 class="su-post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<div class="su-post-subtitle"><?php the_field("subtitle");?></div>
					<div class="su-post-meta"><?php the_time( get_option( 'date_format' ) ); ?></div>
					<div class="su-post-excerpt">
						<?php the_excerpt(); ?>
					</div>
					<div><a href="<?php the_permalink();?>"><i class="fa fa-chevron-right"></i> VIEW MORE</a></div>
				</div>
				<hr>
				<?php
			endwhile;
		}
		// Posts not found
		else {
			echo '<h4>' . __( 'Posts not found', 'shortcodes-ultimate' ) . '</h4>';
		}
	?>
</div>