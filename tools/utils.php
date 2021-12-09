<?php
/**
 * wordpress实用功能
 */
function introduce($name,$type){
    if ($type == 'css') {
        echo '<link rel="stylesheet" href="' . THEME_CSS_PATH . '/' . $name . '?v=' . THEME_VERSION_NAME . '">';
    } elseif ($type == 'js') {
        echo '<script src="' . THEME_JS_PATH . '/' . $name . '?v=' . THEME_VERSION_NAME . '"></script>';
    } elseif ($type == 'img'){
        echo THEME_IMG_PATH . "/" . $name;
    } elseif($type =='imgUrl'){
        return THEME_IMG_PATH . "/" . $name;
    }
}

function get_like(){
    global $post;
    $number = get_post_meta($post->ID, '_like', true);
    echo views_convert($number);
}

/**获取文章阅读量 */
function get_view()
{
    global $post;
    $number = get_post_meta($post->ID, '_views', true);
    echo views_convert($number);
}

/**获取分类数据 多个分类只取第一个 */
function get_the_category_($id): ?array
{
    $categories = get_the_category($id);
    if (count($categories) > 0) {
        $category['url'] = get_category_link($categories[0]->term_id);
        $category['name'] = $categories[0]->name;
        return $category;
    }
    return null;
}

/**获取分类相关推荐内容 */
function get_relevant($id)
{
    $obj = get_the_category($id);
    $objId = $obj[0]->term_id;
    $query = array(
        'numberposts' => 6,
        'category' => $objId,
        'orderby' => 'post_date',
        'order' => 'DESC',
    );
    $list = get_posts($query);
    foreach ($list as $item) {
        $title = get_the_title($item);
        echo '<li><a href="' . get_the_permalink($item) . '" title = "' . $title . '">' . $title . '</a></li>';
    }
}

/**获取缩略图 */
function get_thumbnail_url($post): string
{
    $thumbnail = null;
    if (has_post_thumbnail($post)) {
        $thumbnail = get_the_post_thumbnail_url($post,'thumbnail');
    } elseif(!empty($post->post_content)) {
        $preg = '/<img.*?src=[\"|\']?(.*?)[\"|\']?\s.*?>/i';
        preg_match($preg, $post->post_content, $imgArr);
        if (count($imgArr) != 0) {
            $img = pathinfo($imgArr[1]);
            $thumbnail = $img['dirname'] .'/'. $img['filename'] .'-210x140.'.$img['extension'];
        }
    }
    if ($thumbnail == null || $thumbnail == "") {
        $thumbnail = THEME_IMG_PATH . "/default.png";
    }
    return $thumbnail;
}

function get_object_info($obj): array
{
    $that['title'] = get_the_title($obj);
    $that['thumbnail'] = get_thumbnail_url($obj);
    $that['url'] = get_the_permalink($obj);
    return $that;
}

/**获取摘要显示 */
function get_excerpt(): string
{
    global $post;
    if (has_excerpt($post->ID)) {
        $excerpt = get_the_excerpt($post);
        if (strlen(preg_replace("/[\s]{2,}/", "", $excerpt)) == 0) {
            //100 为显示多少个字
            return mb_strimwidth(strip_tags(apply_filters('the_content', $post->post_content)), 0, 150, "……");
        }
    } else {
        return mb_strimwidth(strip_tags(apply_filters('the_content', $post->post_content)), 0, 150, "……");
    }
    return "";
}

function get_share_url()
{
    global $post;
    $title = urlencode(get_the_title($post->ID));
    $description = get_excerpt();
    $url = urlencode(get_the_permalink($post->ID));
    $pic = get_thumbnail_url($post);
    $result['qq'] = 'https://connect.qq.com/widget/shareqq/index.html?url=' . $url . '&title=' . $title . '&source=' . urlencode(get_bloginfo('name')) . '&desc=' . $description . '&pics='.$pic.'&summary=' . $title;
    $result['weibo'] = 'https://service.weibo.com/share/share.php?url=' . $url . '&title=' . $title . '&pic='.$pic.'&appkey=&searchPic=true';
    $result['qzone'] = 'https://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url=' . $url . '&title=' . $title  . '&desc=' .$description. '&pics='.$pic.'&summary=' . $description .'&site='.$title;
    return $result;
}

function views_convert($num)
{
    if ($num >= 100000) {
        $num = round($num / 10000) . 'W+';
    } else if ($num >= 10000) {
        $num = round($num / 10000, 1) . 'W+';
    } else if ($num >= 1000) {
        $num = round($num / 1000, 1) . 'K+';
    }

    return $num;
}