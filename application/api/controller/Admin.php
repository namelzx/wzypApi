<?php
/**
 * Created by PhpStorm.
 * User: jon
 * Date: 2018/12/25
 * Time: 5:46 PM
 */

namespace app\api\controller;

use app\api\model\Admin as AdminModel;


class Admin extends Base
{
    /*
   * 获取后台账户列表
   */
    public function GetAdminByList()
    {
        $data = input('param.');
        $res = AdminModel::GetByList($data);
        return json(msg(200, $res, '获取成功'),200);
    }

    /*
     * 获取后台用户信息
     */
    public function GetUserByFind()
    {
        $data = input('param.');
        $res = AdminModel::where('roles', $data['token'])->find();
        return json(msg(200, $res, '获取成功'));
    }

    /*
     * 退出登陆
     */
    public function logout()
    {
        return json('success');
    }

    /*
     *  修改用户信息
     */
    public function DataStatus()
    {
        $data = input('param.');
        $res = AdminModel::where('id', $data['id'])->data($data)->update();
        return json(msg(200, $res, '操作成功'));
    }

    /*
     * 删除用户
     */
    public function DataDelete()
    {
        $data = input('param.');
        $res = AdminModel::where('id', $data['id'])->delete();
        return json(msg(200, $res, '操作成功'));
    }

    /*
     * 提交用户
     */
    public function PostDataadd()
    {
        $data = input('param.');
        $data['create_time'] = time();
        $res = AdminModel::PostByData($data);
        return json(msg(200, $res, '操作成功'));
    }

    /*
     * 编辑用户
     */
    public function PostDataEdit()
    {
        $data = input('param.');
        $data['create_time'] = time();
        $res = AdminModel::where('id', $data['id'])->data($data)->update();
        return json(msg(200, $res, '操作成功'));
    }

}