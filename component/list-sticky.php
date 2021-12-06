<div class="main-topping-item">
    <div class="list-item-thumbnail">
        <a href="<?php the_permalink();?>" target="_blank" title="<?php the_title();?>">
            <img src="data:image/gif;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVQImWNgYGBgAAAABQABh6FO1AAAAABJRU5ErkJggg==" data-src="<?php echo get_thumbnail_url($post);?>" alt="<?php the_title();?>">
        </a>
    </div>
    <div class="main-topping-item-title"><?php the_title();?></div>
</div>