<?php
/**
 * Plugin Name: Simple Relative Date
 * Plugin URI: https://github.com/danivalentin/Simple-Date-Plugin
 * Description: This plugin was based in Lester Chan's wp_relativedate
 * (http://lesterchan.net/wordpress/readme/wp-relativedate.html). It tries
 * to simplify things a little bit. It will replace the_date() in the post or
 * get_comment_date() in the comments with n (years|months|weeks|days|hours|minutes|seconds) ago.
 * There is an admin in which you select which (post and/or comments dates) you
 * want to replace. By default, only posts' dates are enabled. For php 5.2+.
 * 
 * Version: 1.0
 * Author: Dani Valentin <hello@danivalentin.net>
 * Author URI: http://danivalentin.net
 * License: GPL2
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License, version 2, as
 *   published by the Free Software Foundation.
 *
 *   This program is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *   GNU General Public License for more details.
 *
 *   You should have received a copy of the GNU General Public License
 *   along with this program; if not, write to the Free Software
 *   Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 *
 **/

//include options page
include_once(dirname(__FILE__) . '/options.php');

class SimpleRelativeDate
{
    /**
     * Replace the_date() in a post for a relative date. This is enabled by
     * default in the plugin.
     * 
     * @return string
     */
    public static function replacePostDate()
    {
        //get date and time of the post
        $theDate = get_the_date('Y-m-d');
        $theTime = get_the_time('H:i:sP');

        $date = new DateTime($theDate . ' ' . $theTime);

        return self::replaceTheDate($date);
    }

    /**
     * Replace get_comment_date() or comment_date() for a relative date. This has
     * to be enabled in the admin menu.
     * 
     * @global Comment $comment
     * @return string
     */
    public static function replaceCommentDate()
    {
        global $comment;
        
	$date = new DateTime($comment->comment_date);

        return self::replaceTheDate($date);
    }
    
    /**
     * Replace the_date() with the new relative date.
     *
     * @param DateTime $date
     * @return string
     */
    public static function replaceTheDate($date)
    {
        //load translation files
        $plugin_dir = basename(dirname(__FILE__));
        load_plugin_textdomain( 'wp-simplerelativedate', null, $plugin_dir );

        //get current datetime
        $current = new DateTime();

        //get difference between posted date and current date
        $diff = $current->format('U') - $date->format('U');

        /*
         * check if difference between dates are less than one day. If true,
         * return date in hours/minutes/seconds
         */
        if ($diff < 60*60*24) {
            return self::getTimeAgo($diff);
        }

        //return date in days/weeks/months/year
        return self::getDateAgo($diff/(60*60*24));
    }

    /**
     * Return the formatted date when > 1 day.
     *
     * @param integer $daysDiff
     * @return string
     */
    private static function getDateAgo($daysDiff)
    {
        if ($daysDiff < 7) {
            return floor($daysDiff) . _n(' day ago', ' days ago', floor($daysDiff), 'wp-simplerelativedate');
        }
            
        if ($daysDiff < 31) {
            return floor($daysDiff/7) . _n(' week ago', ' weeks ago', floor($daysDiff/7), 'wp-simplerelativedate');
        }
        
        if ($daysDiff < 365) {
            return floor($daysDiff/31) . _n(' month ago', ' months ago', floor($daysDiff/31), 'wp-simplerelativedate');
        }

        return floor($daysDiff/365) . _n(' year ago', ' years ago', floor($daysDiff/365), 'wp-simplerelativedate');
    }

    /**
     * Return the formatted date when < 1 day.
     *
     * @param integer $diff
     * @return string
     */
    private static function getTimeAgo($diff)
    {
        if ($diff < 60) {
            return floor($diff) . _n(' second ago', ' seconds ago', floor($diff), 'wp-simplerelativedate');
        }
        
        if ($diff < 3600) {
            return floor($diff/60) . _n(' minute ago', ' minutes ago', floor($diff/60), 'wp-simplerelativedate');
        }

        return  floor($diff/3600) . _n(' hour ago', ' hours ago', floor($diff/3600), 'wp-simplerelativedate');
    }
}

if (get_option('replace_post_date', 'on') === 'on') {
    add_filter('the_date', array('SimpleRelativeDate', 'replacePostDate'));
}

if (get_option('replace_comment_date', 'off') === 'on') {
    add_filter('get_comment_date', array('SimpleRelativeDate', 'replaceCommentDate'));
    add_filter('comment_date', array('SimpleRelativeDate', 'replaceCommentDate'));
}