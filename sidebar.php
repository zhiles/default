<div class="sidebar">
    <?php
        if(is_home()) dynamic_sidebar('index_sidebar');
        if(is_single()) dynamic_sidebar('post_sidebar');
        if(is_category() || is_search() || is_tag()) dynamic_sidebar('category_sidebar');
        if(is_month()) dynamic_sidebar('place_sidebar');
    ?>
</div>
