=== WP-Konami ===
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=pL%40fusi0n%2eorg&lc=CA&item_name=Pier%2dLuc%20Petitclerc%20%2d%20Code%20Support&currency_code=CAD&bn=PP%2dDonationsBF%3abtn_donate_SM%2egif%3aNonHostedGuest
Tags: jquery, konami
Requires at least: 2.7
Tested up to: 2.8.9
Stable tag: 1.3.1
Author: Pier-Luc Petitclerc
Author URI: http://blog.fusi0n.org

Add the [Konami Code](http://en.wikipedia.org/wiki/Konami_Code) to your WordPress blog and redirect to a custom URL on successful input sequence

== Description ==

WP-Konami adds a small JavaScript to your WordPress blog (all pages or just the index) that adds a hook that listens to user input for the [Konami Code](http://en.wikipedia.org/wiki/Konami_Code).
When users successfully input the code, they are redirected to a custom URL.

== Installation ==

Extract all files from the ZIP file, making sure to keep the file structure intact, and then upload it to `/wp-content/plugins/`. Then just visit your admin area and activate the plugin. That’s it! You can access the settings via the ‘Plugins’ menu or in ‘Settings’ -> ‘WP-Konami.
See Also: [“Installing Plugins” article on the WordPress Codex](http://codex.wordpress.org/Managing_Plugins#Installing_Plugins)

== Frequently Asked Questions ==

= What is the Konami Code? =

Up, Up, Down, Down, Left, Right, Left, Right, B, A


== ChangeLog ==

= Version 1.3.1 =

* Upgraded to jQuery 1.4.2

= Version 1.3 =

* Fixed Settings Bug ([K](http://blog.fusi0n.org/wp-konami/konami-code-hook-for-your-wordpress-blog/comment-page-1#comment-744))

= Version 1.2 =

* Ensured WordPress 2.8.6 Compatibility

= Version 1.1 =

* Code improvements
* Implemented WordPress' [Settings API](http://codex.wordpress.org/Settings_API)
* The settings page is now located under WordPress' 'Miscellaneous' section.
* Changed minimum required WordPress version to 2.7

= Version 1.0.2 =

* Insured Wordpress 2.8 compatibility

= Version 1.0.1 =

* Fixed a small bug that rendered the 'Settings' link on the plugins list page incorrect [Augustine](http://www.affiliatewarriors.com)
* Added code comments
* Added French localization

= Version 1.0 =

* Initial release
