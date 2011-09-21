=== Plugin Name ===
Contributors: dlgoodchild, paultgoodchild
Donate link: http://www.hostliketoast.com/
Tags: CSS, Twitter Bootstrap, normalize, reset, YUI
Requires at least: 3.2.0
Tested up to: 3.2.1
Stable tag: 0.1.2

Wordpress Bootstrap CSS allows you to add either reset.css (YUI2), normalize.css or twitter bootstrap.css to the
absolute beginning of your webpages.

== Description ==

Since Twitter Bootstrap was released we, at [Host Like Toast](http://www.hostliketoast.com/ "Host Like Toast: Managed Wordpress Hosting"), needed a way to consistenly add the bootstrap CSS to the very beginning of the *head* section on all web pages, regardless of the Wordpress Theme.

It's good practice to have a core, underlying CSS definition so that your website appears and acts consistently across all
browsers as far as possible.

Twitter Bootstrap does this extremely well.

We also wanted the option to alternatively include "reset.css" and "normalize.css".  These both form related roles
as bootstrap, but are lighter.

You could look at the difference between the styles as:

*	reset.css - used to *strip/remove* the differences and reduce browser inconsistencies. It is typically generic and
will not be any use alone. It is to be treated as a starting point for your styling.
*	normalize.css - aims to make built-in browser styling consistent across browsers and adds *basic* styles for modern
expectations of certain elements. E.g. H1-6 will all appear bold.
*	bootstrap.css - is a level above normalize where it adds much more styling but retains consistency across modern
browsers. It makes site and web application development much faster.

From Twitter Bootstrap:
*Bootstrap is a toolkit from Twitter designed to kickstart development of webapps and sites.
It includes base CSS and HTML for typography, forms, buttons, tables, grids, navigation, and more*

**Some References**:

Yahoo Reset CSS, YUI 2: http://developer.yahoo.com/yui/2/

Normalize CSS: http://necolas.github.com/normalize.css/

Bootstrap, from Twitter: http://twitter.github.com/bootstrap/

== Installation ==

This plugin should install as any other Wordpress.org respository plugin.

1.	Browse to Plugins -> Add Plugin
1.	Search: Wordpress Bootstrap CSS
1.	Click Install
1.	Click to Activate.

Alternatively using FTP:

1.	Download the zip file using the download link to the right.
1.	Extract the contents of the file and locate the folder called 'wordpress-bootstrap-css' containing the plugin files.
1.	Upload this whole folder to your '/wp-content/plugins/' directory
1.	From the plugins page within Wordpress locate the plugin 'Wordpress Bootstrap CSS' and click Activate

A new menu item will appear on the left-hand side called 'Host Like Toast'.  Click this menu and select
Bootstrap CSS.

Select the CSS file as desired.

== Frequently Asked Questions ==

= Can I add more than one CSS? =

No. There's absolutely no point in doing that and serves only to add a performance penalty to your page loads.

= What happens if uninstall this plugin after I design a site with it installed? =

In all likelihood your site design/layout will change. How much depends on which CSS you used and how much of
your own customizations you have done.

= Why does my site not look any different? =

There are severals reasons for this, most likely it is that you or your Wordpress Theme has defined all the styles
already in such a manner that the CSS applied with this plugin is overwritten.

CSS is hierarchical. This means that any styles defined that apply to an element that *already* has
styles applied to it will take precedence over any previous styles.

= Is Wordpress Bootstrap CSS compatible with caching plugins? =

Good question. The only caching plugin that Host Like Toast recommends, and has decent experience with, is W3
Total Cache.

This plugin will automatically flush your W3TC cache when you save changes on this plugin (assuming you have
the other plugin installed).

Otherwise, consult your caching program's documentation.

= Is the CSS "minified"? =

Yes, but only in the case of Yahoo! YUI 2, and Twitter Bootstrap CSS.

= Where is the CSS served from - my server or the source of the CSS? =

It's up to you. We provide the option for you to choose whether it's direct from the source, or served from
your server.

= What's the reason for the Host Like Toast menu? =

We're planning on releasing more plugins in the future and they'll use much of the same code base. In this way
we hope to minimize extra and unnecessary code and give your website a far superior browsing experience without
the typical performance penalty that comes with too many plugins.

Our plugin interface will be consistent and grouped together where possible so you don't have to hunt down the
settings page each time (as is the case with most plugins out there).

== Screenshots ==

1. The complete plugin window. Here you select which CSS to use, whether to hotlink it, and then save settings

== Changelog ==

= 0.1.2 =
* Removed support for automatic W3 Total Cache flushing as the author of the other plugin has altered his code. This
is temporary until we fix.

= 0.1.1 =
* bugfix for 'None' option. Update recommended.

= 0.1 =
* First public release
* Allows you to select 1 of 3 possible styles: YUI 2 Reset; normalize CSS; or Twitter Bootstrap CSS.
* YUI 2 version 2.9.0
* Normalize CSS version 2011-08-31
* Twitter Bootstrap version 1.2.0

== Upgrade Notice ==

= 0.1.2 =
* Removed support for automatic W3 Total Cache flushing as the author of the other plugin has altered his code. This
is temporary until we fix.

= 0.1.1 =
* bugfix for 'None' option. Update recommended.

= 0.1 =
* First public release