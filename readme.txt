=== RSS Image Widget ===
Contributors: zackdesign
http://zackdesign.biz/
Tags: rss, image, feed, widget, simplepie, plugin
Requires at least: 2.8
Tested up to: 4.1.1
Stable tag: 2.0.1

This plugin provides you with a widget to display images from a feed. It requires Wordpress' SimplePie include.

== Description ==

New 2.0.1 release! This should be far more stable! Please let me know via zackdesign.biz if there's anything broken in your layouts as a result of moving to Bootstrap HTML.

Image Feeds will work in the plugin providing that they use enclosures. If you want you can change the template provided to suit your feed if necessary, though this should work if enclosures are used correctly.

Please be aware that I'll only be updating this if I need to. Feel free to come on board and contribute!

== Installation ==

1. Upload the 'rss-image-widget' folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to the Presentation menu in Wordpress Admin and choose 'Widgets' in the submenu.
4. Drag and drop the Rss Image widget onto your sidebar.
5. Click on the widget in the form area and it should popup the form. Put your feed address in the correct spot, and specify the amount of images you want to use.


== Changelog ==

2.0.1

- Fix for PHP 5.3

2.0.0

- Now using Lightbox provided by CDN instead of Shadowbox
- Bootstrap-compatible classes and HTML - apologies if you were depending on the original layout
- No more need for caching. I figured this was causing too many issues
- SimplePie caches using the Wordpress upload directory if available

1.4.2

- Removal of PHP Thumb to remove thumbnail generation. Figured this was unnecessary
- Removal of garbage collection function as it was deleting stuff by accident

1.4.1

- Updated the license requirements
- Tested in 3.3.2

1.4

- Now comes with Shadowbox for showing images in gallery
- Updated view of text makes layout easier for those using CSS
- Titles moved below image by default
- Clicking image shows the full size
- Clicking title sends you to the website
- Improved caching - provides an error message if there is no cache folder in admin

1.3.1

- Intelligent garbage collection (removal of old images based on month)
- Width/Height resizing now settable in widget

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

= Images aren't appearing =

It could be that your feed doesn't have enclosures. If you don't know what this is please read this: http://en.wikipedia.org/wiki/RSS_enclosure

= I Need HELP!!! =

That's what I'm here for. I do Wordpress sites for many people in a professional capacity and
can do the same for you. Check out www.zackdesign.biz
