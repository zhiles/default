<!DOCTYPE html>
<html lang="zh">
<head>
    <?php get_header();?>
</head>
<body>
    <?php get_template_part('component/nav-header')?>
    <main class="main">
        <div class="main-left">
            <div class="list-title">
                <h3><?php the_archive_title()?></h3>
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
    </main>
    <?php get_footer();?>
</body>
</html>