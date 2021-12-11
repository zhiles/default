<div class="view-comments">
    <div class="view-comments-title">评论(<?php echo get_comments_number();?>)</div>
    <div class="view-respond">
        <a class="view-comments-item-cancel" href="javascript:void(0)">取消</a>
        <form class="form" onsubmit="return false;">
            <div class="view-respond-comment">
                <textarea class="view-respond-textarea" name="comment" rows="5" placeholder="发表你的看法……"></textarea>
                <div class="view-respond-submit-box">
                    <?php if(comments_open()){ ?>
                        <button class="view-respond-submit" type="submit" data="<?php the_ID()?>">
                            <svg class="icon" aria-hidden="true">
                                <use xlink:href="#icon-data_up"></use>
                            </svg>
                        </button>
                    <?php }else{?>
                        <button class="view-respond-forbid" type="submit">
                            <svg class="icon" aria-hidden="true">
                                <use xlink:href="#icon-data_up"></use>
                            </svg>
                        </button>
                    <?php } ?>
                </div>
            </div>
            <div class="view-respond-bottom">
                <button class="view-respond-emoji">
                    <svg class="icon" aria-hidden="true">
                        <use xlink:href="#icon-xiaolian"></use>
                    </svg>
                </button>
                <!-- 用户信息 -->
                <div class="view-respond-user-author">
                    <input type="text" name="author" placeholder="名称(*)">
                </div>
                <div class="view-respond-user-email">
                    <input type="text" name="email" placeholder="邮箱(*)">
                </div>
                <div class="view-respond-user-link">
                    <input type="text" name="url" placeholder="http(s)://">
                </div>
            </div>
        </form>
    </div>
    <?php
        //没有评论时显示
        if(get_comments_number() == 0){
            echo '<div class="view-comments-blank"><svg class="icon" aria-hidden="true"><use xlink:href="#icon-couch"></use></svg> 沙发空余</div>';
        }else{
            echo '<ul class="view-comments-ul">';
                wp_list_comments(array(
                    'style' => 'ul',
                    'short_ping' => true,
                    'avatar_size' => 48,
                    'type' => 'comment',
                    'per_page'=> get_option('comments_per_page'),
                    'callback' => 'comments_init',
                ));
            echo '</ul>';
        }
    ?>
    <div class="view-comments-next"  data-order="<?php echo get_option('default_comments_page')?>" data="<?php echo $cpage = get_query_var('cpage') ? get_query_var('cpage') : 1;?>" data-max="<?php echo '';?>"></div>
</div>