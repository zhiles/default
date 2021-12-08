<!DOCTYPE html>
<html lang="zh">
<head>
    <?php get_header();?>
</head>
<body>
    <?php get_template_part('component/nav-header')?>
    <?php 
        add_post_meta(get_the_ID(), '_views', 0, true);
        add_post_meta(get_the_ID(), '_like', 0, true);
        add_post_meta(get_the_ID(), '_navigation', '', true);
    ?>
    
    <main>
        <div class="main">
            <div class="main-left">
                <div class="view-content">
                    <!-- 内页详情 -->
                    <div class="view-content-main">
                        <h1 class="view-content-title"><?php the_title()?></h1>
                        <div class="view-info">
                            <!-- 面包屑导航 -->
                            <div class="crumbs-main">
                                <ul class="crumbs-main-ul">
                                    <li>
                                        <time datetime="<?php echo get_post_time('c', false, $post); ?>">
                                            <?php echo get_the_time('Y-m-d H:i:s'); ?>
                                        </time>
                                    </li>
                                    <?php $category = get_the_category_(get_the_ID())?>
                                    <li>in <a href="<?php echo $category['url'];?>" title="<?php echo $category['name'];?>"><?php echo $category['name'];?></a></li>
                                </ul>
                            </div>
                            <div class="view-info-right">
                                <span title="展开/关闭" class="view-switch view-switch-off">
                                    <svg class="icon" aria-hidden="true"><use xlink:href="#icon-toggleon"></use></svg>
                                </span>
                            </div>
                        </div>
                        <!-- 文章内容 -->
                        <div class="view-content-body">
                            <?php the_content();?>
                            <p itemprop="keywords" class="tags">
                                <?php the_tags('<svg class="icon" aria-hidden="true"><use xlink:href="#icon-24gl-tags4"></use></svg> ',',',''); ?>
                            </p>
                        </div>
                        <div class="view-content-footer">
                            <!-- 版权声明 -->
                            <div class="view-copyright">
                                <p>版权声明</p>
                                <p>链接：<a href="<?php the_permalink();?>" title="<?php the_title()?>"><?php the_permalink();?></a></p>
                                <p>文章部分内容来自于互联网整理而来，版权归作者所有，未经允许请勿转载。</p>
                            </div>
                            <div class="view-the-end">
                                THE END
                            </div>
                            <!-- 分享打赏 -->
                            <div class="view-container">
                                <div class="view-tools">
                                    <div class="view-tools-left">
                                        <div class="view-tools-item">
                                            <a href="javascript:" class="like"  data="<?php the_ID();?>" title="点赞">
                                                <svg class="icon" aria-hidden="true">
                                                    <use xlink:href="#icon-zanxuanzhong"></use>
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                    <?php $share = get_share_url();?>
                                    <div class="view-tools-right social-share">
                                        <div class="view-tools-item">
                                            <a title="海报分享" class="social-share-icon icon-haibao" data="<?php the_ID();?>" href="javascript:void(0)">
                                                <svg class="icon" aria-hidden="true">
                                                    <use xlink:href="#icon-haibao"></use>
                                                </svg>
                                            </a>
                                        </div>
                                        <div class="view-tools-item">
                                            <a title="QQ分享" target="_blank" rel="nofollow" href="<?php echo $share['qq']?>" class="social-share-icon icon-qq">
                                                <svg class="icon" aria-hidden="true">
                                                    <use xlink:href="#icon-qq"></use>
                                                </svg>
                                            </a>
                                        </div>
                                        <div class="view-tools-item">
                                            <a title="QQ空间分享" target="_blank" rel="nofollow" href="<?php echo $share['qzone']?>" class="social-share-icon icon-qzone">
                                                <svg class="icon" aria-hidden="true">
                                                    <use xlink:href="#icon-appqzone"></use>
                                                </svg>
                                            </a>
                                        </div>
                                        <div class="view-tools-item">
                                            <a title="微博分享" target="_blank" rel="nofollow" href="<?php echo $share['weibo']?>" class="social-share-icon icon-weibo">
                                                <svg class="icon" aria-hidden="true">
                                                    <use xlink:href="#icon-weibo"></use>
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- 上下篇幅 -->
                            <div class="view-turn">
                                <?php
                                    $prev = get_object_info(get_previous_post());
                                ?>
                                <div class="view-turn-item view-turn-prev" style="background-image:url(<?php echo $prev['thumbnail']; ?>)">
                                    <div class="view-turn-main">
                                        <div><a href="<?php echo $prev['url'];?>" title="<?php echo $prev['title'];?>"><?php echo $prev['title'];?></a></div>
                                        <div class="view-turn-link"><a href="<?php echo $prev['url'];?>" rel="nofollow"><<上一篇</a></div>
                                    </div>
                                </div>
                                <?php
                                    $next = get_object_info(get_next_post());
                                ?>
                                <div class="view-turn-item view-turn-next" style="background-image:url(<?php echo $next['thumbnail']; ?>)">
                                    <div class="view-turn-main">
                                        <div><a href="<?php echo $next['url'];?>" title="<?php echo $next['title'];?>"><?php echo $next['title'];?></a></div>
                                        <div class="view-turn-link"><a href="<?php echo $next['url'];?>" rel="nofollow">下一篇>></a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- 相关推荐 -->
                <div class="view-relevant">
                    <div class="view-relevant-title">相关内容</div>
                    <ul class="view-relevant-ul">
                        <?php get_relevant(get_the_ID())?>
                    </ul>
                </div>
            </div>
            <div class="main-right">
                <?php get_sidebar();?>
            </div>
        </div>
    </main>
    <?php get_footer();?>
</body>
</html>