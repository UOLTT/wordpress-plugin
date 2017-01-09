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

require_once UOLTT_EXTENSION_DIR.'/vendor/autoload.php';
require_once UOLTT_EXTENSION_DIR.'/library/functions.php';

add_action('admin_menu', function() {
    // User List page
    $hook = add_menu_page('User Database', 'User Database', 'administrator', 'UserMenu', 'UserList');
    add_action( "load-$hook", 'add_user_list_options' );

    // User Add page
    add_submenu_page('UserMenu', 'User Entry', 'User Entry', 'administrator', 'AddUser', 'UserAdd' );

    // User Edit page
    add_submenu_page(null, 'User Add', 'User Add', 'administrator', 'UserEdit', 'UserEdit');
});

function UserAdd() {
    require_once UOLTT_EXTENSION_DIR.'/pages/UserAdd.php';
}

function UserList() {
    require_once UOLTT_EXTENSION_DIR.'/pages/UserList.php';
}

function UserEdit() {
    require_once UOLTT_EXTENSION_DIR.'/pages/UserEdit.php';
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