=== WP Catalogue ===
Contributors: EnigmaWeb
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=CEJ9HFWJ94BG4
Tags: WP Catalogue, catalogue, catalog, product catalog, product catalogue, display products, wp catalog, list products, products
Requires at least: 3.1
Tested up to: 3.5.2
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

WP Catalogue - the best way to display your digital product catalogue.

== Description ==

Use WP Catalogue to display your products in an attractive and professional catalogue. It's easy to use, easy to customise, and lets you show off your products in style. Add to any page using shortcode `[wp-catalogue]`

= Key Features =

*	Simple, light-weight product catalogue
*	Add up to 3 images per product, displaying in an interactive lightbox
*   Customise your catalogue presentation easily (set image sizes, number of products per page, pagination, grid layout etc)
*	Completely customise the design of the catalogue via your theme css - great for designers/developers
*	Integrated breacrumb for easy hassel-free navigation
*	Next/Previous navigation (optional)
*	Display product price (optional)
*	Drag & Drop to easily order products and categories
*   Works in all major browsers - IE7, IE8, IE9, Safari, Firefox, Chrome
*	Add to any page using shortcode `[wp-catalogue]`

= Demo =

*	[Click here](http://demo.enigmaweb.com.au/wp-catalogue/) for out-of-the-box demo
*	[Click here](http://www.freewheelbicyclestore.com.au/bicycles-accessories/) for an example of a fully styled implementation

== Installation ==

1. Upload the `wp-catalogue` folder to the `/wp-content/plugins/` directory
1. Activate the WP Catalogue plugin through the 'Plugins' menu in WordPress
1. Configure the plugin by going to the `WP Catalogue` tab that appears in your admin menu.
1. Add to any page using shortcode `[wp-catalogue]`
 
== Frequently Asked Questions ==

= Can I sell products through this plugin? =

No. There are already lots of good eCommerce plugins that you can use to sell things. WP Catalogue is different - it is used for people who want to show a catalogue of products ONLY, not for selling things online.

= How can I customise the design? =

You can do some basic presentation adjustments via WP Catalogue > Settings. Beyond this, you can completely customise the design via your theme css. 

= The layout is broken =

It's most likely just a matter of tweaking the css. In particular check the width of the right column that holds the catalogue items as this is the most common cause of layout issues. Remember, if you want to make changes to how the catalogue displays you need to do it in your theme css not in the plugin css. You can use the !important attribute to override the plugin css.

= My main catalogue page works fine but the inner pages are broken =

This sometimes happens if the catalogue doesn't know which page template to use. You can fix this on the Settings Screen by manually adding your Inner Template Header and Inner Template Footer. If you're confused, take a look at the plugin file single-wpcproduct.php which is in /themefiles and you'll see where this code will end up (at the top and bottom of the file, with the WP Catalogue content sitting within it). 

= Can import/export my catalogue? =

Yes. You can import/export catalogue data using the built in WordPress function via Tools. It may not import the images (although it will import the file paths) so you will need to copy across all your catalogue images from your old site to the new site uploads folder via FTP. If images still appear broken or missing then you might need to run a search and replace tool to correct the image filepaths for your new site.

= What features are coming soon? =

*	Internationalization
*	Colour picker for cusomising the theme green colour
*	[Pro Version](http://www.maevelander.net/wp-catalogue-going-pro/) with many more advanced features

= Where can I get support for this plugin? =

If you've tried all the obvious stuff and it's still not working please request support via the forum.


== Screenshots ==

1. An example of WP Catalogue in action, main catalogue view
2. Another example of WP Catalogue front-end, product detail view
3. The settings screen in WP-Admin
4. The product editor in WP-Admin

== Changelog ==

= 1.5 =
* Bug fix - fixed scale and crop function
* Bug fix - fixed module output (now it uses return not echo) so that you can place the catalogue at any position on a page with text either before or after it
* Bug fix/work-around - added fields in settings for Inner Page template header and footer as a work-around for users experiencing theme issues with inner page layout template. See FAQ for more info

= 1.4 =
* Bug fix - breadcrumb all products link
* Bug fix - broken image on second thumbnail in IE8
* Bug fix - foreach fix for single-wpcproduct.php (thanks pedrolaxe)
* Bug fix - pagination
* New feature - next/previous function with on/off selector
* New feature - product price field (leave blank to disable on any product)

= 1.3 =
* Fixed bug in index.php still causing problem with breacrumb for some users

= 1.2 =
* Fixed several minor bugs and updated EOL for subversion

= 1.1 =
* Fixed a shortcode issue which was effecting the breadcrumb link

= 1.0 =
* Initial release

== Upgrade Notice ==

= 1.5 =
* Bug fix - fixed scale and crop function
* Bug fix - fixed module output (now it uses return not echo) so that you can place the catalogue at any position on a page with text either before or after it
* Bug fix/work-around - added fields in settings for Inner Page template header and footer as a work-around for users experiencing theme issues with inner page layout template. See FAQ for more info

= 1.4 =
* Bug fix - breadcrumb all products link
* Bug fix - broken image on second thumbnail in IE8
* Bug fix - foreach fix for single-wpcproduct.php (thanks pedrolaxe)
* Bug fix - pagination
* New feature - next/previous function with on/off selector
* New feature - product price field (leave blank to disable on any product)

= 1.3 =
* Fixed bug in index.php still causing problem with breacrumb for some users

= 1.2 =
* Fixed several minor bugs and updated EOL for subversion

= 1.1 =
* Fixed a shortcode issue which was effecting the breadcrumb link

= 1.0 =
* Initial release
