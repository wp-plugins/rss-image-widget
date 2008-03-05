<?php
/*
Plugin Name: RSS Images
Plugin URI: http://www.zackdesign.biz/wp-plugins/34
Description: RSS Image display using SimplePie
Author: Isaac Rowntree
Version: 1.0
Author URI: http://zackdesign.biz

	Copyright (c) 2005, 2006 Isaac Rowntree (http://zackdesign.biz)
	QuickShop is released under the GNU General Public
	License (GPL) http://www.gnu.org/licenses/gpl.txt

	This is a WordPress plugin (http://wordpress.org).


*/

// Put functions into one big function we'll call at the plugins_loaded
// action. This ensures that all required plugin functions are defined.
function widget_rss_images_init() {

	// Check for the required plugin functions. This will prevent fatal
	// errors occurring when you deactivate the dynamic-sidebar or simplepie plugin.
	if ( !function_exists('register_sidebar_widget') )
		return;
	if ( !function_exists('SimplePieWP') )
		return;
	

	// This is the function that outputs our little Google search form.
	function widget_rss_images($args) {

		// $args is an array of strings that help widgets to conform to
		// the active theme: before_widget, before_title, after_widget,
		// and after_title are the array keys. Default tags: li and h2.
		extract($args);

  		// Each widget can store its own options. We keep strings here.
  		$options = get_option('widget_rss_images');
  		$url = $options['url'];
  		
  		$items = $options['images'];

    		// These lines generate our output. Widgets can be very complex
    		// but as you can see here, they can also be very, very simple.
    		echo $before_widget . $before_title;    		
        echo 'Images'.$after_title;
    		
    		    if ($url && ($url != ''))
    		    {
                if (!$items)
                    echo SimplePieWP($url, array('template' => 'image_widget'));
                else
                    echo SimplePieWP($url, array('items' => $items, 'template' => 'image_widget'));
    		    }
        echo $after_widget;
		
	}

	// This is the function that outputs the form to let the users edit
	// the widget's title. It's an optional feature that users cry for.
	function widget_rss_images_control() {

		// Get our options and see if we're handling a form submission.
		$options = get_option('widget_rss_images');
		if ( !is_array($options) )
		{
			$options = array('url'=>'', 'images'=>'0');
		}
		
		if ( $_POST['rss_images-submit'] ) {
			// Remember to sanitize and format use input appropriately.
			$options['url'] = strip_tags(stripslashes($_POST['rss_images-url']));
      $options['images'] = $_POST['rss_images-images'];
			update_option('widget_rss_images', $options);
		}

		// Be sure you format your options to be valid HTML attributes.
		$url = htmlspecialchars($options['url'], ENT_QUOTES);
		$images=$options['images'];
		
		// Here is our little form segment. Notice that we don't need a
		// complete form. This will be embedded into the existing form.
		echo '<p style="text-align:left;"><label for="rss_images-url">' . __('Feed:') . ' <input style="width: 200px;" id="rss_images-url" name="rss_images-url" type="text" value="'.$url.'" /></label></p>';
		echo '<p style="text-align:left;"><label for="rss_images-images">' . __('# of Images:') . ' <input style="width: 30px;" id="rss_images-images" name="rss_images-images" type="text" value="'.$images.'" /></label></p>';
		echo '<input type="hidden" id="rss_images-submit" name="rss_images-submit" value="1" />';
	}
	
	// This registers our widget so it appears with the other available
	// widgets and can be dragged and dropped into any active sidebars.
	register_sidebar_widget(array('RSS Images', 'widgets'), 'widget_rss_images');

	// This registers our optional widget control form. Because of this
	// our widget will have a button that reveals a 300x100 pixel form.
	register_widget_control(array('RSS Images', 'widgets'), 'widget_rss_images_control', 300, 190);
}

// Run our code later in case this loads prior to any required plugins.
add_action('widgets_init', 'widget_rss_images_init');

?>
