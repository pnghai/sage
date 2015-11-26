<?php

namespace Roots\Sage\Extras;

use Roots\Sage\Setup;
use WP_Query;

/**
 * Add <body> classes
 */
function body_class($classes)
{
    // Add page slug if it doesn't exist
    if (is_single() || is_page() && !is_front_page()) {
        if (!in_array(basename(get_permalink()), $classes)) {
            $classes[] = basename(get_permalink());
        }
    }

    // Add class if sidebar is active
    if (Setup\display_sidebar()) {
        $classes[] = 'sidebar-primary';
    }

    return $classes;
}

add_filter('body_class', __NAMESPACE__ . '\\body_class');

/**
 * Clean up the_excerpt()
 */
function excerpt_more()
{
    return ' &hellip; <a href="' . get_permalink() . '">' . __('Continued', 'sage') . '</a>';
}

add_filter('excerpt_more', __NAMESPACE__ . '\\excerpt_more');

// Creating the widget
class wpb_widget extends \WP_Widget
{

    function __construct()
    {
        parent::__construct(
// Base ID of your widget
            'wpb_widget',

// Widget name will appear in UI
            __('WPBeginner Widget', 'wpb_widget_domain'),

// Widget description
            array('description' => __('Sample widget based on WPBeginner Tutorial', 'wpb_widget_domain'),)
        );
    }

// Creating widget front-end
// This is where the action happens
    public function widget($args, $instance)
    {
        $title = apply_filters('widget_title', $instance['title']);
// before and after widget arguments are defined by themes
        echo $args['before_widget'];
        if (!empty($title))
            echo $args['before_title'] . $title . $args['after_title'];

// This is where you run the code and display the output
        $prod_cats = $this->get_product_categories();
        if ($prod_cats == NULL)
            return NULL;

        $index = 0;
        $a = array_map(function ($obj) {
            return $obj->slug;
        }, $prod_cats);
        $product_cats = implode(", ", $a);
        ?>
        <div class="shop-sidebar-slider">
            <div id="upw-carousel" class="carousel slide" data-ride="carousel">
                <!-- Controls -->
                <a class="pull-right right carousel-control" href="#upw-carousel" role="button" data-slide="next">
                    <i class="icon-right-open-big" aria-hidden="true"></i>
                    <span class="sr-only"><?php _e('Next','sage');?></span>
                </a>
                <a class="pull-right left carousel-control" href="#upw-carousel" role="button" data-slide="prev">
                    <i class="icon-left-open-big" aria-hidden="true"></i>
                    <span class="sr-only"><?php _e('Previous','sage');?></span>
                </a>
                <!-- Wrapper for slides -->
                <div class="carousel-inner" role="listbox">
                    <?php $args = array('post_type' => 'product', 'posts_per_page' => -1, 'product_cat' => $product_cats, 'orderby' => 'rand');
                    $loop = new WP_Query($args);
                    while ($loop->have_posts()) : $loop->the_post();
                        $index++;
                        global $product;
                        global $post;//need debug on sale product
                        ?>
                        <article <?php post_class('item ' . (($index == 1) ? 'active' : '')); ?>>
                            <header>
                                <?php woocommerce_show_product_sale_flash($post, $product); ?>
                                <figure class="entry-image">
                                    <?php if (has_post_thumbnail($loop->post->ID)) echo get_the_post_thumbnail($loop->post->ID, 'shop_catalog'); else echo '<img src="' . woocommerce_placeholder_img_src() . '" alt="Placeholder" width="300px" height="300px" />'; ?>
                                </figure>
                                <div class="entry-cat">
                        <?php $product_cats = wp_get_post_terms( get_the_ID(), 'product_cat' );
                        if ( $product_cats && ! is_wp_error ( $product_cats ) ) {
                            $single_cat = array_shift($product_cats);
                            echo $single_cat->name;
                        }?></div>
                                <div class="entry-title"><?php the_title(); ?></div>
                                <a href="<?php echo get_permalink($loop->post->ID) ?>"
                                   title="<?php echo esc_attr($loop->post->post_title ? $loop->post->post_title : $loop->post->ID); ?>">
                                    <?php _e('View Now','sage');?> ►
                                </a>
                            </header>
                        </article>

                    <?php endwhile; ?>
                    <?php wp_reset_query(); ?>
                </div>
            </div>

        </div>
        <?php echo $args['after_widget'];
    }

// Widget Backend
    public function form($instance)
    {
        if (isset($instance['title'])) {
            $title = $instance['title'];
        } else {
            $title = __('New title', 'wpb_widget_domain');
        }
// Widget admin form
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                   name="<?php echo $this->get_field_name('title'); ?>" type="text"
                   value="<?php echo esc_attr($title); ?>"/>
        </p>
        <?php
    }

// Updating widget replacing old instances with new
    public function update($new_instance, $old_instance)
    {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        return $instance;
    }

// Helpers
    public function get_product_categories()
    {
        /* Pseudo:
            if is_post
              get_current_post
                for each cat of post
                  get_current_cat
                    which has artist obj: do
                      get artist's related product cat
            if is_page
              if parent==Artist
                get this page related product cat
              if grandparent == Artist
                get parent related product cat
            if is_post_type(event)
              get event related product cat
         * */
        global $wp_query;
        if (!$wp_query->is_singular) return NULL;

        $post = $wp_query->get_queried_object();
        if (get_post_type($post->ID) == "event"):
            //get product cat associate with event
            return array(get_field('product_category', $post->ID));
        else:
            //target: get artist page, then get taxonomy
            if (get_post_type($post->ID) == "post"):
                $categories = get_the_category($post->ID);
                if (!empty($categories)) :
                    $arr = array();
                    foreach ($categories as $category) :
                        $artist_link = get_field("artist_page", $category);
                        if ($artist_link):
                            $product_cat = get_field("product_category", $artist_link->ID);
                            array_push($arr, $product_cat);
                        endif;
                    endforeach;
                    if (count($arr) > 0) {
                        return $arr;
                    }
                endif;
            elseif (get_post_type($post->ID) == "page"):
                $parent_id = $post->post_parent;
                $artists_page = get_page_by_title("Artists");
                if ($parent_id == $artists_page->ID):
                    return array(get_field('product_category', $post->ID));
                else:
                    $ancestors = get_post_ancestors($post->ID);
                    if (in_array($artists_page->ID, $ancestors)):
                        return array(get_field('product_category', $parent_id));
                    endif;
                endif;
            endif;
        endif;
        return NULL;
    }
} // Class wpb_widget ends here

// Register and load the widget
function wpb_load_widget()
{
    register_widget(__NAMESPACE__ . '\\wpb_widget');
}

add_action('widgets_init', __NAMESPACE__ . '\\wpb_load_widget');