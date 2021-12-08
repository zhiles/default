<!DOCTYPE html>
<html lang="zh">
<head>
    <?php get_header();?>
</head>
<body>
    <?php get_template_part('component/nav-header')?>
    <main class="main">
        <div class="main-left">
        <?php
            $swiper = get_option('wb_default_swiper');
            if(!empty($swiper)):
        ?>
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <?php
                        $swiper = explode("\r\n", $swiper);
                        foreach($swiper as $swiper):
                            $arr = explode('||', $swiper);
                    ?>
                    <div class="swiper-slide">
                        <a href="<?php echo $arr[2];?>" title="<?php echo $arr[1];?>" rel="nofollow" target="_blank">
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
                <?php the_list_sticky_post(); ?>
            </div>
            <?php
//                while(have_posts()){
//                    the_post();
//                    get_template_part('component/list-item');
//                }
                the_list_post();
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