<?php
    global $wp_query;
    if (!isset($pages)) {
        $pages = null;
    }
    if (!$pages) {
        $pages = $wp_query->max_num_pages;
    }
    if($pages > 1){
        echo '<button class="list-load-more"  data-value="1" data-max="' . $pages . '"> 加载更多</button>';
    }else{
        echo '<span>没有更多~</span>';
    }
?>
