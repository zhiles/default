
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
                        <div class="footer-aside-box">
                            <?php echo get_option('wb_default_word');?>
                        </div>
                        <div class="menu-footer">
                            <?php 
                                $default = array(
                                    'depth' => 0,
                                    'container' => 'ul',
                                    'menu_class'=>'menu-footer-list',
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
                            $icp = get_option('wb_default_icp');
                            if(!empty($icp)):
                        ?>
                        <div class="footer-info">
                            <div class="footer-icp">
                                <i class="default-icon gov"></i>
                                <a href="https://beian.miit.gov.cn/" rel="nofollow" target="_blank"><?php echo $icp;?></a>
                            </div>
                        </div>
                        <?php
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
        }
        introduce('main.js','js')
    ?>
    <script src="https://at.alicdn.com/t/font_2848676_u1di4xam00e.js"></script>
