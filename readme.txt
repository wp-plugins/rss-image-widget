=== RSS Image Widget ===
Contributors: zackdesign
http://www.zackdesign.biz/wp-plugins/40
Tags: rss, image, feed, widget, simplepie, plugin
Requires at least: 2.3
Tested up to: 2.3
Stable tag: 1.0

This plugin provides you with a widget to display images from a feed. It requires the SimplePie plugin to be installed.

== Description ==

Image Feeds will work in the plugin providing that they use enclosures. If you want you can change the template provided to suit your feed if necessary, though this should work if enclosures are used correctly.

I have set the default image width in the template to be 150 pixels wide. You can change or remove this in the template as you like. The template file is the one with the .tmpl extension. To find out what tags you can use in the template [visit this site](http://simplepie.org/wiki/plugins/wordpress/simplepie_plugin_for_wordpress#template_tags "Template Tags").

[SimplePie](http://wordpress.org/extend/plugins/simplepie-plugin-for-wordpress/ "Simplepie") is required as a plugin for this widget/plugin to work.

Simplepie provides its own options area in admin. I suggest you get familiar with it.

This widget also requires that Sidebar Widgets are installed.
 
Please be aware that I'll only be updating this if I need to. Feel free to come on board and contribute!

== Installation ==

** You must have installed Simplepie Plugin for Wordpress before continuing. **

1. Upload the 'rss-image-widget' folder to the `/wp-content/plugins/` directory
2. IMPORTANT - Copy 'image_widget.tmpl' to the `/wp-content/plugins/simplepie-plugin-for-wordpress/templates/` directory. 
3. Activate the plugin through the 'Plugins' menu in WordPress
4. Go to the Presentation menu in Wordpress Admin and choose 'Widgets' in the submenu.
5. Drag and drop the Rss Image widget onto your sidebar.
6. Click on the widget in the form area and it should popup the form. Put your feed address in the correct spot, and optionally specify the number of images. If you don't, it will use the default Simplepie settings.


--------------------------------------------


== Frequently Asked Questions ==

= I Need HELP!!! =

That's what I'm here for. I do Wordpress sites for many people in a professional capacity and
can do the same for you. Check out www.zackdesign.biz

= Where do I get SimplePie? =

Weren't you paying attention? Read the Description again!!!

