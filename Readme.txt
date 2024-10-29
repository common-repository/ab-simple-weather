=== AB Simple Weather ===
Contributors: abooze
Donate link: http://aboobacker.com/
Tags: 1.2
Requires at least: 4.0
Tested up to: 4.9.4
Requires PHP: 5.4
Stable tag: 1.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A simple but powerful Wordpress plugin to display the weather information on your website.

== Description ==

Want to display a beautiful weather snippet in your website? Here is the solution. AB Simple Weather helps you to add the weather info to your website in a beautiful way!

Here is the more details:

*   Ability to set the preferred location either by entering city name or GPS coordinates for the weather to be displayed
*   Get your GPS coordinates in one click
*   Ability to add the weather info to page or post using the shortcode `[abs-weather]`
*   Add the weather info to the source code using the PHP code: `<?php if(function_exists('absWeather')) { echo absWeather(); } ?>`
*   Change the display container element (HTML) for flexibility in styling the weather in your template
*   Display a dynamic weather icon based on the current weather
*   Display city and region
*   Display country name
*   Display current weather condition
*   Display humidity information
*   Display wind information

Disclaimer: This plugin uses the [simpleWeather](http://simpleweatherjs.com) API and the weather information are subject to vary from different providers.

== Installation ==

1. Upload `"ab-simple-weather"` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Navigate to the settings menu in the Wordpress backend called `"Simple Weather"`

== Frequently asked questions ==

= How to add weather info to page or post =
 
You can use the shortcode `[abs-weather]` in page or post
 
= How to add weather info in a template =
 
You can use the template code `<?php if(function_exists('absWeather')) { echo absWeather(); } ?>`in page or post

== Screenshots ==

1. Backend settings.
2. Frontend display

== Changelog ==

= 1.0 =
* Initial release.

= 1.1 =
* Fixed a minor bug

= 1.2 =
* Fixed older PHP version compatibility

== Upgrade notice ==