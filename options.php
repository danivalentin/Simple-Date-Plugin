<?php
/**
 * Plugin Name: Simple Relative Date
 * Plugin URI: https://github.com/danivalentin/Simple-Date-Plugin
 * Description: Admin Panel. Options to replace post date and comment date.
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
add_action('admin_menu', 'addOptionsMenu');

/**
 * Add menu item to Settings.
 */
function addOptionsMenu()
{
    //add options page
    add_options_page('Simple Relative Date Options', 'Simple Relative Date', 8, basename(__FILE__), 'addOptionsPage');

    //register options
    add_action( 'admin_init', 'registerSettings' );
}

/**
 * Register available options
 */
function registerSettings()
{
    register_setting( 'simple-relativedate', 'replace_post_date' );
    register_setting( 'simple-relativedate', 'replace_comment_date' );
}

/**
 * Generate options page.
 */
function addOptionsPage()
{
    if (!current_user_can('manage_options'))  {
            wp_die( __('You do not have sufficient permissions to access this page.') );
    }
?>
    <div class="wrap">
        <h2>Select where you want the date to be replaced:</h2>
        <form method="post" action="options.php">
            <?php
                settings_fields('simple-relativedate');
            ?>
            <p>
                <label>Replace date in posts:</label>
                <input type="checkbox" name="replace_post_date" 
                    <?php if (get_option('replace_post_date', 'on') === 'on') { ?>
                        checked="checked"
                    <?php } ?>
                />
            </p>
            <p>
                <label>Replace date in comments:</label>
                <input type="checkbox" name="replace_comment_date"
                <?php if (get_option('replace_comment_date', 'off') === 'on') { ?>
                    checked="checked"
                <?php } ?>
            </p>
            <p>
                <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
            </p>
        </form>
    </div>
<?php
}