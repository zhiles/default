<?php
/**
 * wordpress实用功能
 */
function introduce($name,$type){
    if ($type == 'css') {
        echo '<link rel="stylesheet" href="' . THEME_CSS_PATH . '/' . $name . '?v=' . THEME_VERSIONNAME . '">';
    } elseif ($type == 'js') {
        echo '<script src="' . THEME_JS_PATH . '/' . $name . '?v=' . THEME_VERSIONNAME . '"></script>';
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
function getCategory($id)
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
function get_thumbnail_url()
{
    global $post;
    $thumbnail = null;
    if (has_post_thumbnail($post)) {
        $thumbnail = get_the_post_thumbnail_url($post,'thumbnail');
    } else {
        $preg = '/<img.*?src=[\"|\']?(.*?)[\"|\']?\s.*?>/i';
        preg_match($preg, $post->post_content, $imgArr);
        if (count($imgArr) != 0) {
            $img = pathinfo($imgArr[1]);
            $thumbnail = $img['dirname'] .'/'. $img['filename'] .'-210x140.'.$img['extension'];
        }
    }
    if ($thumbnail == null || $thumbnail == "") {
        $thumbnail = "https://ohoyo-1301859796.cos.ap-beijing.myqcloud.com/2021/11/9e19c7303b0cfc8dab5a404087c7f749.jpg!thumbnail";
    }
    return $thumbnail;
}

/**获取摘要显示 */
function get_excerpt()
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

/**时间转换 */
function diffBetweenTimeDay($time)
{
    $time_ = time() - strtotime($time);
    $date_ = round((strtotime(date('Y-m-d')) - strtotime(date('Y-m-d', strtotime($time)))) / 60 / 60 / 24);
    if ($time_ <= 3 * 60) {
        $day_ = '刚刚';
    } elseif ($time_ > 3 * 60 && $time_ <= 5 * 60) {
        $day_ = '3分钟前';
    } elseif ($time_ > 5 * 60 && $time_ <= 10 * 60) {
        $day_ = '5分钟前';
    } elseif ($time_ > 10 * 60 && $time_ <= 30 * 60) {
        $day_ = '10分钟前';
    } elseif ($time_ > 30 * 60 && $time_ <= 60 * 60) {
        $day_ = '30分钟前';
    } elseif ($time_ > 60 * 60 && $time_ <= 120 * 60) {
        $day_ = '1小时前';
    } elseif ($time_ > 120 * 60 && $date_ == 0) {
        $day_ = '今天';
    } elseif ($date_ == 1) {
        $day_ = '昨天';
    } else {
        $day_ = date('Y-m-d', strtotime($time));
    }
    return $day_;
}


function format_date($time)
{
    global $options, $post;
    $p_id = isset($post->ID) ? $post->ID : 0;
    $q_id = get_queried_object_id();
    $single = $p_id == $q_id && is_single();
    if (isset($options['time_format']) && $options['time_format'] == '0') {
        return date(get_option('date_format') . ($single ? ' ' . get_option('time_format') : ''), $time);
    }
    $t = current_time('timestamp') - $time;
    $f = array(
        '86400' => '天',
        '3600' => '小时',
        '60' => '分钟',
        '1' => '秒'
    );
    if ($t == 0) {
        return '1秒前';
    } else if ($t >= 604800 || $t < 0) {
        return date(get_option('date_format') . ($single ? ' ' . get_option('time_format') : ''), $time);
    } else {
        foreach ($f as $k => $v) {
            if (0 != $c = floor($t / (int)$k)) {
                return $c . $v . '前';
            }
        }
    }
}

function get_share_url($type, $title, $summary)
{
    global $set;
    if ($set['seo']['description'] != null) {
        $description = $set['seo']['description'];
    } else {
        $description = get_bloginfo('description');
    }
    $url = urlencode(get_bloginfo('url'));
    if ($type == 'qq') {
        return 'https://connect.qq.com/widget/shareqq/index.html?url=' . $url . '&title=' . urlencode($title) . '&source=' . urlencode(get_bloginfo('name')) . '&desc=' . urlencode($description) . '&pics=&summary=' . urlencode($summary);
    } else if ($type == 'weibo') {
        return 'https://service.weibo.com/share/share.php?url=' . $url . '&title=' . urlencode($summary) . '&pic=&appkey=&searchPic=true';
    } else if ($type = 'qzone') {
        return 'http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url=' . $url . '&title=' . urlencode($title) . '&pics=&summary=' . urlencode($summary);
    }
}

function replace_copyright($str)
{
    global $post;
    $author_name = get_the_author();
    $author_url = get_the_author_link();
    $post_url = get_permalink();
    $post_name = get_the_title();

    $str = str_replace('<#username#>', $author_name, $str);
    $str = str_replace('<#url#>', $post_url, $str);
    $str = str_replace('<#authorurl#>', $author_url, $str);
    $str = str_replace('<#postname#>', $post_name, $str);


    return $str;
}

/**
 *参数验证
 */
function parameter_verification($arr, $type = 0)
{
    $re_arry = array();
    foreach ($arr as $item) {
        if ($type == 1) {
            if (!isset($_POST[$item])) {
                $json['code'] = 0;
                $json['msg'] = '参数错误';
                wp_die(json_encode($json));
            } else {
                $re_arry[$item] = $_POST[$item];
            }
        } else {
            if (!isset($_GET[$item])) {
                $json['code'] = 0;
                $json['msg'] = '参数错误';
                wp_die(json_encode($json));
            } else {
                $re_arry[$item] = $_GET[$item];
            }
        }

    }
    return $re_arry;
}

function ajax_die($msg, $code = 0)
{
    $json['code'] = $code;
    $json['msg'] = $msg;
    wp_die(json_encode($json));
}

function is_wx_qq()
{
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    if (strpos($user_agent, 'MicroMessenger') == false && strpos($user_agent, 'QQ/') == false) {
        return false;
    } else {
        return true;
    }
}

function pinyin_long($zh)
{
    //获取整条字符串汉字拼音首字母
    $ret = "";
    $zh = preg_replace('# #', '', $zh);
    $s1 = iconv("UTF-8", "gb2312", $zh);
    $s2 = iconv("gb2312", "UTF-8", $s1);
    if ($s2 == $zh) {
        $zh = $s1;
    }
    for ($i = 0; $i < strlen($zh); $i++) {
        $s1 = substr($zh, $i, 1);
        $p = ord($s1);
        if ($p > 160) {
            $s2 = substr($zh, $i++, 2);
            $ret .= corepress_getFirstPing($s2);
        } else {
            $ret .= $s1;
        }
    }
    return $ret;
}

function replace_symbol($str)
{
    $str = str_replace('？', '', $str);
    $str = str_replace('`', '', $str);
    $str = str_replace('·', '', $str);
    $str = str_replace('~', '', $str);
    $str = str_replace('!', '', $str);
    $str = str_replace('！', '', $str);
    $str = str_replace('@', '', $str);
    $str = str_replace('#', '', $str);
    $str = str_replace('$', '', $str);
    $str = str_replace('￥', '', $str);
    $str = str_replace('%', '', $str);
    $str = str_replace('^', '', $str);
    $str = str_replace('……', '', $str);
    $str = str_replace('&', '', $str);
    $str = str_replace('*', '', $str);
    $str = str_replace('(', '', $str);
    $str = str_replace(')', '', $str);
    $str = str_replace('（', '', $str);
    $str = str_replace('）', '', $str);
    $str = str_replace('-', '', $str);
    $str = str_replace('_', '', $str);
    $str = str_replace('——', '', $str);
    $str = str_replace('+', '', $str);
    $str = str_replace('=', '', $str);
    $str = str_replace('|', '', $str);
    $str = str_replace('\\', '', $str);
    $str = str_replace('[', '', $str);
    $str = str_replace(']', '', $str);
    $str = str_replace('【', '', $str);
    $str = str_replace('】', '', $str);
    $str = str_replace('{', '', $str);
    $str = str_replace('}', '', $str);
    $str = str_replace(';', '', $str);
    $str = str_replace('；', '', $str);
    $str = str_replace(':', '', $str);
    $str = str_replace('：', '', $str);
    $str = str_replace('\'', '', $str);
    $str = str_replace('"', '', $str);
    $str = str_replace('“', '', $str);
    $str = str_replace('”', '', $str);
    $str = str_replace(',', '', $str);
    $str = str_replace('，', '', $str);
    $str = str_replace('<', '', $str);
    $str = str_replace('>', '', $str);
    $str = str_replace('《', '', $str);
    $str = str_replace('》', '', $str);
    $str = str_replace('.', '', $str);
    $str = str_replace('。', '', $str);
    $str = str_replace('/', '', $str);
    $str = str_replace('、', '', $str);
    $str = str_replace('?', '', $str);
    $str = str_replace('？', '', $str);
    return trim($str);
}

/**
 * 获取首字符拼音首字母
 * 判断是否为汉字 !preg_match('/^[\x{4e00}-\x{9fa5}]+$/u', $s0)
 * 已知 “泸”，无法识别
 */
function corepress_getFirstPing($str)
{
    $s0 = mb_substr($str, 0, 1, 'utf-8');
    $fchar = ord($s0[0]);
    if ($fchar >= ord("A") and $fchar <= ord("z")) return strtoupper($s0[0]);
    $s1 = iconv("UTF-8", "gb2312", $s0);
    $s2 = iconv("gb2312", "UTF-8", $s1);
    if ($s2 == $s0) {
        $s = $s1;
    } else {
        $s = $s0;
    }
    $asc = ord($s[0]) * 256 + ord($s[0]) - 65536;
    if ($asc >= -20319 && $asc <= -20284) return "A";
    if ($asc >= -20283 && $asc <= -19776) return "B";
    if ($asc >= -19775 && $asc <= -19219) return "C";
    if ($asc >= -19218 && $asc <= -18711) return "D";
    if ($asc >= -18710 && $asc <= -18527) return "E";
    if ($asc >= -18526 && $asc <= -18240) return "F";
    if ($asc >= -18239 && $asc <= -17923) return "G";
    if ($asc >= -17922 && $asc <= -17418) return "H";
    if ($asc >= -17922 && $asc <= -17418) return "I";
    if ($asc >= -17417 && $asc <= -16475) return "J";
    if ($asc >= -16474 && $asc <= -16213) return "K";
    if ($asc >= -16212 && $asc <= -15641) return "L";
    if ($asc >= -15640 && $asc <= -15166) return "M";
    if ($asc >= -15165 && $asc <= -14923) return "N";
    if ($asc >= -14922 && $asc <= -14915) return "O";
    if ($asc >= -14914 && $asc <= -14631) return "P";
    if ($asc >= -14630 && $asc <= -14150) return "Q";
    if ($asc >= -14149 && $asc <= -14091) return "R";
    if ($asc >= -14090 && $asc <= -13319) return "S";
    if ($asc >= -13318 && $asc <= -12839) return "T";
    if ($asc >= -12838 && $asc <= -12557) return "W";
    if ($asc >= -12556 && $asc <= -11848) return "X";
    if ($asc >= -11847 && $asc <= -11056) return "Y";
    if ($asc >= -11055 && $asc <= -10247) return "Z";
    return $s0;
}


function corepress_get_current_category_id()
{
    $current_category = single_cat_title('', false);//获得当前分类目录名称
    return get_cat_ID($current_category);//获得当前分类目录 ID
}

function corepress_replace_gravatar($url, $avatarUrl)
{
    $avatarUrl = str_replace(array("secure.gravatar.com/avatar", "www.gravatar.com/avatar", "0.gravatar.com/avatar", "1.gravatar.com/avatar", "2.gravatar.com/avatar"), $url, $avatarUrl);
    return $avatarUrl;
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

function sub_sentence_str($str)
{
    return substr($str, 1, strlen($str) - 2);
}

function msectime()
{
    list($msec, $sec) = explode(' ', microtime());
    $msectime = (float)sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000);
    return $msectime;
}

function corepress_getSubstr($str, $leftStr, $rightStr)
{
    //取文本中间
    $left = strpos($str, $leftStr);
    $right = strpos($str, $rightStr, $left);
    if ($left < 0 or $right < $left) return '';
    return substr($str, $left + strlen($leftStr), $right - $left - strlen($leftStr));
}