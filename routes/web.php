<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//练习
Route::get('studen/add', 'UserController@studen');
Route::post('studen/studenadd_do', 'UserController@studenadd_do')->name('do');
Route::get('studen/lists', 'UserController@lists');
Route::get('studen/mali', 'MailController@index');
// 考试学生
Route::get('studen/save', 'StudentController@save');
Route::post('studen/save_do', 'StudentController@save_do');
Route::get('studen/index', 'StudentController@index');
Route::get('studen/del/{id}', 'StudentController@del');
Route::get('studen/up/{id}', 'StudentController@up');
Route::post('studen/up_do/{id}', 'StudentController@up_do');
// 后台
Route::prefix('admin')->middleware('checklogin')->group(function () {
    // 考试货物
    Route::get('cargoadd', 'CargoController@cargosave');
    Route::post('cargoadd_do', 'CargoController@cargosave_do');
    Route::get('catgoindex', 'CargoController@catgoindex');
    Route::get('cargoup/{id}', 'CargoController@cargoup');
    Route::post('cargoupdate/{id}', 'CargoController@cargoupdate');
    Route::get('daily', 'CargoController@daily');
    Route::get('index', 'UserController@index');
    Route::get('head', 'UserController@head')->name('head');
    Route::get('foot', 'UserController@foot')->name('foot');
    Route::get('left', 'UserController@left')->name('left');
    Route::get('main', 'UserController@main')->name('main');
    // 管理员
    Route::get('useradd', 'UserController@useradd')->name('useradd');
    Route::post('useradd_do', 'UserController@useradd_do')->name('useradd_do');
    // 商品
    Route::get('goods', 'GoodsController@goods')->name('goods');
    Route::post('admin/goods_do', 'GoodsController@goods_do')->name('goods_do');
    Route::get('goods_list', 'GoodsController@goods_list')->name('goods_list');
    Route::get('goods_edit/{gid}', 'GoodsController@goods_edit');
    Route::post('goods_update/{gid}', 'GoodsController@goods_update');
    Route::get('goods_delete', 'GoodsController@goods_delete');
    // 分类
    Route::get('category', 'CatController@category')->name('category');
    Route::post('category_do', 'CatController@category_do')->name('category_do');
    Route::get('category_list', 'CatController@category_list')->name('category_list');
    // 品牌
    Route::get('brand', 'BrandController@brand')->name('brand');
    Route::post('brand_do', 'BrandController@brand_do')->name('brand_do');
    Route::get('brand_list', 'BrandController@brand_list')->name('brand_list');
    // 网站
    Route::get('site', 'SiteController@site')->name('site');
    Route::post('site_do', 'SiteController@site_do')->name('site_do');
    Route::get('site_list', 'SiteController@site_list')->name('site_list');
    Route::get('site_del', 'SiteController@site_del');
    Route::get('site_edit/{sid}', 'SiteController@site_edit');
    Route::post('site_update/{sid}', 'SiteController@site_update');
    Route::get('only', 'SiteController@only');
    // 新闻管理
    Route::get('newindex', 'NewsController@index');
    Route::get('add', 'NewsController@add');
    Route::post('add_do', 'NewsController@add_do');
    Route::get('address/{id}', 'NewsController@address');
    Route::get('dian', 'NewsController@dian');
    Route::get('qu', 'NewsController@qu');
});
// 登陆
Route::get('login_del', 'LoginController@login_del')->name('login_del');
Route::get('login', 'LoginController@login');
Route::post('login_do', 'LoginController@login_do')->name('login_do');
// 前台
Route::get('/', 'IndexController@index');
Route::get('index/login', 'LoginController@index');
Route::post('index/login_do', 'LoginController@index_do');
Route::get('/reg', 'LoginController@reg');
Route::post('/reg_do', 'LoginController@reg_do');
Route::get('/email', 'LoginController@email');
// 商品展示
Route::get('/goods', 'GoodsController@goodslist');
// 商品详情页
Route::get('index/proinfo_index/{gid}', 'ProinfoController@proinfo_index');
// 所以商品展示
Route::get('index/prolist/{cid}', 'ProlistController@prolist');
// 购物车
Route::get('index/car_index', 'GarController@car_index');



//    微信第三方登陆
Route::get('index/code', 'LoginController@code');
Route::get('index/wechat_login', 'LoginController@wechat_login');
//    微信公众号
Route::get('index/get_user_list', 'WeixinController@get_user_list');//微信用户列表
Route::get('index/get_access_token', 'WeixinController@get_access_token');//获取access_token
Route::get('index/get_wechat_access_token', 'WeixinController@get_wechat_access_token');//
//微信内文件上传
Route::get('index/image', 'WeixinController@uplode');//微信上传图片
Route::post('index/image_do', 'WeixinController@uplode_do');//
Route::get('index/uplode_list', 'WeixinController@uplode_list');
Route::get('index/sidebar', 'WeixinController@sidebar');
Route::get('index/clear_api', 'WeixinController@clear_api');
//微信用户标签
Route::get('index/tog_list', 'TagController@tog_list');//标签列表
Route::get('index/tog_save', 'TagController@tog_save');
Route::post('index/tog_do', 'TagController@tog_do');
Route::get('index/tagdel/{id}', 'TagController@tagdel');
Route::get('index/tagup', 'TagController@tagup');
Route::post('index/tagup_do', 'TagController@tagup_do');
Route::post('index/tag_souer', 'TagController@tag_souer');
Route::get('index/user_tag', 'TagController@user_tag');
Route::get('index/tag_send', 'TagController@tag_send');//根据标签群法给用户
Route::post('index/tag_send_do', 'TagController@tag_send_do');
Route::get('index/getidlist', 'TagController@getidlist');
Route::get('index/fomwork', 'TagController@fomwork');
//文件上传
Route::get('index/uplode', 'StudentController@uplode');
Route::post('index/uplode_do', 'StudentController@uplode_do');
//微信周考
Route::get('practise/login', 'GroupController@login');
Route::get('practise/wechat_login', 'GroupController@wechat_login');
Route::get('practise/code', 'GroupController@code');
Route::prefix('practise')->middleware('practise')->group(function () {
    Route::get('user_tag', 'GroupController@user_tag');
    Route::post('send', 'GroupController@send');
});
//生成二维码
Route::get('index/qrcode_list', 'QrcodeContronller@qrcode_list');
Route::get('index/qrcode', 'QrcodeContronller@qrcode');
//生成菜单
Route::get('index/menu','MenuController@menu');
Route::get('index/menu_list','MenuController@menu_list');
Route::post('index/create_menu','MenuController@create_menu');
Route::get('index/menu_del','MenuController@menu_del');
//微信获取地理位置
Route::get('index/location','MenuController@location');//get_wechat_jsapi_ticket
//9-20的作也
Route::get('zuo/login','zuoye\CrontabController@login');
Route::post('zuo/login_do','zuoye\CrontabController@login_do');
Route::get('zuo/wechat','zuoye\CrontabController@wechat');
Route::get('zuo/code','zuoye\CrontabController@code');

Route::get('wei','WeiController@wei');



Route::get('h_do_login','hadmin\LoginController@h_do_login');
Route::get('h_login','hadmin\LoginController@h_login');
Route::get('bdzh','hadmin\LoginController@bdzh');
Route::get('send','hadmin\LoginController@send');
Route::get('do_bdzh','hadmin\LoginController@do_bdzh');
Route::get('index/index','hadmin\AdminController@index');


