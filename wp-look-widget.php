<?php

/*
Plugin Name: Stylinity Look Widget
Author: Katherine Eisenbrand
Version: 1
*/

class stylinity_look_widget extends WP_Widget {
	
	// constructor
	function __construct() {
		// Give widget name here
		parent::__construct(
			'stylinity_look_widget', 
			__('Stylinight Look Widget', 'stylinity_text_domain'), 
			array('description' => __('Widget that makes individual products of a look shoppable', 'stylinity_text_domain'),)
		);
	}

	// front-end widget display
	public function widget($args, $instance) {
		$title = apply_filters('widget_title', $instance['title']);
		echo $args['before_widget'];
		if (!empty($title)) {
			echo $args['before_title'].$title. $args['after_title'];
		}
		$widgetId=uniqid();
		
		echo ("<div id=\"" . $widgetId . "\"></div><script>stylinityParams=null; stylinityParams = {\"url\": \"" . $instance['url'] .  "\",\"targetId\":\"".$widgetId ."\"};stylinitycreateLookWidget(stylinityParams);stylinityParams=null;</script>");
		echo $args['after_widget'];
	}

	
	// back-end widget form
	public function form($instance) {
		if (isset($instance['title'])) {
			$title = $instance['title'];
		} else {
			$title = __('Shop my look here!', 'stylinity_text_domain');
		}
		if (isset($instance['url'])) {
			$url = $instance['url'];
		} else {
			$url = __('', 'stylinity_text_domain');
		}

		?>
		<p>
			<label for = "<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Widget title:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this ->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>"> 
		</p>
		<p>
			<label for = "<?php echo $this->get_field_id( 'url' ); ?>"><?php _e( 'Look URL:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'url' ); ?>" name="<?php echo $this ->get_field_name( 'url' ); ?>" type="text" value="<?php echo esc_attr( $url ); ?>"> 
		</p>
		<?php
	}
	

	public function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['url'] = strip_tags($new_instance['url']);
		return $instance;
	}
}

add_action( 'wp_enqueue_scripts', 'add_my_js' );
 function add_my_js() {
	 wp_enqueue_script( 'StylinityProductsWidget', 'https://stylinitycdn.blob.core.windows.net/scripts/StylinityProductsWidget.js');
	 wp_register_script( 'StylinityProductsWidget', 'https://stylinitycdn.blob.core.windows.net/scripts/StylinityProductsWidget.js');
 }

add_action('widgets_init', 'stylinity_load_look_widget');
function stylinity_load_look_widget() {
	register_widget('stylinity_look_widget');
}