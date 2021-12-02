<?php
//Tag小组件
class WeChatWidget extends WP_Widget{
    function __construct(){
    //这是定义小工具信息的函数，也是类的构建函数
        parent::__construct('wechat_Widget', __('微信扫一扫信息', 'wechat'),array('description'=>__('微信扫一扫信息')));
    }
    function form($instance){
    //这是表单函数，也就是控制后台显示的
    }
    function update($new_instance,$old_instance){
    //这是更新数据函数,小工具如果有设置选项，就需要保存更新数据
    }
    function widget($args,$instance){
    //这是控制小工具前台显示的函数
        $wxImg = introduce('wx_.png','imgUrl');
        $text = '我们终会相遇相知，在那悠远的苍穹。';//file_get_contents('https://v1.hitokoto.cn?c=a&encode=text&min_length=12&max_length=22');
        $html = '<div class="sidebar-aside-box">';
        $html .= '<img style="width:100%;" src="'.$wxImg.'" alt="微信扫一扫">';
        $html .= '<div style="text-align:center">' .$text.'</div>';
        $html .= '</div>';
        echo $html;
    }
}
function WeChat_Widget(){
    register_widget('WeChatWidget');
}
//widges_init，小工具初始化的时候执行PostWidget函数
add_action('widgets_init','WeChat_Widget');
?>