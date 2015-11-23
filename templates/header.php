<header class="banner">
	<div class="container">
		<div class="row header-row">
			<div class="col-xs-12 text-center">
				<?php
				if (has_nav_menu('primary_navigation')) :
					wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'nav']);
				endif;
				?>
			</div>
			<div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 text-center searchbar">
				<?php echo do_shortcode("[wp_google_searchbox]"); ?>
			</div>
			<div class="col-xs-12 text-center logo-brand">
				<a class="brand" href="<?= esc_url(home_url('/')); ?>" title="<?php bloginfo('name'); ?>">
					<?php echo wp_get_attachment_image(3444,"full");?>
				</a>
			</div>
		</div>

	</div>
</header>