<div class="sidebar">
    <?php
        if(is_home()) dynamic_sidebar('index_sidebar');
        if(is_single()) dynamic_sidebar('post_sidebar');
        if(is_category() || is_search()) dynamic_sidebar('category_sidebar');
        if(is_archive() && !is_category()) dynamic_sidebar('place_sidebar');
    ?>
</div>
