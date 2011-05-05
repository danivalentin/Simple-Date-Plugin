=== Plugin Name ===
Contributors: danivalentin
Donate link: http://www.danivalentin.net
Tags: date, time, relative
Requires at least: 2.7
Tested up to: 3.0.5
Stable tag: trunk

A simple way to turn your post/comment date in its relative versions.

== Description ==

This was based on [Lester Chan's Relative Date plugin](http://lesterchan.net/wordpress/readme/wp-relativedate.html "Relative Date").
It tries to simplify things a bit. This plugin can:

* Replace the_date() in the post
* Replace get_comment_date() or comment_date() in the comments

Note that if your theme is writing the date in a different form, it won't work. You have to
replace its function call to one of the above (in the TwentyTen theme for example, replace twentyten_posted_on()
by the_date().

Also important to say that, comment replacement won't work if you are using the default wp comment renderer because
it calls get_comment_time() as well. You have to do a customized callback function to use with
wp_list_comments( array( 'callback' => 'your_customized_function_here' ) ). (ok, maybe things were not
simplified that much :/)

There is a options page (under settings in the Admin) where you can choose which dates you
want to replace (posts/comments). Posts date are by default checked.

Portuguese translation included.

== Installation ==

1. Upload `wp-simplerelativedate.php` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. If necessary, change the plugin's options in the options page under settings menu.

== Changelog ==

== Upgrade Notice ==

<?php code(); // goes in backticks ?>`