<?php
//Tag小组件
class TagWidget extends WP_Widget{
    function __construct(){
    //这是定义小工具信息的函数，也是类的构建函数
        parent::__construct('tag_Widget', __('标签目录', 'navigation'));
    }
    function form($instance){
    //这是表单函数，也就是控制后台显示的
    }
    function update($new_instance,$old_instance){
    //这是更新数据函数,小工具如果有设置选项，就需要保存更新数据
    }
    function widget($args,$instance){
    //这是控制小工具前台显示的函数
      $tags = get_tags();
      $li = '';
      foreach($tags as $tag){
          $tag_link = get_tag_link($tag->term_id); 
          $li .= '<li><a href="'.$tag_link.'" title="'.$tag ->name.'">'.$tag ->name.'</a></li>';
      }
      $html = '<div class="sidebar-aside-box">';
      $html .= '<h2 class="widget-title">标签</h2>';
      $html .= '<ul class="widget-tags">';
      $html .= $li;
      $html .= '</ul>';
      $html .= '</div>';
      echo $html;
    }
}
function Tag_Widget(){
    register_widget('TagWidget');
}
//widget_init，小工具初始化的时候执行PostWidget函数
add_action('widgets_init','Tag_Widget');
?>