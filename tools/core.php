<?php

function add_view(){
    $post_ID = isset($_GET['id']) ? $_GET['id'] : '0';
    if($post_ID === '0') return;
    $post_views = (int)get_post_meta($post_ID, '_views', true);
    $number = $post_views + 1;
    update_post_meta($post_ID, '_views', $number);
    exit;
}

add_action('wp_ajax_add_view', 'add_view');
add_action('wp_ajax_nopriv_add_view', 'add_view');

function add_like(){
    $post_ID = isset($_GET['id']) ? $_GET['id'] : '0';
    if($post_ID === '0') return;
    $post_views = (int)get_post_meta($post_ID, '_like', true);
    $number = $post_views + 1;
    update_post_meta($post_ID, '_like', $number);
    exit;
}

add_action('wp_ajax_add_like', 'add_like');
add_action('wp_ajax_nopriv_add_like', 'add_like');

function the_rand_post(){
    global $wp_posts;
    $wp_posts = new WP_Query(array(
        'showposts' => 8,
        'orderby'=>'rand',
        'post_type' => 'post',
        'post_status' => array('publish'),
        'post__not_in' => get_option('sticky_posts'),
        'ignore_sticky_posts' => 0
    ));
    if ($wp_posts->have_posts()) {
        while ($wp_posts->have_posts()) {
            $wp_posts->the_post();
            get_template_part('component/list-rand');
        }
        wp_reset_postdata();
    }
}

function the_list_sticky_post(){
    global $wp_posts;
    $sticky = get_option('sticky_posts');
    if(count($sticky)<4)return;
    $wp_posts = new WP_Query(array(
        'posts_per_page' => 4,
        'post_type' => 'post',
        'post_status' => array('publish'),
        'post__in'=> $sticky,
        'ignore_sticky_posts' => 0
    ));
    if ($wp_posts->have_posts()) {
        while ($wp_posts->have_posts()) {
            $wp_posts->the_post();
            get_template_part('component/list-sticky');
        }
        wp_reset_postdata();
    }
}
function the_list_post(){
    global $wp_posts;
    $cat = $_POST['cat'] ??'0';
    $page = $_POST['page']??1;
    $wp_posts = new WP_Query(array(
        'posts_per_page' => get_option('posts_per_page'),
        'paged' => $page,
        'post_type' => 'post',
        'cat' => $cat,
        'post_status' => array('publish'),
        'ignore_sticky_posts' => 1
    ));
    if ($wp_posts->have_posts()) {
        while ($wp_posts->have_posts()) {
            $wp_posts->the_post();
            get_template_part('component/list-item');
        }
        wp_reset_postdata();
    }
}
function get_the_list_post(){
    the_list_post();
    exit;
}

add_action('wp_ajax_get_the_list_post', 'get_the_list_post');
add_action('wp_ajax_nopriv_get_the_list_post', 'get_the_list_post');

function poster_generate(){
    $id = $_GET['id'] ?? 1;
    $post = get_content($id);
    echo poster_main($post['title'],$post['text']);
    exit;
}

add_action('wp_ajax_poster_generate', 'poster_generate');
add_action('wp_ajax_nopriv_poster_generate', 'poster_generate');

function poster_main($title,$text){
    $img_top = 'http://poster.ohoyo.cn/poster/1.png';
    $img_bottom = 'http://poster.ohoyo.cn/poster/2.png';
    $length = 40;
    $count = ceil((strlen($text)+mb_strlen($text, 'UTF-8'))/2/$length);
    $height = 1250 + $count * 70;
    $background = 'http://poster.ohoyo.cn/poster/baidi.png?imageMogr2/thumbnail/1125x'.$height.'!|';
    $url = $background.'watermark/3/image/'. base64_urlSafeEncode($img_top) .'/gravity/North/dy/0/dx/0';
    $url .= '/image/' .base64_urlSafeEncode('http://poster.ohoyo.cn/logo.png') . '/gravity/NorthWest/dx/20/dy/150/ws/0.3';
    for ($i=0; $i < $count; $i++) {
        $url .= '/text/'.  base64_urlSafeEncode(mb_strimwidth($text,$i*$length/2,$length)) . '/gravity/NorthWest/fontsize/1000/dx/65/dy/'.(480+$i*70);
    }
    $url .='/image/'. base64_urlSafeEncode($img_bottom) .'/gravity/South/dy/0/dx/0';
    $url .= '/text/'.  base64_urlSafeEncode('摘录于文章') . '/gravity/SouthWest/fontsize/800/fill/'.base64_urlSafeEncode('#545454').'/dx/65/dy/600';
    $url .= '/text/'.  base64_urlSafeEncode('——《'.$title.'》') . '/gravity/SouthWest/fontsize/800/fill/'.base64_urlSafeEncode('#545454').'/dx/165/dy/530';
    $html  = '<img src='.$url.'/>';
    $html .= '<div class="download">';
    $html .= '<a href="javascript:downloadFile(\''.$url.'\')">海报下载</a>';
    $html .= '<a href="javascript:closeModel()">取消下载</a>';
    $html .= '</div>';
    return $html;
}

function get_content($id){
    $wp_posts = new WP_Query(array(
        'post_type' => 'post',
        'p' => $id,
        'post_status' => array('publish'),
        'ignore_sticky_posts' => 0
    ));
    if($wp_posts->have_posts()){
        $wp_posts->the_post();
        $post['text'] = mb_strimwidth(str_replace(array("\r\n", "\r", "\n"," "), '',trim(strip_tags(get_the_content()))), 0, 197, "…");
        $post['title'] = trim(get_the_title());
        return $post;
    }
    return "出了点小问题…";
}

function base64_urlSafeEncode($data)
{
    $find = array('+', '/');
    $replace = array('-', '_');
    return str_replace($find, $replace, base64_encode($data));
}

function base64_urlSafeDecode($str)
{
    $find = array('-', '_');
    $replace = array('+', '/');
    return base64_decode(str_replace($find, $replace, $str));
}

function get_anime(){
    $pageSize = $_GET["pageSize"]??8;
    $page = $_GET["page"]??1;
    $UID = '14606184';
    $COOKIE = 'SESSDATA=db76f8fb%2C1653531358%2Ccefda%2Ab1';
    require_once(TOOLS_PATH . '/Anime.php');
    $anime = new anime($UID,$COOKIE,$page,$pageSize);
    return $anime;
}

function get_anime_ajax(){
    echo json_encode(get_anime(),true);
    exit;
}

add_action('wp_ajax_get_anime_ajax', 'get_anime_ajax');
add_action('wp_ajax_nopriv_get_anime_ajax', 'get_anime_ajax');
?>