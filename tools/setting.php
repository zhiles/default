<div class="wrap">
    <h1>主题设置</h1>
    <?php
        add_option('theme_default_setting');
        $theme = get_option('theme_default_setting');
        $obj = json_decode($theme,true);
    ?>
    <form method="post" onsubmit="return false;" action="options.php" novalidate="novalidate">
        <table class="form-table" role="presentation">
            <tbody>
            <tr>
                <th scope="row"><label for="default_swiper">轮播图</label></th>
                <td>
                    <textarea name="default_swiper" rows="8" clos="20" id="default_swiper"  class="regular-text"><?php echo empty($obj['default_swiper'])?'':$obj['default_swiper'];?></textarea>
                    <div>格式：图片链接 || 图片Alt || 跳转链接，多个用&&分割</div>
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="default_sticky">首页置顶</label></th>
                <td><input name="default_sticky" type="text" id="default_sticky" value="<?php echo empty($obj['default_sticky'])?'':$obj['default_sticky'];?>" class="regular-text" placeholder="最多4个，用逗号分割"></td>
            </tr>
            <tr>
                <th scope="row"><label for="default_word">一句话</label></th>
                <td><input name="default_word" type="text" id="default_word" value="<?php echo empty($obj['default_word'])?'':$obj['default_word'];?>" class="regular-text" placeholder="一句话提权"></td>
            </tr>
            <tr>
                <th scope="row"><label for="default_word">备案号</label></th>
                <td><input name="default_icp" type="text" id="default_icp" value="<?php echo empty($obj['default_icp'])?'':$obj['default_icp'];?>" class="regular-text" placeholder="ICP备案号"></td>
            </tr>
            </tbody>
        </table>
        <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="保存更改"></p>
    </form>
</div>
<?php introduce('main.js','js')?>
<script>
    let default_sticky = document.querySelector('#default_sticky');
    let default_swiper = document.querySelector('#default_swiper');
    let default_word = document.querySelector('#default_word');
    let default_icp = document.querySelector('#default_icp');
    let submit = document.querySelector('#submit');
    submit.addEventListener('click',()=>{
        let arr = '{"default_sticky":"'+default_sticky.value+'","default_swiper":"'+default_swiper.value+'","default_word":"'+default_word.value+'","default_icp":"'+default_icp.value+'"}';
        let result = ask('/wp-admin/admin-ajax.php', { action: 'save_options_theme_setting', theme_default_setting:  arr}, 'POST');
        
    })
</script>