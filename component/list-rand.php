<div class="item">
    <a href="<?php the_permalink();?>" title="the_title();">
        <img src="data:image/gif;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVQImWNgYGBgAAAABQABh6FO1AAAAABJRU5ErkJggg==" data-src="<?php echo get_thumbnail_url($post);?>" alt="<?php the_title();?>">
        <h3 class="title"><?php the_title();?></h3>
        <p><?php echo get_excerpt();?></p>
    </a>
</div>