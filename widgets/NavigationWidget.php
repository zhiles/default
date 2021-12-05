<?php
//文章目录小组件
class NavigationWidget extends WP_Widget{
    function __construct(){
    //这是定义小工具信息的函数，也是类的构建函数
        parent::__construct('navigation_Widget', __('文章目录', 'navigation'));
    }
    function form($instance){
    //这是表单函数，也就是控制后台显示的
    }
    function update($new_instance,$old_instance){
    //这是更新数据函数,小工具如果有设置选项，就需要保存更新数据
    }
    function widget($args,$instance){
    //这是控制小工具前台显示的函数
        global $wp_query;
        $li = get_post_meta($wp_query->post->ID, '_navigation', true);
        if(empty($li)) return;
        $html = '<div class="sidebar-aside-box">';
        $html .= '<h2 class="widget-title">目录</h2>';
        $html .= '<ul class="widget-menu navigation">';
        $html .= $li;
        $html .= '</ul>';
        $html .= '</div>';
        echo $html;
    }
}
function Navigation_Widget(){
    register_widget('NavigationWidget');
}
//widget_init，小工具初始化的时候执行PostWidget函数
add_action('widgets_init','Navigation_Widget');
?>