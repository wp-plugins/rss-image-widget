<?php
/*
Plugin Name: RSS Images
Plugin URI: http://zackdesign.biz/
Description: RSS Image display using SimplePie
Author: Isaac Rowntree
Version: 2.0.2
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
            
        if ( $title ) {
            echo $before_title . $title . $after_title; 
        }
        
        if (!empty($instance['url'])) {

            if (!class_exists('SimplePie')) {
                require_once(ABSPATH.'/wp-includes/class-simplepie.php');
            }
            
            $feed = new SimplePie();
            $feed->set_feed_url($instance['url']);
            // If image uploads work this will work
            $directories = wp_upload_dir();
            $feed->set_cache_location($directories['basedir']); 
            $feed->init();
            
            if ($instance['images']) {
                echo '<div class="row rss_image">';
                $count = 0;
                
                foreach ($feed->get_items() as $item) {

                    if ($count < $instance['images']) {			    

                        $count++;
                        $url = '';
                        
                        if ($enclosure = $item->get_enclosure()) { 
                            $url = $enclosure->get_link();
                        } ?> 
<div class="col-xs-12">
    <a href="<?php echo $url; ?>" class="thumbnail gallery" data-lightbox="feed-gallery" data-title="<?php echo $item->get_title(); ?>">
        <img src="<?php echo $url; ?>" alt="<?php echo $item->get_title(); ?>">
    </a>
    <div class="caption">
        <h3><a href="<?php echo $item->get_link(); ?>" target="_blank" title="<?php echo $item->get_title(); ?>"><?php echo $item->get_title(); ?></a></h3>
    </div>
</div>
<?php               } else {
                        break;
                    }
                }
                echo "</div>";
            }
        }
            
        echo $after_widget; 
        }

        /** @see WP_Widget::update */
        function update($new_instance, $old_instance) {				
            return $new_instance;
        }

        /** @see WP_Widget::form */
        function form($instance) {				
            if (isset($instance['title'])) : $title = esc_attr($instance['title']); else : $title = ''; endif;
        if (isset($instance['url'])) : $url = esc_attr($instance['url']); endif;
        if (isset($instance['images'])) : $images = esc_attr($instance['images']); endif;
        
        if (empty($url))
            $url = 'http://api.flickr.com/services/feeds/photos_public.gne?id=25087033@N04&lang=en-us&format=atom';
            
        if (empty($images))
            $images = 5;
        
        if (empty($width))
            $width = 150;
            
          ?>
          <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
            <p><label for="<?php echo $this->get_field_id('url'); ?>"><?php _e('Feed Url:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('url'); ?>" name="<?php echo $this->get_field_name('url'); ?>" type="text" value="<?php echo $url; ?>" /></label></p>
            <p><label for="<?php echo $this->get_field_id('images'); ?>"><?php _e('# of Images:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('images'); ?>" name="<?php echo $this->get_field_name('images'); ?>" type="text" value="<?php echo $images; ?>" /></label></p>
          <?php 
    }

} // class RSSImages

if (!class_exists("RSSImagesMain"))  {
  class RSSImagesMain {
  
    function RSSImagesMain() {
        add_action('init', array($this, 'doEnqueue'));
        add_action('widgets_init', create_function('', 'return register_widget("RSSImages");')); // register RSSImages widget
    }

    function doEnqueue() {
       add_action('wp_enqueue_scripts', array($this, 'shadowBoxScript'));
    }

    function shadowBoxScript() {
        if (!is_admin()) {
          wp_enqueue_script('lightbox', 'https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.7.1/js/lightbox.min.js', array('jquery'), '2.7.1', true);
          wp_enqueue_style('lightbox', 'https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.7.1/css/lightbox.css');
        }
    }
  }
}

if (class_exists('RSSImagesMain'))
{
  $rssImages = new RSSImagesMain();
}
