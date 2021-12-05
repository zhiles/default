<?php
//归档小组件
class PlaceWidget extends WP_Widget{
    function __construct(){
    //这是定义小工具信息的函数，也是类的构建函数
        parent::__construct('place_Widget', __('归档目录', 'place'),array('description'=>__('归档目录')));
    }
    function form($instance){
    //这是表单函数，也就是控制后台显示的
    }
    function update($new_instance,$old_instance){
    //这是更新数据函数,小工具如果有设置选项，就需要保存更新数据
    }
    function widget($args,$instance){
    //这是控制小工具前台显示的函数
        $html = '<div class="sidebar-aside-box">';
        $html .= '<h2 class="widget-title">归档</h2>';
        $html .= '<ul class="widget-menu">';
        $html .= wp_get_archives(array('echo'=>false,'limit'=>6));
        $html .= '</ul>';
        $html .= '</div>';
        echo $html;
    }
}
function Place_Widget(){
    register_widget('PlaceWidget');
}
//widget_init，小工具初始化的时候执行PostWidget函数
add_action('widgets_init','Place_Widget');
?>