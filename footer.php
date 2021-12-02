
    <footer>
        <div class="footer-to-top" title="返回顶部">
            <svg class="icon" aria-hidden="true">
                <use xlink:href="#icon-data_up"></use>
            </svg>
        </div>
        <div class="footer">
            <div class="footer-container">
                <div class="footer-left">
                    <div>
                        <?php
                            $setting = get_option('theme_default_setting');
                            $obj = json_decode($setting,true);
                            if(!empty($obj)):
                            $word = $obj['default_word'];
                        ?>
                        <div class="footer-aside-box">
                            <?php echo $word;?>
                        </div>
                        <?php endif;?>
                        <div class="menu-footer">
                            <?php 
                                $default = array(
                                    'depth' => 0,
                                    'container' => 'ul',
                                    'container_class' => 'menu-footer-list',
                                    'menu_class'=>'menu-footer-item',
                                    'theme_location' => 'menu_bottom',
                                    'items_wrap' => '<ul class="%2$s">%3$s</ul>'
                                );
                                wp_nav_menu($default);
                            ?>
                        </div>
                        <div class="footer-info">
                            Copyright © <?php echo date('Y');?> Ohoyo.cn,All Rights Reserved.     
                        </div>
                        <?php
                        if(!empty($obj)):
                            $icp = $obj['default_icp'];
                            if(!empty($icp)):
                        ?>
                        <div class="footer-info">
                            <div class="footer-icp">
                                <img src="<?php introduce('icp.svg','img')?>">
                                <a href="https://beian.miit.gov.cn/" rel="nofollow" target="_blank"><?php echo $icp;?></a>
                            </div>
                        </div>
                        <?php
                            endif;
                        endif;
                        ?>
                    </div>
                </div>
                <div class="footer-right">
                    <img alt="微信公众号" src="<?php introduce('wx.jpg','img')?>">
                </div>
            </div>
        </div>
    </footer>
    <?php
        if(is_home()){
            introduce('swiper.min.js', 'js');
        }elseif(is_single()){
            introduce('qrcode.min.js','js');
            introduce('share.min.js','js');
        }
        introduce('main.js','js')
    ?>

    <script src="https://at.alicdn.com/t/font_2848676_3dlsmywzgcu.js"></script>
