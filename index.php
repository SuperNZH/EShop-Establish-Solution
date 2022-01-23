<?php
    error_reporting(E_ALL & ~E_NOTICE);// 展示除了notice以外所有的reporting
    // 开启会话
    session_start();
    // 包含所有composer的组件库
    require('vendor/autoload.php');
    require('class/cattree.php');// 做分类用的


    use NoahBuscher\Macaw\Macaw;

    // 进入管理平台的首页面
    Macaw::get('/admin', "admin\Index@index");//admin的Index这个控制器的index这个方法

    // 友情链接路由
    Macaw::get('/admin/link', "admin\Link@index");// link列表
    Macaw::any('/admin/link/add', 'admin\Link@add');// 添加link
    Macaw::get('/admin/link/mod/(:num)', 'admin\Link@mod');// 获取修改Link的那个UI
    Macaw::post('/admin/link/doupdate', 'admin\Link@doupdate'); //修改操作
    Macaw::get('/admin/link/del/(:num)', 'admin\Link@del'); // 删除操作
    Macaw::post('/admin/link/order', 'admin\Link@order');// 排序


    // 管理员路由
    Macaw::get('/admin/adminuser', "admin\AdminUser@index");// link列表
    Macaw::any('/admin/adminuser/add', 'admin\AdminUser@add');// 添加link
    Macaw::get('/admin/adminuser/mod/(:num)', 'admin\AdminUser@mod');// 获取修改Link的那个UI
    Macaw::post('/admin/adminuser/doupdate', 'admin\AdminUser@doupdate'); //修改操作
    Macaw::get('/admin/adminuser/del/(:num)', 'admin\AdminUser@del'); // 删除操作


    // 管理员登录和退出操作
    Macaw::get('/admin/login', 'admin\Login@index');
    Macaw::get('/admin/login/vcode', 'admin\Login@vcode');// 登陆用验证码
    Macaw::post('/admin/login/dologin', 'admin\Login@dologin');// 登陆
    Macaw::get('/admin/login/logout', 'admin\Login@logout');// 退出

    // 广告路由
    Macaw::get('/admin/ad', "admin\Ad@index");  //列表
    Macaw::any('/admin/ad/add', 'admin\Ad@add'); //添加
    Macaw::get('/admin/ad/mod/(:num)', 'admin\Ad@mod'); //获取修改UI
    Macaw::post('/admin/ad/doupdate', 'admin\Ad@doupdate'); //修改操作
    Macaw::get('/admin/ad/del/(:num)', 'admin\Ad@del'); //删除
    Macaw::post('/admin/ad/order', 'admin\Ad@order'); //排序

    // 页面基本信息设置
    Macaw::get('/admin/setting', "admin\Setting@index");  //列表
    Macaw::post('/admin/setting/doupdate', 'admin\Setting@doupdate'); //修改操作

    // 文章分类路由 用aclass因为怕class是关键词
    Macaw::get('/admin/aclass', "admin\Aclass@index");// link列表
    Macaw::any('/admin/aclass/add', 'admin\Aclass@add');// 添加link
    Macaw::get('/admin/aclass/mod/(:num)', 'admin\Aclass@mod');// 获取修改Link的那个UI
    Macaw::post('/admin/aclass/doupdate', 'admin\Aclass@doupdate'); //修改操作
    Macaw::get('/admin/aclass/del/(:num)', 'admin\Aclass@del'); // 删除操作
    Macaw::post('/admin/aclass/order', 'admin\Aclass@order');// 排序

    // 文章路由
    Macaw::get('/admin/article', "admin\Article@index");// link列表
    Macaw::any('/admin/article/add', 'admin\Article@add');// 添加link
    Macaw::get('/admin/article/mod/(:num)', 'admin\Article@mod');// 获取修改Link的那个UI
    Macaw::post('/admin/article/doupdate', 'admin\Article@doupdate'); //修改操作
    Macaw::get('/admin/article/del/(:num)', 'admin\Article@del'); // 删除操作
    Macaw::post('/admin/article/alldel', 'admin\Article@alldel');// 批量删除
    Macaw::post('/admin/article/upload', 'admin\Article@upload');// 文件图片的上传

    // 单页处理路由
    Macaw::get('/admin/page', "admin\Page@index");// link列表
    Macaw::any('/admin/page/add', 'admin\Page@add');// 添加link
    Macaw::get('/admin/page/mod/(:num)', 'admin\Page@mod');// 获取修改Link的那个UI
    Macaw::post('/admin/page/doupdate', 'admin\Page@doupdate'); //修改操作
    Macaw::get('/admin/page/del/(:num)', 'admin\Page@del'); // 删除操作
    Macaw::post('/admin/page/order', 'admin\Page@order');// 排序

    // 商品分类路由
    Macaw::get('/admin/category', "admin\Category@index");  //列表
    Macaw::any('/admin/category/add', 'admin\Category@add'); //添加
    Macaw::get('/admin/category/mod/(:num)', 'admin\Category@mod'); //获取修改UI
    Macaw::post('/admin/category/doupdate', 'admin\Category@doupdate'); //修改操作
    Macaw::get('/admin/category/del/(:num)', 'admin\Category@del'); //删除
    Macaw::post('/admin/category/order', 'admin\Category@order'); //排序


    // 商品路由
    Macaw::get('/admin/product', "admin\Product@index");  //列表
    Macaw::any('/admin/product/add', 'admin\Product@add'); //添加
    Macaw::get('/admin/product/mod/(:num)', 'admin\Product@mod'); //获取修改UI
    Macaw::post('/admin/product/doupdate', 'admin\Product@doupdate'); //修改操作
    Macaw::get('/admin/product/del/(:num)', 'admin\Product@del'); //删除
    Macaw::post('/admin/product/alldel', 'admin\Product@alldel'); //批量删除
    Macaw::post('/admin/product/state/(:num)', 'admin\Product@state'); //批量上下架
    Macaw::post('/admin/product/tuijian/(:num)', 'admin\Product@tuijian'); //批量推荐


    // 支付方式路由
    Macaw::get('/admin/payway', "admin\Payway@index");  //列表
    Macaw::get('/admin/payway/mod/(:num)', 'admin\Payway@mod'); //获取修改UI
    Macaw::post('/admin/payway/doupdate', 'admin\Payway@doupdate'); //修改操作
    Macaw::post('/admin/payway/order', 'admin\Payway@order'); //排序

    //前台首页控制器
    Macaw::get('/', 'home\Index@index');   // 首页
    Macaw::get('/plist/(:num)', 'home\Product@plist');  // 产品列表页面
    Macaw::get('/product/(:num)', 'home\Product@index');  // 产品详情页面
    Macaw::get('/page/(:num)', 'home\Page@index');  // 单页详情页面
    Macaw::get('/alist/(:num)', 'home\Article@alist');  // 文章列表页面
    Macaw::get('/article/(:num)', 'home\Article@index');  // 文章详情页面

    // 用户注册、登录、退出
    Macaw::any("/user/register", 'home\User@register');
    Macaw::any("/user/login", 'home\User@login');
    Macaw::any("/user/logout", 'home\User@logout');

    // 用户后台操作路由
    Macaw::get('/admin/user', "admin\User@index");  //列表
    Macaw::get('/admin/user/mod/(:num)', 'admin\User@mod'); //获取修改UI
    Macaw::post('/admin/user/doupdate', 'admin\User@doupdate'); //修改操作
    Macaw::get('/admin/user/del/(:num)', 'admin\User@del'); //删除
    Macaw::post('/admin/user/alldel', 'admin\User@alldel'); //批量删除

    //添加收藏、咨询、评价
    Macaw::get('/product/collectadd', "home\Product@collectadd");  //添加收藏
    Macaw::POST('/product/commentadd', "home\Product@commentadd");  //添加评价
    Macaw::POST('/product/askadd', "home\Product@askadd");  //添加咨询

    // 咨询后台操作路由
    Macaw::get('/admin/ask', "admin\Ask@index");  //列表
    Macaw::get('/admin/ask/reply/(:num)', 'admin\Ask@reply'); //获取修改UI
    Macaw::post('/admin/ask/doreply', 'admin\Ask@doreply'); //修改操作
    Macaw::get('/admin/ask/del/(:num)', 'admin\Ask@del'); //删除
    Macaw::post('/admin/ask/alldel', 'admin\Ask@alldel'); //批量删除

    // 评价后台操作路由
    Macaw::get('/admin/comment', "admin\Comment@index");  //列表
    Macaw::get('/admin/comment/mod/(:num)', 'admin\Comment@mod'); //获取修改UI
    Macaw::post('/admin/comment/doupdate', 'admin\Comment@doupdate'); //修改操作
    Macaw::get('/admin/comment/del/(:num)', 'admin\Comment@del'); //删除
    Macaw::post('/admin/comment/alldel', 'admin\Comment@alldel'); //批量删除

    //个人中心
    Macaw::get('/user/order', 'home\User@order');   // 订单列表
    Macaw::get('/user/orderview/(:num)', 'home\User@orderview'); //订单详情
    Macaw::get('/user/orderdel/(:num)', 'home\User@orderdel'); //取消订单

    Macaw::get('/user/collect', 'home\User@collect');   // 我的收藏
    Macaw::get('/user/collectdel', 'home\User@collectdel');   // 删除我的收藏
    Macaw::get('/user/ask', 'home\User@ask');   // 我的咨询
    Macaw::get('/user/comment', 'home\User@comment');   // 我的评价

    Macaw::any('/user/base', 'home\User@base');  // 个人信息设置
    Macaw::any('/user/pw', 'home\User@pw');  // 修改密码设置

    Macaw::get('/order/cartadd', 'home\Order@cartadd');   // 添加购物车
    Macaw::get('/order/cartnum', 'home\Order@cartnum');   // 添加购物车
    Macaw::get('/order/pay/(:num)', 'home\Order@pay');   // 支付
    Macaw::any('/order/add', 'home\Order@add');   // 添加订单
    Macaw::get('/order/plist', 'home\Order@plist');   // 查询订单


    //后台卖家查询和处理定单
    Macaw::get('/admin/order', 'admin\Order@index');
    Macaw::get('/admin/order/del/(:num)', 'admin\Order@del');
    Macaw::get('/admin/order/mod/(:num)', 'admin\Order@mod');
    Macaw::post('/admin/order/doupdate', 'admin\Order@doupdate');
    Macaw::any('/admin/order/state/(:num)', 'admin\Order@state');

    Macaw::dispatch();