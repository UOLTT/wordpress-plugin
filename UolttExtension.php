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
if (!defined('UOLTT_EXTENSION_DIR')) {
    define('UOLTT_EXTENSION_DIR', plugin_dir_path(__FILE__));
}

add_action('admin_menu', function() {
    add_menu_page('User Database', 'User Database', 'administrator', 'UserList', 'UserList');
    add_submenu_page('UserMenu', 'User Entry', 'User Entry', 'administrator', 'UserMenuItems' );
});

function UserList() {
    require_once UOLTT_EXTENSION_DIR.'/pages/UserList.php';
}