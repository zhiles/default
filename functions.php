<?php
define('AJAX_URL', admin_url('admin-ajax.php'));
define('THEME_PATH', get_template_directory());
define('THEME_STATIC_PATH', get_template_directory_uri() . '/static');
const THEME_NAME = 'default';
const THEME_VERSION = 01;
const THEME_VERSION_NAME = '0.0.2';
const THEME_CSS_PATH = THEME_STATIC_PATH . '/css';
const THEME_JS_PATH = THEME_STATIC_PATH . '/js';
const THEME_LIB_PATH = THEME_STATIC_PATH . '/lib';
const THEME_IMG_PATH = THEME_STATIC_PATH . '/img';
const TOOLS_PATH = THEME_PATH . '/tools';
const WIDGETS_PATH = THEME_PATH . '/widgets';
require_once(TOOLS_PATH . '/utils.php');
require_once(TOOLS_PATH . '/theme.php');
require_once(TOOLS_PATH . '/core.php');

// 替换 Gravatar 头像源
function get_default_avatar($avatar) {
    $avatar = str_replace(array('www.gravatar.com','0.gravatar.com','1.gravatar.com','2.gravatar.com','secure.gravatar.com'),'cravatar.cn',$avatar);
    return $avatar;
}
add_filter('get_avatar', 'get_default_avatar');

add_filter('json_enabled', '__return_false' );
add_filter('json_jsonp_enabled', '__return_false' );
add_filter('rest_enabled', '__return_false');
add_filter('rest_jsonp_enabled', '__return_false');
//remove X-Pingback header
add_filter('pings_open', '__return_false');
// Optional. Disable xmlrpc
add_filter('xmlrpc_enabled', '__return_false');
//移除无用的head头
remove_action('wp_head', 'rest_output_link_wp_head', 10 );
remove_action('template_redirect', 'rest_output_link_header', 11, 0);
remove_action('template_redirect', 'wp_shortlink_header', 11, 0);
