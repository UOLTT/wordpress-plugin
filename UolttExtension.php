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
    $hook = add_menu_page('User Database', 'User Database', 'administrator', 'UserMenu', 'UserList');
    add_submenu_page('UserMenu', 'User Entry', 'User Entry', 'administrator', 'AddUser', 'UserAdd' );
    add_action( "load-$hook", 'add_user_list_options' );
});

function UserList() {
    require_once UOLTT_EXTENSION_DIR.'/pages/UserList.php';
}

function add_user_list_options() {
    $option = 'per_page';

    $args = array(
        'label' => 'Users',
        'default' => 20,
        'option' => 'users_per_page'
    );

    add_screen_option( $option, $args );
}