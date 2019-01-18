<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

Route::get('think', function () {
    return 'hello,ThinkPHP5!';
});


//后台管理酒店路由
Route::group('api/admin/', function () {
    //公用类获取产品类型
    Route::get('/goodstype', 'api/common/getGoodsTypeByList');
    Route::post('/images', 'api/common/upload');

    // 登录类
    Route::post('/login', 'api/Login/login');
    Route::get('/info', 'api/Login/info');
    Route::post('/logout', 'api/Login/logout');

    /*
    * 账户管理模块
    */

    Route::get('/admin', 'api/admin/GetAdminByList'); /* 获取账户列表*/
    Route::post('/admin/DataStatus', 'api/admin/DataStatus'); /* 修改用户状态*/
    Route::get('/admind/DataDelete', 'api/admin/DataDelete'); /*  删除用户*/
    Route::post('/admin/PostDataadd', 'api/admin/PostDataadd'); /* 添加数据*/
    Route::post('/admin/PostDataedit', 'api/admin/PostDataEdit'); /*  修改用户信息*/

    /**
     * 产品分类模块
     */
    Route::get('/gtype/GetDataByList', 'api/gtype/GetDataByList'); /* 获取列表*/
    Route::post('/gtype/GetDataByStatus', 'api/gtype/GetDataByStatus'); /* 修改状态*/
    Route::get('/gtype/GetDataByDelete', 'api/gtype/GetDataByDelete'); /*  删除数据*/
    Route::post('/gtype/PostDataByAdd', 'api/gtype/PostDataByData'); /* 添加数据*/
    Route::post('/gtype/PostDataByUpdate', 'api/gtype/PostDataByUpdate'); /*  修改信息*/

    /**
     * 产品添加模块
     */
    Route::get('/goods/GetDataByList', 'api/goods/GetDataByList'); /* 获取列表*/
    Route::post('/goods/GetDataByStatus', 'api/goods/GetDataByStatus'); /* 修改状态*/
    Route::get('/goods/GetDataByDelete', 'api/goods/GetDataByDelete'); /*  删除数据*/
    Route::post('/goods/PostDataByAdd', 'api/goods/PostDataByData'); /* 添加数据*/
    Route::post('/goods/PostDataByUpdate', 'api/goods/PostDataByUpdate'); /*  修改信息*/
    Route::get('/goods/GetDataBydetailed', 'api/goods/GetDataBydetailed'); /*  删除数据*/

});

//用户模块路由
Route::group('api/index/', function () {
    //公用类获取产品类型
    Route::get('/goodstype', 'api/common/getGoodsTypeByList');//获取所有分类
    Route::get('notice', 'index/index/index');//发送消息
    Route::get('/GetUserByOenid', 'index/goods/GetUserByOenid'); /* 获取列表*/
    Route::post('/CheckUser', 'index/goods/CheckUser');//检测是否存在
    Route::post('/images', 'api/common/indexupload');
    Route::post('/tempupload', 'api/common/tempupload');

    Route::get('/GetToken', 'index//Wechat/GetToken');//获取token
    Route::post('/GetCode', 'index//Wechat/GetCode');//获取二维码
    Route::get('/getShopByInfo', 'index//user/getShopByInfo');//获取商铺信息
    Route::post('/postShopByInfo', 'index//user/postShopByInfo');//获取二维码




    /**
     * 产品模块
     */
    Route::get('/goods/GetDataByList', 'index/goods/GetDataByList'); /* 获取列表*/
    Route::post('/goods/GetDataByStatus', 'index/goods/GetDataByStatus'); /* 修改状态*/
    Route::get('/goods/GetDataByDelete', 'index/goods/GetDataByDelete'); /*  删除数据*/
    Route::post('/goods/PostDataByAdd', 'index/goods/PostDataByData'); /* 添加数据*/
    Route::post('/goods/PostDataByUpdate', 'index/goods/PostDataByUpdate'); /*  修改信息*/

    Route::get('/goods/GetDataBydetailed', 'index/goods/GetDataBydetailed'); /* 商品详情*/
    Route::post('/goods/PostBisGoodsByAdd', 'index/goods/PostBisGoodsByAdd'); /* 添加商品*/

    /**
     * 用户地址管理
     */
    Route::post('/user/postAddress', 'index/user/postAddress'); /* 添加地址*/
    Route::get('/user/getAddressBydetailed', 'index/user/getAddressBydetailed'); /* 获取地址详情*/
    Route::get('/user/GetDataByDelete', 'index/user/GetDataByDelete'); /*  删除数据*/
    Route::get('/user/gettAddress', 'index/user/gettAddress'); /* 获取选中地址*/
    Route::get('/user/getAddressByItems', 'index/user/getAddressByItems'); /* 获取地址列表*/
    Route::get('/user/getDefaultAddress', 'index/user/getDefaultAddress'); /* 获取地址列表*/
    Route::post('/user/setUserByData', 'index/user/setUserByData'); /* 修改用户信息*/
    Route::get('/user/getServerByUser', 'index/user/getServerByUser'); /* 修改用户信息*/

    /**
     * 订单管理
     */
    Route::get('/order/GetDataByList', 'index/order/GetDataByList'); /* 获取列表*/
    Route::post('/order/GetDataByStatus', 'index/order/GetDataByStatus'); /* 修改状态*/
    Route::get('/order/GetDataByDelete', 'index/order/GetDataByDelete'); /*  删除数据*/
    Route::post('/order/PostDataByAdd', 'index/order/PostDataByData'); /* 提交订单*/
    Route::post('/order/PostDataByUpdate', 'index/order/PostDataByUpdate'); /*  修改信息*/
    Route::get('/order/GetDataBydetailed', 'index/order/GetDataBydetailed'); /*  获取订单详情*/
    Route::post('/order/PostOrderBystate', 'index/order/PostOrderBystate'); /* 修改订单状态*/


    /**
     * 商家模块
     */
    Route::get('/shop/GetShopList', 'index/shop/GetShopList'); /* 获取列表*/
    Route::get('/shop/GetShopOrder', 'index/shop/GetShopOrder'); /* 获取列表*/


//    Route::post('/shop/PostDataByData', 'index/shop/PostDataByData'); /* 添加商品*/
//    Route::post('/shop/GetShopByGoods', 'index/shop/GetShopByGoods'); /* 获取商家自己提交的商品*/


    /**
     * 供货商模块
     */
    Route::post('/supply/PostDataByData', 'index/supply/PostDataByData'); /* 添加商品*/
    Route::get('/supply/GetShopByGoods', 'index/supply/GetShopByGoods'); /* 获取商家自己提交的商品*/
    Route::post('/supply/GetShopGoodsByStatus', 'index/supply/GetShopGoodsByStatus'); /* 修改商品状态*/
    Route::get('/supply/GetShopGoodsByDelete', 'index/supply/GetShopGoodsByDelete'); /* 删除商品*/
    Route::get('/supply/GetDataByFind', 'index/supply/GetDataByFind'); /* 获取商品详情*/
    Route::post('/supply/queryOrder', 'index/supply/queryOrder'); /* 查询订单*/
    Route::get('/supply/getMerchant', 'index/supply/getMerchant'); /* 获取供货商主页信息*/
    Route::get('/supply/getSupplyByOrder', 'index/supply/getSupplyByOrder'); /* 供货商获取订单*/



});
return [

];
