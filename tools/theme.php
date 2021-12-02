<?php
require_once(WIDGETS_PATH . '/HotPostWidget.php');
require_once(WIDGETS_PATH . '/NavigationWidget.php');
require_once(WIDGETS_PATH . '/WeChatWidget.php');
require_once(WIDGETS_PATH . '/PlaceWidget.php');
require_once(WIDGETS_PATH . '/TagWidget.php');
require_once(TOOLS_PATH . '/SnowFlake.php');

/**
 * 添加后台主题设置页面
 */
function default_add_menu(){
    add_menu_page('主题设置', '主题设置', 'administrator', 'default_setting', 'default_page_setting', '');
}

function default_page_setting(){
    require_once TOOLS_PATH . '/setting.php';
}
add_action('admin_menu', 'default_add_menu');


function save_options_theme_setting(){
    global $wpdb;
    $obj = isset($_POST['theme_default_setting'])?($_POST['theme_default_setting']):'';
    $wpdb -> update('wp_options',array('option_value'=>stripslashes($obj)),array('option_name'=>'theme_default_setting'));
    $wpdb->get_results();
    exit;
}

add_action('wp_ajax_save_options_theme_setting', 'save_options_theme_setting');
add_action('wp_ajax_nopriv_save_options_theme_setting', 'save_options_theme_setting');


//初始化小组件列表
function sidebar_init(){
    register_sidebar(array('id' => 'index_sidebar','name' => '首页边栏'));
    register_sidebar(array('id' => 'post_sidebar','name' => '文章边栏'));
    register_sidebar(array('id' => 'category_sidebar','name' => '分类边栏'));
    register_sidebar(array('id' => 'place_sidebar','name' => '归档边栏'));
}
add_action('widgets_init', 'sidebar_init');

/**
 * 数据处理保存目录
 */
function custom_wp_insert_post_data( $data , $postarr ) {
    $content = $data['post_content'];
    $matches = array();
    $li = '';
    //匹配出h2-6标题
    $rg = "/<h[2-6](.*?)>(.*?)<\/h[2-6]>/im";
    if(preg_match_all($rg, $content , $matches)) {
        // 找到匹配的结果
        foreach($matches[2] as $num => $title) {
            $h = substr($matches[0][$num], 1, 2);      //前缀，判断是h2还是h3
            $start = stripos($content, $matches[0][$num]);  //匹配每个标题字符串的起始位置
            $end = strlen($matches[0][$num]);       //匹配每个标题字符串的结束位置
            $unique = substr(md5($title.$num),6,6);
            // 文章标题添加id，便于目录导航的点击定位
            $content = substr_replace($content, '<'.$h.' id="'.$unique.'">'.$title.'</'.$h.'>',$start,$end);
            $title = preg_replace('/<.+?>/', "", $title); //将h里面的a链接或者其他标签去除，留下文字
            $li .= '<li><a class="webkit-1" href="#'.$unique.'" rel="nofollow" title="'.$title.'">'.$title.'</a></li>';
        }
    }
    if(empty($li)){
        delete_post_meta($postarr['ID'], '_navigation');
    }else{
        update_post_meta($postarr['ID'], '_navigation', $li);
    }
    $data['post_content'] = $content;
    if(empty($data['post_name'])){
        $Snow = new SnowFlake(1);
        $data['post_name'] = $Snow ->nextId();
    }
    return $data;
}

add_filter( 'wp_insert_post_data', 'custom_wp_insert_post_data', '99', 2 );



// 开启特色封面图
add_theme_support( "post-thumbnails" );
register_nav_menus( array( 'menu_top' => '头部导航', 'menu_bottom' => '底部导航','menu_link' => '友情连接'));
//add_filter( 'jpeg_quality', create_function( '', 'return 80;' ) );
// 禁用自动生成的图片尺寸
function shapeSpace_disable_image_sizes($sizes) {
    //unset($sizes['thumbnail']);    // disable thumbnail size
    unset($sizes['medium']);       // disable medium size
    unset($sizes['large']);        // disable large size
    unset($sizes['medium_large']); // disable medium-large size
    unset($sizes['1536x1536']);    // disable 2x medium-large size
    unset($sizes['2048x2048']);    // disable 2x large size
    
    return $sizes;
}
add_action('intermediate_image_sizes_advanced', 'shapeSpace_disable_image_sizes');
 
// 禁用缩放尺寸
add_filter('big_image_size_threshold', '__return_false');
 
// 禁用其他图片尺寸
function shapeSpace_disable_other_image_sizes() {
    remove_image_size('post-thumbnail'); // disable images added via set_post_thumbnail_size() 
    remove_image_size('another-size');   // disable any other added image sizes
}
add_action('init', 'shapeSpace_disable_other_image_sizes');

//附件重命名
add_filter('wp_handle_upload_prefilter', 'custom_upload_filter' );
function custom_upload_filter( $file ){
    $info = pathinfo($file['name']);
    $ext = '.' . $info['extension'];
    $filedate = md5($file['name']);
    $file['name'] = $filedate.$ext;
    return $file;
}

// 去掉链接中category分类标志
add_action( 'load-themes.php', 'no_category_base_refresh_rules');
add_action('created_category', 'no_category_base_refresh_rules');
add_action('edited_category', 'no_category_base_refresh_rules');
add_action('delete_category', 'no_category_base_refresh_rules');
function no_category_base_refresh_rules() {
    global $wp_rewrite;
    $wp_rewrite -> flush_rules();
}
 
// register_deactivation_hook(__FILE__, 'no_category_base_deactivate');
// function no_category_base_deactivate() {
// remove_filter('category_rewrite_rules', 'no_category_base_rewrite_rules');
// // We dont want to insert our custom rules again
// no_category_base_refresh_rules();
// }
 
// Remove category base
add_action('init', 'no_category_base_permastruct');
function no_category_base_permastruct() {
    global $wp_rewrite, $wp_version;
    $wp_rewrite -> extra_permastructs['category']['struct'] = '%category%';
}
 
// Add our custom category rewrite rules
add_filter('category_rewrite_rules', 'no_category_base_rewrite_rules');
function no_category_base_rewrite_rules($category_rewrite) {
    //var_dump($category_rewrite); // For Debugging
    $category_rewrite = array();
    $categories = get_categories(array('hide_empty' => false));
    foreach ($categories as $category) {
        $category_nicename = $category -> slug;
        if ($category -> parent == $category -> cat_ID)// recursive recursion
            $category -> parent = 0;
        elseif ($category -> parent != 0)
            $category_nicename = get_category_parents($category -> parent, false, '/', true) . $category_nicename;
            $category_rewrite['(' . $category_nicename . ')/(?:feed/)?(feed|rdf|rss|rss2|atom)/?$'] = 'index.php?category_name=$matches[1]&feed=$matches[2]';
            $category_rewrite['(' . $category_nicename . ')/page/?([0-9]{1,})/?$'] = 'index.php?category_name=$matches[1]&paged=$matches[2]';
            $category_rewrite['(' . $category_nicename . ')/?$'] = 'index.php?category_name=$matches[1]';
    }
    // Redirect support from Old Category Base
    global $wp_rewrite;
    $old_category_base = get_option('category_base') ? get_option('category_base') : 'category';
    $old_category_base = trim($old_category_base, '/');
    $category_rewrite[$old_category_base . '/(.*)$'] = 'index.php?category_redirect=$matches[1]';
    //var_dump($category_rewrite); // For Debugging
    return $category_rewrite;
}
 
// Add 'category_redirect' query variable
add_filter('query_vars', 'no_category_base_query_vars');
function no_category_base_query_vars($public_query_vars) {
    $public_query_vars[] = 'category_redirect';
    return $public_query_vars;
}
 
// Redirect if 'category_redirect' is set
add_filter('request', 'no_category_base_request');
function no_category_base_request($query_vars) {
    //print_r($query_vars); // For Debugging
    if (isset($query_vars['category_redirect'])) {
        $catlink = trailingslashit(get_option('home')) . user_trailingslashit($query_vars['category_redirect'], 'category');
        status_header(301);
        header("Location: $catlink");
        exit();
    }
    return $query_vars;
}

//禁用文章自动保存（方法一）
// add_action( 'admin_print_scripts', create_function( '$a', "wp_deregister_script('autosave');" ) );
//禁用文章自动保存（方法二）。注：方法一与方法二任选其一
add_action('wp_print_scripts','fanly_no_autosave');
function fanly_no_autosave(){
    wp_deregister_script('autosave');
}
//禁用文章修订版本
add_filter( 'wp_revisions_to_keep', 'fanly_wp_revisions_to_keep', 10, 2 );
function fanly_wp_revisions_to_keep( $num, $post ) { return 0;}
?>