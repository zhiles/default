<!DOCTYPE html>
<html lang="zh">
<head>
    <?php get_header();?>
</head>
<body>
    <?php get_template_part('component/nav-header')?>
    <main class="main">
            <div class="universal">
                <img class="pc" src="<?php introduce('very_sorry.png','img')?>" alt="404">
                <img class="h5" src="<?php introduce('error.png','img')?>" alt="404">
                <a href="/" class="goto">
                    <svg class="icon" aria-hidden="true">
                        <use xlink:href="#icon-heidong"></use>
                    </svg>
                    <p>Σ(oﾟдﾟoﾉ) 无法找到该页面~~</p>
                </a>
<!--                <img class="pc" src="--><?php //introduce('have_rest.png','img')?><!--" alt="">-->
                <div class="have-rest">休息一下，看看推荐~</div>
                <div class="rand">
                    <?php the_rand_post();?>
                </div>
            </div>
    </main>
    <?php get_footer();?>
</body>
</html>
