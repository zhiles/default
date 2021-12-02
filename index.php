<!DOCTYPE html>
<html lang="zh">
<head>
    <?php get_header();?>
</head>
<body>
    <?php get_template_part('component/nav-header')?>
    <?php
        $setting = get_option('theme_default_setting');
        $obj = json_decode($setting,true);
        $swiper = '';
        if(!empty($obj)){
            $swiper = $obj['default_swiper'];
            if(!empty($obj['default_sticky'])){
                $sticky = new WP_Query(array(
                    'post_type'=> array('post'),
                    'post__in'=> explode(',',$obj['default_sticky']),
                    'post_status' => array('publish'),
                    'posts_per_page'=> -1
                ));
            }
        }
    ?>
    <main class="main">
        <div class="main-left">
        <?php if(!empty($swiper)):?>
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <?php
                        $swiper = explode("&&", $swiper);
                        foreach($swiper as $swiper):
                            $arr = explode('||', $swiper);
                    ?>
                    <div class="swiper-slide">
                        <a href="<?php echo $arr[2];?>" title="<?php echo $arr[1];?>" target="_blank">
                            <img src="<?php echo $arr[0];?>" alt="<?php echo $arr[1];?>">
                        </a>
                    </div>
                    <?php endforeach;?>
                </div>
                <div class="swiper-pagination"></div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>
        <?php endif;?>
            <div class="main-topping">
                <?php
                    if(!empty($sticky)):
                    while ($sticky->have_posts()):
                    $sticky -> the_post();
                ?>
                    <div class="main-topping-item">
                        <div class="list-item-thumbnail">
                            <a href="<?php the_permalink();?>" target="_blank" title="<?php the_title();?>">
                                <img src="data:image/gif;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVQImWNgYGBgAAAABQABh6FO1AAAAABJRU5ErkJggg==" data-src="<?php echo get_thumbnail_url();?>" alt="<?php the_title();?>">
                            </a>
                        </div>
                        <div class="main-topping-item-title"><?php the_title();?></div>
                    </div>
                <?php
                    endwhile;
                    wp_reset_postdata();
                    endif;
                ?>
            </div>
            <?php
                while(have_posts()){
                    the_post();
                    get_template_part('component/list-item');
                }
            ?>
            <div class="list-pages">
                <?php get_template_part('component/list-more')?>
            </div>
        </div>
        <div class="main-right">
            <?php get_sidebar();?>
        </div>
        <?php
        if(false){
        ?>
        <div class="links">
            <div class="links-title">
                <div>友情链接</div>
                <a href="" class="links-apply">申请友链</a>
            </div>
            <ul class="links-list">
                <li><a href="">IT技术社区</a></li>
                <li><a href="">IT技术社区</a></li>
                <li><a href="">IT技术社区</a></li>
                <li><a href="">IT技术社区</a></li>
            </ul>
        </div>
        <?php
        }
        ?>
    </main>
    <?php get_footer();?>
</body>
</html>