<?php
/**
 * Created by PhpStorm.
 * User: 08121_000
 * Date: 10/18/2015
 * Time: 2:09 PM
 */

while (have_posts()) : the_post(); ?>
	<?php the_content(); ?>
<?php endwhile;
