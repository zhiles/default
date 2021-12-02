<div class="view-comments">
    <div id="comments" class="view-reply-title">发表评论</div>
    <div class="view-respond">
        <form onsubmit="return false;">
            <div class="view-respond-box">
                <div class="view-respond-avatar">
                    <img src="https://cravatar.cn/avatar/?s=48&d=mm&r=g" alt="">
                </div>
                <div class="view-respond-comment-box">
                    <textarea class="view-respond-textarea" name="" rows="5" placeholder="发表你的看法……"></textarea>
                    <div class="view-respond-emoji">
                        <button class="view-respond-emoji-add">
                            <svg class="icon" aria-hidden="true">
                                <use xlink:href="#icon-xiaolian1"></use>
                            </svg>
                            添加表情
                        </button>
                    </div>
                </div>
            </div>
            <!-- 用户信息 -->
            <div class="view-respond-user-info">
                <div class="view-respond-user-author">
                    <input type="text" name="" placeholder="昵称(*)">
                </div>
                <div class="view-respond-user-email">
                    <input type="text" name="" placeholder="邮箱(*)">
                </div>
                <div class="view-respond-user-link">
                    <input type="text" name="" placeholder="网址">
                </div>
            </div>
            <div class="view-respond-submit-box">
                <div class="view-respond-cookie">
                    <input type="checkbox" name="checked" placeholder="1" checked="checked">
                    <span> 记住用户信息</span>
                </div>
                <?php
                    if(comments_open()){
                        echo '<button class="view-respond-submit" value="">发表评论</button>';
                    }else{
                        echo '<button class="view-respond-forbid">禁止评论</button>';
                    }
                ?>
            </div>
        </form>
    </div>
    <div class="view-comments-title">
        共有<?php echo get_comments_number();?>条评论
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
                    'callback' => 'comments_init',
                ));
            echo '</ul>';
        }
    ?>
    <div class="view-comments-pages">
        <?php paginate_comments_links('prev_text=«&next_text=»'); ?>
    </div>
</div>