=== Browser Shots ===
Contributors: BinaryMoon, kevinlearynet
Tags: screenshot, browser, browser shot, generator, tool, automatic, shortcode, automate, screenshots, shots, web browser, window, snap, website, website screenshot, website preview
Requires at least: 3.6
Tested up to: 4.1
Stable tag: 1.3.1

Automate the process of taking website screenshots.

== Description ==

Use the `[browser-shot]` shortcode to automate the process of taking website screenshots. An icon is also added to the TinyMCE editor to make the shortcode creation process easy.

= Shortcode Preview =

`// basic shot 600px wide
[browser-shot url="http://link-to-website" width="600"]

// shot with link to other website
[browser-shot url="http://link-to-website" width="700" link="http://www.binarymoon.co.uk/"]

// shot with caption (uses default WordPress caption styles)
[browser-shot url="http://link-to-website" width="700"]Add Caption[/browser-shot]`

= Available Parameters =

* url (required) - the url of the link to shorten
* width - the width of the image
* height - the height of the image
* alt - the image alt text
* link - where the image links. Left blank it will point to the website where the screenshot is being taken
* target - browser target. Set to _blank to open in a new window

= Multisite Compatibility =

The *Browser Shots* plugin is compatibly with WordPress Multisite, just use the [Network Activate](http://codex.wordpress.org/Create_A_Network#WordPress_Plugins) feature to enable the shortcode on every site. If you only want to enable the shortcode for a specific site, activate the plugin for that site only.

== Installation ==

1. Install easily with the WordPress plugin control panel or manually download the plugin and upload the folder `browser-shots` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

== Screenshots ==

1. A view from inside of the WordPress TinyMCE editor
2. The formatted front-end view of generated screenshots. [See a live example](http://www.kevinleary.net/great-examples-software-web-design/)

== Changelog ==

= 1.3.1 =
* Fix a couple of small bugs with the visual editor and add support for all shortcode parameters

= 1.3 =
* Make the visual editor work again (thanks to Ciprian Dracea for the report and the code help!)
* add a new pop up box for the shortcode properties in visual editor mode

= 1.2 =
* Add 'link' attribute. Allows you to change the url that the screenshot links to
* Sanitize the height attribute and fix a small height related PHP error
* Add support for captions
* Add target attribute for opening links in new windows

= 1.1 =
* Add 'height' attribute to the TinyMCE prompts
* Allow users to override 'height' attribute in [browser-shot] shortcode

= 1.0 =
* Initial public release to the WordPress plugin repository