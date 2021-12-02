    
    <nav>
        <div class="navbar">
            <div class="navbar-toggle">
                <svg class="icon" aria-hidden="true"><use xlink:href="#icon-2501caidan"></use></svg>
            </div>
            <div class="navbar-start">
                <a class="navbar-logo" href="<?php bloginfo('url')?>" alt="<?php bloginfo('name'); ?>">
                    <h1><?php bloginfo('name'); ?></h1>
                </a>
            </div>
            <div class="navbar-menu">
                <?php 
                    $default = array(
                        'depth' => 0,
                        'container' => 'ul',
                        'theme_location' => 'menu_top',
                        'items_wrap' => '<ul>%3$s</ul>'
                    );
                    wp_nav_menu($default);
                ?>
                <div class="navbar-end">
                    <input type="text" class="search" placeholder="搜索内容">
                    <div class="navbar-search" title="搜索"><svg class="icon" aria-hidden="true"><use xlink:href="#icon-search"></use></svg></button>
                </div>
            </div>
        </div>
    </nav>
    