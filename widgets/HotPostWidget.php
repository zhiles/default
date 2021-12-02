<?php
//文章小组件
class HotPostWidget extends WP_Widget{
    function __construct(){
    //这是定义小工具信息的函数，也是类的构建函数
        parent::__construct('post_widget', __('热门文章', 'post'));
    }
    function form($instance){
    //这是表单函数，也就是控制后台显示的
    }
    function update($new_instance,$old_instance){
    //这是更新数据函数,小工具如果有设置选项，就需要保存更新数据
    }
    function widget($args,$instance){
    //这是控制小工具前台显示的函数
        $most_views = new WP_Query(array('order' => 'DESC', 'orderby' => 'meta_value_num', 'meta_key'=>'_views','posts_per_page' => 5));
        $output = "";
        $i = 0;
        while ($most_views -> have_posts()){
            $i++;
            $most_views -> the_post();
            $title = get_the_title();
            $url = get_the_permalink();
            $category = get_the_category();
            $time = get_the_time('Y-m-d');
            $output .= '<div class="widget-item">';
            $output .= '<div><span class="widget-item-num">'.$i.'</span>';
            $output .= '<span class="widget-item-title"><a href="'.$url.'" class="webkit-1">'.$title.'</a></span></div>';
            $output .= '<div class="widget-item-meta"><div>'.$time.'</div><a href="'.get_category_link($category[0]->cat_ID).'">'.$category[0]->name.'</a></div>';
            $output .= '</div>';
        }
        $html = '<div class="sidebar-aside-box">';
        $html .= '<h2 class="widget-title">热门文章</h2>';
        $html .= $output;
        $html .= '</div>';
        echo $html;
    }
}
function Hot_Post_Widget(){
    register_widget('HotPostWidget');
}
//widges_init，小工具初始化的时候执行PostWidget函数
add_action('widgets_init','Hot_Post_Widget');
?>