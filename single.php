<?php
    if(in_category(array('wiki'))){
        get_template_part('single-wiki');
    }else{
        get_template_part('single-default');
    }
?>