<?php
/**
 * Template Name:时光轴
 */
?>
<!DOCTYPE html>
<html lang="zh">
<head>
    <?php get_header();?>
</head>
<style>

</style>
<body>
<?php get_template_part('component/nav-header')?>
<main class="main">
    <div style="width:100%;height:100%;">
        <div class="list-title">
            <h3>时光轴</h3>
        </div>
        <div class="time">
            <div class="time-main">
                <?php echo get_timeline();?>
            </div>
        </div>
    </div>
</main>
<?php get_footer();?>
<script>
    let next = document.querySelector('.time-next');
    if(next){
        next.addEventListener('click',function (){
            let result = ask('/wp-admin/admin-ajax.php', { action: 'get_timeline_ajax',page:next.getAttribute('data'),year:next.getAttribute('data-year'),month:next.getAttribute('data-month')});
            result.then(res=>{
                let html = new DOMParser().parseFromString(res,'text/html');
                let docs = html.querySelectorAll('h3,span');
                for (let i = 0; i < docs.length; i++) {
                    //追加至列表内
                    next.before(docs[i]);
                }
                let n = html.querySelector('.time-next');
                if(n){
                    next.setAttribute('data',n.getAttribute('data'));
                    next.setAttribute('data-year',n.getAttribute('data-year'));
                    next.setAttribute('data-month',n.getAttribute('data-month'));
                }else{
                    next.remove();
                }
            })
        })
    }
</script>
</body>
</html>
