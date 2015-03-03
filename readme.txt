=== GeoDirectory - Genesis Compatibility Pack ===
Contributors: stiofansisland, paoltaia, posh-john
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_xclick&business=payments@nomaddevs.com&item_name=Donation+for+WPGD
Tags:  Genesis, geodirectory, address book, addressbook, addresses, bio, biographies, bios, business, business directory plugin, business-directory, businesses, directories, directory, directory plugin, directory widget, googlemap, googlemaps, google maps, list, listings, lists, member directory, members directories, members directory, microformat, microformats, profile, profiles, staff, user, users, vcard, wordpress business directory, wordpress directory, wordpress directory plugin, yelp clone, tripadvisor clone, yellow pages clone, wordpress business directory plugin, wordpress directory theme, wordpress business directory theme, wordpress city directory plugin, wordpress local directory plugin
Requires at least: 3.1
Tested up to: 4.1.0
Stable tag: 1.0.5
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html
This plugin is no longer needed. GeoDirectory is now compatible with Genesis out of the box

== Description ==

This plugin is no longer needed. GeoDirectory is now compatible with Genesis out of the box

With [GeoDirectory plugin](http://wordpress.org/plugins/geodirectory) and the compatibility pack you can Turn your Genesis powered website into an interactive Business Directory!

Given the high number of requests for 100% compatibility with this theme layout, we decided to pack the necessary functions and css hacks in a simple plugin.

The plugin does a very simple thing. Through action hooks and filters, it removes the default html wrappers from GeoDirectory templates and adds Genesis html wrappers. 

This make GeoDirectory pages display gracefully when used with Genesis. 

= Requires GeoDirectory and Genesis theme by StudioPress =

* [Get GeoDirectory](https://wordpress.org/plugins/geodirectory/).
* [Get GeoDirectory Addons](http://wpgeodirectory.com/).
* [Get Genesis](http://my.studiopress.com/themes/genesis/).

== Installation ==
= Minimum Requirements =
* WordPress 3.1 or greater
* PHP version 5.2.4 or greater
* MySQL version 5.0 or greater
= Automatic installation =
Automatic installation is the easiest option. To do an automatic install (make sure you already have GeoDirectory and Genesis installed), log in to your WordPress dashboard, navigate to the Plugins menu and click Add New.
In the search field type "GeoDirectory - Genesis Compatibility Pack" and click Search Plugins. Once you've found the compatibility plugin you install it by simply clicking Install Now. 
= Manual installation =
The manual installation method involves downloading the plugin and uploading it to your webserver via your favourite FTP application. The WordPress codex will tell you more [here](http://codex.wordpress.org/Managing_Plugins#Manual_Plugin_Installation). 
= Updating =
Automatic updates should seamlessly work. We always suggest you backup up your website before performing any automated update to avoid unforeseen problems.

== Frequently Asked Questions ==
[GeoDirectory FAQ](http://wpgeodirectory.com/faq/).
== Screenshots ==
= coming soon =
== Changelog ==
= 1.0.5 =
* Double map issue becasue of GeoDirectory template change - FIXED
* PHP warning messages resolved - FIXED
= 1.0.4 =
* Removed unneccesary css
* Re-built structure to include:
* Force full-width layout on signup page
* Make secondary sidebar appear beneath GD top widgets
* Allow GD left sidebars or default to Genesis secondary sidebar

* Added Genesis hooks for:
* genesis_before_content_sidebar_wrap
* genesis_before_content
* genesis_before_sidebar_widget_area
* genesis_after_sidebar_widget_area
* genesis_before_sidebar_alt_widget_area
* genesis_after_sidebar_alt_widget_area

* Added conditional to stop breadcrumb wrapper appearing on homepage and signup page

= 1.0.3 =
* Removed unneccesary css
* Added Genesis secondary sidebar for 3 column child themes
* Changed homepage map function to accomodate different homepage uses
* Added function to re-enqueue child theme stylesheet after all plugins
= 1.0.1 =
initial release
== Upgrade Notice ==
= none =
