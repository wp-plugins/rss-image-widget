<?php
/*
Plugin Name: RSS Images
Plugin URI: http://www.zackdesign.biz/wp-plugins/40
Description: RSS Image display using SimplePie
Author: Isaac Rowntree
Version: 1.3.1
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
				
				if (empty($instance['width']))
	    	    	    	    $instance['width'] = 150;
				if (empty($instance['height']))
				    $instance['height'] = 150;
				    
				// Remove questions marks as well
				$image = str_replace("?", '', htmlspecialchars($item->get_title()).'_'.$instance['width'].'x'.$instance['height'] .'.jpg');
				
				$cache_path = ABSPATH.'/wp-content/cache/rss_image_cache_'.date('n');
				
				// Garbage Collection
				for ($i = 1; $i < date('n'); $i++)
				{
				    rss_image_delTree(ABSPATH.'/wp-content/cache/rss_image_cache_'.$i);
				}
				
				// Create the image file if it doesn't exist
				if (!file_exists($cache_path.'/'.$image))
				{
				    // PHPThumb caching
				    require_once(ABSPATH.'/wp-content/plugins/rss-image-widget/phpthumb/ThumbLib.inc.php');
				
				    $thumb = PhpThumbFactory::create($url);  
				    
				    if (!file_exists($cache_path))
				        mkdir($cache_path);
					
				    // Image width/height	
				    $thumb->resize($instance['width'], $instance['height'])->save($cache_path.'/'.$image);  		
				}
			    }		    
			    
			    echo '
			             <div class="rss_image">
				         <h5><a href="'.$item->get_permalink().'">'.$item->get_title().'</a></h5><br />
                                         <a href="'.$item->get_permalink().'"><img src="'.get_bloginfo('wpurl').'/wp-content/cache/rss_image_cache_'.date('n').'/'.$image.'" alt="'.$item->get_title().'" /></a>
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
	$width = esc_attr($instance['width']);
	$height = esc_attr($instance['height']);
	
	if (empty($url))
	    $url = 'http://api.flickr.com/services/feeds/photos_public.gne?id=25087033@N04&lang=en-us&format=atom';
        
	if (empty($images))
	    $images = 0;
	
	if (empty($width))
	    $width = 150;
	    
	if (empty($height))
	    $height = 150;
	
        ?>
            <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
	    <p><label for="<?php echo $this->get_field_id('url'); ?>"><?php _e('Feed Url:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('url'); ?>" name="<?php echo $this->get_field_name('url'); ?>" type="text" value="<?php echo $url; ?>" /></label></p>
	    <p><label for="<?php echo $this->get_field_id('images'); ?>"><?php _e('# of Images:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('images'); ?>" name="<?php echo $this->get_field_name('images'); ?>" type="text" value="<?php echo $images; ?>" /></label></p>
	    <p><label for="<?php echo $this->get_field_id('width'); ?>"><?php _e('Max Image Width:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" type="text" value="<?php echo $width; ?>" /></label></p>
	    <p><label for="<?php echo $this->get_field_id('height'); ?>"><?php _e('Max Image Height:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('height'); ?>" name="<?php echo $this->get_field_name('height'); ?>" type="text" value="<?php echo $height; ?>" /></label></p>
        <?php 
    }

} // class RSSImages


add_action('widgets_init', create_function('', 'return register_widget("RSSImages");')); // register RSSImages widget

    function rss_image_delTree($dir) {
        $files = glob( $dir . '*', GLOB_MARK );
        foreach( $files as $file )
	{
            if( substr( $file, -1 ) == '/' )
                rss_image_delTree( $file );
            else
                unlink( $file );
        }
        if (is_dir($dir)) rmdir( $dir );
    } 

?>