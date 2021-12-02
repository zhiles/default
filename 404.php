<!DOCTYPE html>
<html lang="zh">
<head>
    <?php get_header();?>
</head>
<body>
    <?php get_template_part('component/nav-header')?>
    <main>
        <div class="main">
        <div class="main-left" role="main">
            <div class="in-404">
                <svg class="icon" aria-hidden="true">
                    <use xlink:href="#icon-152error40401"></use>
                </svg>
                <span>页面穿越到异次元~</span>
                <a href="/">点击前往异次元世界~</a>
            </div>
        </div>
        <div class="main-right">
            <?php get_sidebar();?>
        </div>
        </main>
    <?php get_footer();?>
</body>
</html>
