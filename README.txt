=== BugSnatcher ===
Contributors: kaiserwerk
Donate link: https://kaiserrobin.eu
Tags: error, exception, bug, error-handling, logs, logging, notification
Requires at least: 3.0
Tested up to: 4.9
Stable tag: 1.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This handy plugin will catch occurring errors and exceptions, logs them, and sends out (optional) notifications
via Email, Slack, Stride and HipChat.

== Description ==

This is the long description.  No limit, and you can use Markdown (as well as in the following sections).

For backwards compatibility, if this section is missing, the full length of the short description will be used, and
Markdown parsed.

A few notes about the sections above:

*   "Contributors" is a comma separated list of wp.org/wp-plugins.org usernames
*   "Tags" is a comma separated list of tags that apply to the plugin
*   "Requires at least" is the lowest version that the plugin will work on
*   "Tested up to" is the highest version that you've *successfully used to test the plugin*. Note that it might work on
higher versions... this is just the highest one you've verified.
*   Stable tag should indicate the Subversion "tag" of the latest stable version, or "trunk," if you use `/trunk/` for
stable.

    Note that the `readme.txt` of the stable tag is the one that is considered the defining one for the plugin, so
if the `/trunk/readme.txt` file says that the stable tag is `4.3`, then it is `/tags/4.3/readme.txt` that'll be used
for displaying information about the plugin.  In this situation, the only thing considered from the trunk `readme.txt`
is the stable tag pointer.  Thus, if you develop in trunk, you can update the trunk `readme.txt` to reflect changes in
your in-development version, without having that information incorrectly disclosed about the current stable version
that lacks those changes -- as long as the trunk's `readme.txt` points to the correct stable tag.

    If no stable tag is provided, it is assumed that trunk is stable, but you should specify "trunk" if that's where
you put the stable version, in order to eliminate any doubt.

== Installation ==

Install it from the wordpress.org plugin repository in order to profit from automatic updates.

*OR*

1. Upload the `bugsnatcher` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Change settings according to your needs.

== Frequently Asked Questions ==

= Why would I use this plugin? =

If you administer multiple Wordpress sites like me, you know well that it it delightful to know when errors occur
since you are not checking the sites constantly. HTTP errors aside, quickly knowing at all that an error occured helps
you fixing it before your client even notices it occured in the first place.

= Why YOUR plugin specifically? =

It is held simple, has a lot of notification options and no over-the-top eye candy; in one word: streamlined.

== Screenshots ==

The BugSnatcher discretely works in the background. Screenshots would not really be helpful now, would they?

== Changelog ==

= 1.0 =
* A change since the previous version.
* Another change.

= 0.5 =
* List versions from most recent at top to oldest at bottom.

== Upgrade Notice ==

= 1.0 =
Upgrade notices describe the reason a user should upgrade.  No more than 300 characters.

= 0.5 =
This version fixes a security related bug.  Upgrade immediately.

== Upcoming features ==

* Logging errors and exceptions to database