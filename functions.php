<?php
define('THEME_NAME', 'default');
define('THEME_VERSION', 01);
define('THEME_VERSIONNAME', '0.0.2');
define('THEME_PATH', get_template_directory());
define('THEME_STATIC_PATH', get_template_directory_uri() . '/static');
define('THEME_CSS_PATH', THEME_STATIC_PATH . '/css');
define('THEME_JS_PATH', THEME_STATIC_PATH . '/js');
define('THEME_LIB_PATH', THEME_STATIC_PATH . '/lib');
define('THEME_IMG_PATH', THEME_STATIC_PATH . '/img');
define('TOOLS_PATH', THEME_PATH . '/tools');
define('WIDGETS_PATH', THEME_PATH . '/widgets');
define('AJAX_URL', admin_url('admin-ajax.php'));

require_once(TOOLS_PATH . '/utils.php');
require_once(TOOLS_PATH . '/theme.php');
require_once(TOOLS_PATH . '/ajax.php');


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
