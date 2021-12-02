<?php
/**
 * Template Name:追番记录
 */
?>
<!DOCTYPE html>
<html lang="zh">
<head>
    <?php get_header();?>
    <meta name="referrer" content="never">
    <style>
        
    </style>
</head>
<body>
    <?php get_template_part('component/nav-header')?>
    <main class="main">
        <div style="width:100%;height:100%;">
            <div class="list-title">
                <h3>追番记录</h3>
            </div>
            <div class="anime">
                <?php 
                    $anime =  get_anime();
                    foreach($anime->data as $item):
                ?>
                <div class="item">
                    <a href="<?php echo $item['url'];?>" title="<?php echo $item['title'];?>" target="_blank" rel="nofollow">
                        <div class="anime-body">
                            <img src="data:image/gif;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVQImWNgYGBgAAAABQABh6FO1AAAAABJRU5ErkJggg==" data-src="<?php echo $item['image'];?>" alt="<?php echo $item['title'];?>">
                            <span class="area"><?php echo $item['areas'][0]['name']?></span>
                        </div>
                        <div class="progress">
                            <div style="width:<?php echo $item['progress_bar'];?>" class="progress-bar"></div>
                        </div>
                        <h4 class="title"><?php echo $item['title'];?></h4>
                        <p><?php echo $item['progress'];?></p>
                        <p class="evaluate"><?php echo $item['evaluate'];?></p>
                    </a>
                </div>
                <?php endforeach;?>
            </div>
            <div class="list-pages">
                <button class="anime-next" data="<?php echo ($anime->pageNo+1)?>" data-max="<?php echo $anime->totalPages?>">加载更多</button>
            </div>
        </div>
    </main>
    <?php get_footer();?>
</body>
<script>
    let next = document.querySelector('.anime-next');
    next.addEventListener('click',function (){
        let pageNo = next.getAttribute('data');
        let totalPages = next.getAttribute('data-max');
        if(pageNo>totalPages){
            return;
        }
        let current = parseInt(pageNo)+1;
        next.setAttribute('data',current);
        next.innerHTML = "加载中……";
        let result = ask('/wp-admin/admin-ajax.php', { action: 'get_anime_ajax',page:pageNo});
        result.then(res => {
            res = JSON.parse(res);
            let html = document.createElement('div');
            html.className = "anime";
            let body = "";
            for(let i=0;i<res.data.length;i++){
                body += '<div class="item">';
                body += '<a href="'+res.data[i].url+'" title="'+res.data[i].title+'" target="_blank" rel="nofollow">';
                body += '<div class="anime-body">';
                body += '<img src="data:image/gif;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVQImWNgYGBgAAAABQABh6FO1AAAAABJRU5ErkJggg==" data-src="'+res.data[i].image+'" alt="'+res.data[i].title+'">';
                body += '<span class="area">'+res.data[i].areas[0].name+'</span>';
                body += '</div>';
                body += '<div class="progress">';
                body += '<div style="width:'+res.data[i].progress_bar+'" class="progress-bar"></div>';
                body += '</div>';
                body += '<h4 class="title">'+res.data[i].title+'</h4>';
                body += '<p>'+res.data[i].progress+'</p>';
                body += '<p class="evaluate">'+res.data[i].evaluate+'</p>';
                body += '</a>';
                body += '</div>';
            }
            html.innerHTML = body;
            next.parentNode.before(html);
            LazyImg();
            if(current >= totalPages){
                next.remove();
            }else{
                next.innerHTML="加载更多";
            }
        })
    })
</script>
</html>


