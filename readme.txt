=== RSS Image Widget ===
Contributors: zackdesign
http://www.zackdesign.biz/category/wp-plugins/rss-image-widget
Tags: rss, image, feed, widget, simplepie, plugin
Requires at least: 2.8
Tested up to: 2.9.2
Stable tag: 1.3

This plugin provides you with a widget to display images from a feed. It requires the SimplePie plugin to be installed.

== Description ==

This Widget uses PHPThumb to automatically generate good-looking thumbnails from RSS feed images inside your template. These thumbnails and the feed are cached inside `wp-content/cache` so please ensure that the directory is writable.

Image Feeds will work in the plugin providing that they use enclosures. If you want you can change the template provided to suit your feed if necessary, though this should work if enclosures are used correctly.

I have set the default image width in the template to be 150 pixels wide. You can change or remove this in the plugin file as you like.

SimplePie plugin is no longer required for this plugin as it now ships with Wordpress 2.8 and above! 

Next version will include some extra options and possibly better HTML.

* Link to full image or enclosure URL option
* PHPThumb reflection option (and other options)
* Some cache options
* Much more
 
Please be aware that I'll only be updating this if I need to. Feel free to come on board and contribute!

== Upgrade Notice ==

If you're upgrading and you made changes to the template I provided please note that the template is no longer in use. In that case maybe hold off upgrading if you're not confident editing the actual plugin file.

== Screenshots ==

[Zack Design Plugin Showcase](http://wordpress.zackdesign.biz "Plugin Showcase")

== Installation ==

1. Upload the 'rss-image-widget' folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to the Presentation menu in Wordpress Admin and choose 'Widgets' in the submenu.
4. Drag and drop the Rss Image widget onto your sidebar.
5. Click on the widget in the form area and it should popup the form. Put your feed address in the correct spot, and specify the amount of images you want to use.


== Changelog ==

1.3 

- SimplePie dependency removed as it comes with Wordpress > 2.7
- Template dependency removed as a result of above. Now a truly plug and play solution!
- PHPThumb changed to latest version from http://phpthumb.gxdlabs.com/
- Now truly cachable

1.2.1

- Change image_widget.tmpl to validated XHTML 1.0 Transitional

1.2

- Uses Wordpress 2.8 widget class which means it now supports multiple instances!

1.1

- Addition to admin of changeable title

1.0

- First release

== Frequently Asked Questions ==

= Purple PHPThumb screen =

Usually this is because you have not made PHPThumb's cache directory readable.

= I Need HELP!!! =

That's what I'm here for. I do Wordpress sites for many people in a professional capacity and
can do the same for you. Check out www.zackdesign.biz

= Where do I get SimplePie? =

Weren't you paying attention? Read the Description again!!!

