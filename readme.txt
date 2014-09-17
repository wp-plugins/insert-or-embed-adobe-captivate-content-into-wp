=== Insert or Embed Adobe Captivate Content into Wordpress ====

Contributors: elearningplugins.com
Donate link: http://www.elearningplugins.com
Tags: adobe, captivate, embed, upload, lightbox
Requires at least: 2.0.2
Tested up to: 4.0
Stable tag: 1.0License: GPLv2 or laterLicense URI: http://www.gnu.org/licenses/gpl-2.0.html
 
Quickly embed or insert Adobe Captivate content into a post or page.

== Description ==

This plugin will add a new toolbar icon (the letter 'Cp') next to the 'Add Media' button on the Edit Post and Edit Page pages and enable you to insert or embed Adobe Captivate content into WordPress. Upon clicking this toolbar icon, you will have the ability to upload your published Adobe Captivate content as a ZIP file. Once uploaded, the plugin will automatically extract the content, find the appropriate .html file, and add code to your post or page that will display your Adobe Captivate content as an iframe or a lightbox.

== Installation ==

1. Upload the 'insert-or-embed-adobe-captivate-content-into-wordpress-v1.0' folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

== How to Use ==

Check out the screencast in the link below to learn how to use this plugin:

http://www.youtube.com/watch?v=zb4eANMb9Ew

== Frequently Asked Questions ==

= How do I use this to embed Adobe Captivate content? =

Check out this screencast:  http://www.youtube.com/watch?v=zb4eANMb9Ew

= How do I customize the lightbox? =

The lightbox functionality is provided by Jack Moore's ColorBox.  To customize it, see the support here: http://www.jacklmoore.com/colorbox

= Why does the upload never finish or I get a -1 error message? = 

In order to resolve this issue, you need to update your php.ini to reflect the following:

post_max_size = 50M

max_execution_time = 60

max_input_time = 60

upload_max_filesize = 50M


(These settings will vary depending upon your server and content.  You may need to contact your hosting company to make these changes.) 

= If I delete the plugin, what happens to the content that I've uploaded? =

The uploaded content is saved into a folder on your site.  Thus, your uploaded content will not be removed if you delete this plugin.

== Changelog ==

= 1.0 =
Initial version.