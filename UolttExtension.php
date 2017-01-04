<?php
/*
Plugin Name: UOLTT Extension
Plugin URI: https://uoltt.org/
Description: Does SC database management stuff
Author: judahnator
Author URI: https://servercanyon.com/
 */

if (!defined('ABSPATH')) {
    exit;
}

add_action('admin_menu', function() {
    add_menu_page('User Database', 'User Database', 'administrator', 'UserMenu');
    add_submenu_page('UserMenu', 'User Entry', 'User Entry', 'administrator', 'UserMenuItems' );
});
