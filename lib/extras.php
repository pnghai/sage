<?php

namespace Roots\Sage\Extras;

use Roots\Sage\Setup;

/**
 * Add <body> classes
 */
function body_class($classes) {
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
function excerpt_more() {
  return ' &hellip; <a href="' . get_permalink() . '">' . __('Continued', 'sage') . '</a>';
}
add_filter('excerpt_more', __NAMESPACE__ . '\\excerpt_more');

// Creating the widget
class wpb_widget extends \WP_Widget {

  function __construct() {
    parent::__construct(
// Base ID of your widget
        'wpb_widget',

// Widget name will appear in UI
        __('WPBeginner Widget', 'wpb_widget_domain'),

// Widget description
        array( 'description' => __( 'Sample widget based on WPBeginner Tutorial', 'wpb_widget_domain' ), )
    );
  }

// Creating widget front-end
// This is where the action happens
  public function widget( $args, $instance ) {
    $title = apply_filters( 'widget_title', $instance['title'] );
// before and after widget arguments are defined by themes
    echo $args['before_widget'];
    if ( ! empty( $title ) )
      echo $args['before_title'] . $title . $args['after_title'];

// This is where you run the code and display the output
    echo __( 'Hello, World!', 'wpb_widget_domain' );
    $prod_cats = get_product_categories();
    if ($prod_cats == NULL)
      return NULL;

    foreach ($prod_cats as $prod_cat):
      $args = array( 'post_type' => 'product', 'posts_per_page' => 1, 'product_cat' => $prod_cat->slug, 'orderby' => 'rand' );
      $loop = new WP_Query( $args );
      while ( $loop->have_posts() ) : $loop->the_post(); global $product; ?>
            <h2>Shoes</h2>

                <li class="product">

                    <a href="<?php echo get_permalink( $loop->post->ID ) ?>" title="<?php echo esc_attr($loop->post->post_title ? $loop->post->post_title : $loop->post->ID); ?>">

                        <?php woocommerce_show_product_sale_flash( $post, $product ); ?>

                        <?php if (has_post_thumbnail( $loop->post->ID )) echo get_the_post_thumbnail($loop->post->ID, 'shop_catalog'); else echo '<img src="'.woocommerce_placeholder_img_src().'" alt="Placeholder" width="300px" height="300px" />'; ?>

                        <h3><?php the_title(); ?></h3>

                        <span class="price"><?php echo $product->get_price_html(); ?></span>

                    </a>

                    <?php woocommerce_template_loop_add_to_cart( $loop->post, $product ); ?>

                </li>

    <?php endwhile; ?>
    <?php wp_reset_query(); ?>
    <?php
      endforeach;
    echo $args['after_widget'];
  }

// Widget Backend
  public function form( $instance ) {
    if ( isset( $instance[ 'title' ] ) ) {
      $title = $instance[ 'title' ];
    }
    else {
      $title = __( 'New title', 'wpb_widget_domain' );
    }
// Widget admin form
    ?>
    <p>
      <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
    </p>
    <?php
  }

// Updating widget replacing old instances with new
  public function update( $new_instance, $old_instance ) {
    $instance = array();
    $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
    return $instance;
  }
// Helpers
/*
 *
 */
  private function get_product_category(){
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

    $post_id = $wp_query->get_queried_object_id();
    if (get_post_type($post_id)=="event"):
      //get product cat associate with event
      return array(get_field('product_category',$post_id));
    else:
      //target: get artist page, then get taxonomy
      if (get_post_type($post_id)=="post"):
        $categories = get_the_category($post_id);
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
      elseif (get_post_type($post_id)=="page"):
        $parents = get_post_ancestors($post_id);
        $parent_id = ($parents) ? $parents[count($parents) - 1] : $post_id;
        $artists_page = get_page_by_title("Artists");
        if ($parent_id == $artists_page->ID):
          return array(get_field('product_category',$post_id));
        else:
          $grandparents = get_post_ancestors($parent_id);
          $grandparent_id = ($grandparents) ? $grandparents[count($grandparents) - 1] : $parent_id;
          if ($grandparent_id == $artists_page->ID):
            return array(get_field('product_category', $parent_id));
          endif;
        endif;
      endif;
    endif;
    return NULL;
  }
} // Class wpb_widget ends here

// Register and load the widget
function wpb_load_widget() {
  register_widget(  __NAMESPACE__ . '\\wpb_widget' );
}
add_action( 'widgets_init', __NAMESPACE__ . '\\wpb_load_widget' );