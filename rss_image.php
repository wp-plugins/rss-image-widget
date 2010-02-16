<?php
/*
Plugin Name: RSS Images
Plugin URI: http://www.zackdesign.biz/category/wp-plugins/rss-image-widget
Description: RSS Image display using SimplePie
Author: Isaac Rowntree
Version: 1.3
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
                if (!class_exists('SimplePie'))
		    require_once(ABSPATH.'/wp-includes/class-simplepie.php');
		
		$feed = new SimplePie();
		$feed->set_feed_url($instance['url']);
		$feed->set_cache_location( ABSPATH.'/wp-content/cache');
		$feed->init();
		
		if ($instance['images'])
		{
		    echo '<div class="simplepie">';
		    
		    $count = 0;
		    
		    foreach ($feed->get_items() as $item)
		    {
			if ($count < $instance['images'])
			{			    
			    $count++;
			    $url = '';
			    
			    if ($enclosure = $item->get_enclosure())
	                    { 
		                $url = $enclosure->get_link();
				// For some reason question marks aren't happy
				$image = str_replace("?", '', htmlspecialchars($item->get_title()).'.jpg');
				
				if (!file_exists(ABSPATH.'/wp-content/cache/'.$image))
				{
				    // PHPThumb caching
				    require_once(ABSPATH.'/wp-content/plugins/rss-image-widget/phpthumb/ThumbLib.inc.php');
				
				    $thumb = PhpThumbFactory::create($url);  
				    
				    // Image width/height
				    $thumb->resize(150, 150)->save(ABSPATH.'/wp-content/cache/'.$image);  		
				}
			    }		    
			    
			    list($width, $height, $type, $attr) = getimagesize(ABSPATH.'/wp-content/cache/'.$image);
			    
			    echo '
			             <div class="rss_image">
				         <h5><a href="'.$item->get_permalink().'">'.$item->get_title().'</a></h5><br />
                                         <a href="'.$item->get_permalink().'"><img width="'.$width.'" height="'.$height.'" src="'.get_bloginfo('wpurl').'/wp-content/cache/'.$image.'" alt="'.$item->get_title().'" /></a>
				    </div><br />';
			}
			else
			    break;
		    }
		    
		    echo '</div>';
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