<?php
/*
Plugin Name: RSS Images
Plugin URI: http://www.zackdesign.biz/wp-plugins/40
Description: RSS Image display using SimplePie
Author: Isaac Rowntree
Version: 1.2.1
Author URI: http://zackdesign.biz

	Copyright (c) 2005, 2006 Isaac Rowntree (http://zackdesign.biz)
	QuickShop is released under the GNU General Public
	License (GPL) http://www.gnu.org/licenses/gpl.txt

	This is a WordPress plugin (http://wordpress.org).

*/

/**
 * RSSImages Class
 */
class RSSImages extends WP_Widget {
    /** constructor */
    function RSSImages() {
        parent::WP_Widget(false, $name = 'RSS Images');	
    }

    /** @see WP_Widget::widget */
    function widget($args, $instance) {		
        extract( $args );
        $title = apply_filters('widget_title', $instance['title']);
        
	echo $before_widget; 
        
	if ( $title )
            echo $before_title . $title . $after_title; 
	
	if (!empty($instance['url']))
    	{
            if ( function_exists('SimplePieWP'))
	    {
		if (!$instance['images'])
                    echo SimplePieWP($instance['url'], array('template' => 'image_widget'));
                else
                    echo SimplePieWP($instance['url'], array('items' => $instance['images'], 'template' => 'image_widget'));
    	    }
            else
	        echo 'You must have SimplePie plugin installed before this plugin will work.';
	}
        
	echo $after_widget; 
    }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {				
        return $new_instance;
    }

    /** @see WP_Widget::form */
    function form($instance) {				
        $title = esc_attr($instance['title']);
	$url = esc_attr($instance['url']);
	$images = esc_attr($instance['images']);
	
	if (empty($url))
	    $url = 'http://api.flickr.com/services/feeds/photos_public.gne?id=25087033@N04&lang=en-us&format=atom';
        
	if (empty($images))
	    $images = 0;
	
        ?>
            <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
	    <p><label for="<?php echo $this->get_field_id('url'); ?>"><?php _e('Feed Url:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('url'); ?>" name="<?php echo $this->get_field_name('url'); ?>" type="text" value="<?php echo $url; ?>" /></label></p>
	    <p><label for="<?php echo $this->get_field_id('images'); ?>"><?php _e('# of Images:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('images'); ?>" name="<?php echo $this->get_field_name('images'); ?>" type="text" value="<?php echo $images; ?>" /></label></p>
        <?php 
    }

} // class RSSImages


add_action('widgets_init', create_function('', 'return register_widget("RSSImages");')); // register RSSImages widget


?>