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

});
return [

];
