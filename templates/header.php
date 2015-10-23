<header class="banner">
	<div class="container">
		<div class="row header-row">
			<div class="col-xs-12 hidden-md hidden-lg text-center logo-brand">
				<a class="brand" href="<?= esc_url(home_url('/')); ?>" title="<?php bloginfo('name'); ?>">
					<?php echo wp_get_attachment_image(3352,"full");?>
				</a>
			</div>
		</div>

	</div>
	<?php
	if (has_nav_menu('primary_navigation')) :
	wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'nav']);
	endif;
	?>
</header>
