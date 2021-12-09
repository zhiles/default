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
                the_list_post();
            ?>
            <div class="list-pages">
                <?php get_template_part('component/list-more')?>
            </div>
        </div>
        <div class="main-right">
            <?php get_sidebar();?>
        </div>
    </main>
    <?php if(false):?>
    <div class="links">
        <div class="links-body">
            <div class="links-title">
                <div>友情链接</div>
            </div>
            <?php
            $default = array(
                'depth' => 0,
                'container' => 'ul',
                'menu_class'=>'links-list',
                'theme_location' => 'menu_link',
                'items_wrap' => '<ul class="%2$s">%3$s</ul>'
            );
            wp_nav_menu($default);
            ?>
        </div>
    </div>
    <?php endif;?>
    <?php get_footer();?>
</body>
</html>