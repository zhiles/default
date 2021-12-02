
<meta charset="UTF-8">
<meta name="viewport"content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<meta name="Referrer" content="origin"/>
<?php
    $title = get_bloginfo('name');
    $description = get_bloginfo('description');
    $keywords = "Ohoyo,热门动漫,最新番剧";
    if(is_home()){
        $title = $description .' - '.$title;
    }elseif(is_single()){
        $title = get_the_title() . ' - ' . $title;
        $description = str_ireplace(' [&hellip;]','…', get_the_excerpt());
    }elseif(is_category()){
        $title = single_cat_title('', false) . ' - ' . $title;
        $description = category_description();
    }elseif(is_tag()){
        $title = single_tag_title('', false) . ' - ' . $title;
        $description = tag_description();
    }elseif(is_archive()){
        $title = strip_tags(get_the_archive_title()).' - ' . $title;
        $description = strip_tags(get_the_archive_title()) .',热门动漫,最新动漫,最新追番记录';
    }elseif(is_page('about')){
        $title = '关于我们' . ' - ' . $title;
    }elseif(is_page('anime')){
        $title = '追番记录' . ' - ' . $title;
    }

    
?>
<title><?php echo $title?></title>
<meta name="keywords" content="<?php echo $keywords; ?>"/>
<meta name="description" content="<?php echo $description; ?>"/>
<link rel="shortcut icon" type="image/x-icon" href="<?php introduce('favicon.ico','img')?>" />
<?php
    introduce('main.css','css');
    if(is_home()){
        introduce('swiper.min.css', 'css');
    }
?>
