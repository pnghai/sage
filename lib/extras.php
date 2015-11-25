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
} // Class wpb_widget ends here

// Register and load the widget
function wpb_load_widget() {
  register_widget(  __NAMESPACE__ . '\\wpb_widget' );
}
add_action( 'widgets_init', __NAMESPACE__ . '\\wpb_load_widget' );