<div class="list-item">
    <a class="list-item-thumbnail" href="<?php the_permalink();?>" title="<?php the_title();?>">
        <img src="data:image/gif;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVQImWNgYGBgAAAABQABh6FO1AAAAABJRU5ErkJggg==" data-src="<?php echo get_thumbnail_url();?>" alt="<?php the_title();?>">
    </a>
    <div class="list-item-body">
        <h2>
            <?php
                if (is_sticky(get_the_ID())) {
                    echo '<span class="list-item-tag">置顶</span>';
                }
            ?>
            <a href="<?php the_permalink();?>" title="<?php the_title();?>"><?php the_title();?></a>
        </h2>
        <p class="list-item-content">
            <?php echo get_excerpt();?>
        </p>
        <div class="list-item-meta">
            <ul>
                <li><time datetime="<?php echo get_post_time('c', false, $post); ?>" itemprop="datePublished"><?php echo diffBetweenTimeDay(get_the_time('Y-m-d')); ?></time></li>
                <li><svg class="icon" aria-hidden="true"><use xlink:href="#icon-zanxuanzhong"></use></svg><?php get_like();?></li>
                <li><svg class="icon" aria-hidden="true"><use xlink:href="#icon-redu"></use></svg><?php get_view();?></li>
            </ul>
            <div class="list-item-meta-other">
                <?php $category = getCategory(get_the_ID())?>
                <svg class="icon" aria-hidden="true">
                    <use xlink:href="#icon-yingyong"></use>
                </svg>
                <a href="<?php echo $category['url'];?>" title="<?php echo $category['name'];?>"><?php echo $category['name'];?></a>
            </div>
        </div>
    </div>
</div>

                        