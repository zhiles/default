window.onload = function() {
    swiper();
    intoTop();
    LazyImg();
    largeSingle();
    loadMore();
}

function loadMore() {
    let more = document.querySelector('.list-load-more');
    if (!more) return;
    //设置加锁字段 防止重复点击
    let look = false;
    more.addEventListener('click', () => {
        let cat = more.getAttribute('data');
        let value = more.getAttribute('data-value');
        let max = more.getAttribute('data-max');
        if(parseInt(value) >= parseInt(max))return false;
        //若为true 则代表已经加锁,直接返回不往下执行
        if(look)return false;
        look = true;
        more.parentNode.before(loading());
        more.innerHTML = '加载中...';
        more.setAttribute('data-value', ++value);
        let result = ask('/wp-admin/admin-ajax.php', { action: 'get_the_list_post', page: value, cat: cat }, 'POST');
        result.then(res => {
            let docs = new DOMParser().parseFromString(res,'text/html').querySelectorAll('body>.list-item');
            document.querySelector('.item-load').remove();
            for (let i = 0; i < docs.length; i++) {
                //追加至列表内
                more.parentNode.before(docs[i]);
            }
            //执行图片懒加载绑定
            LazyImg();
            if (parseInt(value) == parseInt(max)) {
                more.remove();
            }else{
                more.innerHTML = '加载更多';
            }
            look = false;
        }).catch(()=>{
            look = false;
            document.querySelector('.item-load').remove();
            more.innerHTML = '加载更多';
        })
    })
}
function loading(){
    var html = document.createElement('div');
    html.classList = "list-item item-load";
    html.innerHTML = 
    '<a class="list-item-thumbnail"></a>'+
    '<div class="list-item-body">'+
    '<h2></h2>'+
    '<p class="item-loading"></p>'+
    '<p class="item-loading"></p>'+
    '</div>';
    return html;
}

/**初始化全屏加载事件 */
function largeSingle() {
    let switchBtn = document.querySelector('.view-switch');
    if (!switchBtn) return;
    let tools  =  document.querySelector('.view-tools');
    switchBtn.addEventListener('click', () => largeSwitch(switchBtn,tools));

    if(!tools)return;
    let fixedHeight = 70  + tools.clientHeight;
    let bodyHeight = document.body.clientHeight;
    let toolsHeight = tools.offsetTop;

    window.onresize = function () {
        tools.style.width = tools.parentElement.offsetWidth+"px";
        toolsHeight = tools.parentElement.offsetTop;
        bodyHeight = document.body.clientHeight;
    }
    toolsDeal(fixedHeight,bodyHeight,tools,toolsHeight);
    addEvent(window,'scroll',function (){
        toolsDeal(fixedHeight,bodyHeight,tools,toolsHeight);
    });
    //加载文章内事件
    postInfo();
    //导航点击事件
    point();
    //加载海报相关事件
    posterInit();
}

function postInfo(){
    let like = document.querySelector('.like');
    let id = like.getAttribute('data');
    let likes = window.cookie.getCookie('likes');
    if(likes != "" && likes.includes(id)){
        let svg = like.querySelector('svg');
        svg.style = 'color:var(--main);';
        return;
    }else{
        like.addEventListener('click',function(){
            if(id == "" || id ==undefined){
                return;
            }
            if(likes == "")likes = [];
            likes.push(id);
            window.cookie.setCookie('likes',likes);
            let svg = like.querySelector('svg');
            svg.style = 'color:var(--main);';
            ask('/wp-admin/admin-ajax.php', { action: 'add_like',id:id});
        });
    }
    let views = window.cookie.getCookie('views');
    if(views != "" && views.includes(id)){
        return;
    }else{
        if(views == "") views = [];
        views.push(id);
        ask('/wp-admin/admin-ajax.php', { action: 'add_view',id:id});
        window.cookie.setCookie('views',views,1);
    }
}

function point(){
    let points = document.querySelectorAll('.navigation>li>a');
    for(let i=0;i<points.length;i++){
        points[i].addEventListener('click',function(){
            let id = points[i].getAttribute('href').replace('#','');
            document.getElementById(id).scrollIntoView(true);
            event.preventDefault();
            event.stopPropagation();
            return false;
        })
    }
}
function posterInit(){
    let element = document.querySelector('.icon-haibao');
    let id = element.getAttribute('data');
    element.addEventListener('click',function () {
        if(id == "" || id ==undefined){
            return;
        }
        let body = document.body;
        let model = document.querySelector('.model');
        if(!model){
            model = document.createElement('div');
            model.classList = 'model';
            let panel = document.createElement('div');
            panel.classList = 'model-panel';
            model.appendChild(panel);
            body.appendChild(model);
        }else{
            model.style="display:flex;";
        }
        body.style="height:100%;overflow:hidden;";
        let info = document.querySelector('.model-panel');
        info.innerHTML = '加载中……';
        let result = ask('/wp-admin/admin-ajax.php', { action: 'poster_generate',id:id});
        result.then(res => {
            info.innerHTML = res;
        })
    });
}

function closeModel(){
    let model = document.querySelector('.model');
    if(!model){
        model.style="display:flex;";
    }else{
        model.style="display:none;";
        document.body.style="";
    }
}

function downloadFile(url) {
    let xmlHttpRequest = new XMLHttpRequest();
    xmlHttpRequest.open("GET", url, true);
    xmlHttpRequest.responseType = 'blob';
    xmlHttpRequest.onload=function(e) {
        //会创建一个 DOMString，其中包含一个表示参数中给出的对象的URL。这个 URL 的生命周期和创建它的窗口中的 document 绑定。这个新的URL 对象表示指定的 File 对象或 Blob 对象。
        let url = window.URL.createObjectURL(xmlHttpRequest.response);
        let a = document.createElement('a');
        a.href = url;
        a.download = new Date().getTime();
        a.click()
    }
    xmlHttpRequest.send();
};

/**内页展开全屏 */
function largeSwitch(switchBtn,tools) {
    let main = document.querySelector('.main');
    if (hasClass(main, 'large')) {
        removeClass(main, 'large');
    } else {
        addClass(main, 'large');
    }
    if (hasClass(switchBtn, 'view-switch-off')) {
        removeClass(switchBtn, 'view-switch-off');
        addClass(switchBtn, 'view-switch-on');
        let toolsWidth = document.querySelector('.main').offsetWidth;
        tools.style.width = (toolsWidth - 20) + "px";
    } else {
        removeClass(switchBtn, 'view-switch-on');
        addClass(switchBtn, 'view-switch-off');
        let toolsWidth = document.querySelector('.view-content').offsetWidth;
        tools.style.width = (toolsWidth - 42) + "px";
    }
}

function toolsDeal(fixedHeight,bodyHeight,tools,toolsHeight){
    let slide = document.body.scrollTop || document.documentElement.scrollTop;
    let toolsWidth = tools.parentElement.offsetWidth ;
    if((parseInt(slide)  + bodyHeight  - fixedHeight) > toolsHeight){
        removeClass(tools,'view-fixed');
    }else if (!hasClass(tools, 'view-fixed')) {
        addClass(tools,'view-fixed');
    }
    tools.style.width = toolsWidth + "px";
}

function intoTop() {
    let submit = document.querySelector('.navbar-search');
    let toggle = document.querySelector('.navbar-toggle');
    if(!toggle)return
    toggle.addEventListener('click',()=>openMenu(toggle));
    submit.addEventListener('click',()=>search(toggle));
    // 返回到最上面
    let top = document.querySelector(".footer-to-top");
    if(!top) return;
    addEvent(window,'scroll',function(){
        let win_scroll = document.body.scrollTop || document.documentElement.scrollTop;
        if (win_scroll > 130) {
            addClass(top, 'footer-to-top-show');
        } else {
            removeClass(top, 'footer-to-top-show');
        }
    })
    top.onclick = function() {
        scrollAnimate(0, 1000);
    }
}

/**开启关闭菜单栏 */
function openMenu(toggle) {
    let navbar = document.querySelector('.navbar');
    let use = toggle.querySelector('use');
    if (hasClass(navbar, 'is-mobile')) {
        use.setAttribute('xlink:href','#icon-2501caidan');
        removeClass(navbar, 'is-mobile');
    } else {
        use.setAttribute('xlink:href','#icon-close');
        addClass(navbar, 'is-mobile');
    }
}

function search(toggle) {
    let navbar = document.querySelector('.navbar');
    let query = document.querySelector('.search');
    if (!hasClass(navbar, 'is-mobile')) {
        openMenu(toggle);
        query.focus();
        search(toggle);
    } else if (query != null && query.value != '') {
        window.location.href = '/?s=' + query.value;
    }
}



//轮播图
function swiper() {
    if (!document.querySelector('.swiper-container')) return;
    new Swiper('.swiper-container', {
        loop: true,
        autoplay: true,
        delay: 3000,
        pagination: {
            el: '.swiper-pagination',
        },
        // 如果需要前进后退按钮
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        }
    })
}

//图片懒加载
function LazyImg() {
    // 获取所有列表元素
    var eles = document.querySelectorAll('img');
    // 监听回调
    var callback = (entries) => {
        entries.forEach(item => {
            // 出现到可视区
            if (item.intersectionRatio > 0) {
                var ele = item.target;
                var src = ele.getAttribute('data-src');
                if (src) {
                    // 预加载
                    var img = new Image();
                    img.addEventListener('load', function() {
                        ele.src = src;
                    }, false);
                    ele.src = src;
                    // 加载过清空路径，避免重复加载
                    ele.removeAttribute('data-src');
                }
            }
        })
    }
    var observer = new IntersectionObserver(callback);

    // 列表元素加入监听
    eles.forEach(item => {
        observer.observe(item);
    })
}

function scrollAnimate(target, time) {
    let frameNumber = 0; //帧编号
    let start = document.body.scrollTop || document.documentElement.scrollTop; //起点
    let distance = target - start;
    let interval = 10;
    let maxFrame = time / interval;
    clearInterval(time);
    let timer = setInterval(function() {
        frameNumber++;
        if (frameNumber == maxFrame) {
            clearInterval(timer);
        }
        document.body.scrollTop = document.documentElement.scrollTop = CubicEaseInOut(frameNumber, start, distance, maxFrame);
    }, interval);
}

function CubicEaseInOut(t, b, c, d) {
    if ((t /= d / 2) < 1) return c / 2 * t * t * t + b;
    return c / 2 * ((t -= 2) * t * t + 2) + b;
}

function classReg(className) {
    return new RegExp("(^|\\s+)" + className + "(\\s+|$)");
}

function addClass(elem, c) {
    if ('classList' in document.documentElement) {
        elem.classList.add(c);
    } else {
        if (!hasClass(elem, c)) elem.className = elem.className + ' ' + c;
    }
}

function hasClass(elem, c) {
    if ('classList' in document.documentElement) {
        return elem.classList.contains(c);
    } else {
        return classReg(c).test(elem.className);
    }
}

function removeClass(elem, c) {
    if ('classList' in document.documentElement) {
        elem.classList.remove(c);
    } else {
        elem.className = elem.className.replace(classReg(c), ' ');
    }
};

function replaceClass(elem, c, n) {
    if ('classList' in document.documentElement) {
        elem.classList.remove(c);
        addClass(elem, n);
    } else {
        elem.className = elem.className.replace(classReg(c), n);
    }
};

function toggleClass(elem, c) {
    var fn = hasClass(elem, c) ? removeClass : addClass;
    fn(elem, c);
}

function addEvent(obj,type,fn){
    if(obj.attachEvent){
        obj.attachEvent('on'+type,function(){
            fn.call(obj);
        });
    }else{
        obj.addEventListener(type,fn,false);
    }
}

const ask = (function(url, data = {}, method = 'GET') {
    return new Promise((resolve, reject) => {
        let xhr = new XMLHttpRequest();
        xhr.withCredentials = true;
        let param = [],
            params;
        for (let key in data) {
            param.push(encodeURIComponent(key) + '=' + encodeURIComponent(data[key]));
        }
        params = param.join('&');
        if (method == 'GET') {
            url = url + '?' + params;
            xhr.open(method, url);
            xhr.send()
        } else if (method == 'POST') {
            xhr.open(method, url);
            //给指定的HTTP请求头赋值
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            xhr.send(params);
        }
        xhr.onreadystatechange = () => {
            if (xhr.readyState == 4 && xhr.status == 200) {
                resolve(xhr.responseText);
            }
        }
        xhr.onerror = () => {
            reject(xhr.responseText);
        }
    })
});

;(function (window) {
    function setCookie(name, value) {
        let argv = setCookie.arguments;
        let argc = setCookie.arguments.length;
        let expires = (argc > 2) ? argv[2] : null;
        if (Object.prototype.toString.call(value) == '[object Object]') {
            value = JSON.stringify(value);
        }
        if (Object.prototype.toString.call(value) == '[object Array]') {
            value = JSON.stringify(value);
        }
        if (expires != null) {
            let LargeExpDate = new Date();
            LargeExpDate.setTime(LargeExpDate.getTime() + (expires * 1000 * 3600 * 24));
            document.cookie = name + "=" + encodeURIComponent(value) + ";expires=" + LargeExpDate.toGMTString() + ";path=/";
        } else {
            document.cookie = name + "=" + encodeURIComponent(value) + ";path=/";
        }
    }

    function getCookie(Name) {
        let search = Name + "="
        if (document.cookie.length > 0) {
            let offset = document.cookie.indexOf(search);
            if (offset != -1) {
                offset += search.length;
                let end = document.cookie.indexOf(";", offset);
                if (end == -1) end = document.cookie.length;
                return JSON.parse(decodeURIComponent(document.cookie.substring(offset, end)));
            } else {
                return '';
            }
        }
        return '';
    }

    function delCookie(name) {
        setCookie(name, '', -1);
    }

    var cookie = {
        // full names
        getCookie: getCookie,
        setCookie: setCookie,
        delCookie: delCookie
    };

    // transport
    if (typeof define === 'function' && define.amd) {
        // AMD
        define(cookie);
    } else {
        // browser global
        window.cookie = cookie;
    }
})(window);