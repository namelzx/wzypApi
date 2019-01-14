<?php
/**
 * Created by PhpStorm.
 * User: jon
 * Date: 2018/12/25
 * Time: 4:20 PM
 */

namespace app\api\controller;

use app\api\model\Admin;

class Login extends Base
{
    public function login()
    {
        $data = input('param.');
        if ($this->request->isPost()) {
            $userModel = new Admin();
            $hasUser = $userModel->where('username', $data['username'])->find();

            if (empty($hasUser)) {
                return json(logomsg(500, '', '', '管理员不存在'));
            }
            if ($data['password'] != $hasUser['password']) {
                return json(logomsg(500, '', '', '密码错误'));
            }
            if (1 != $hasUser['status']) {
                return json(logomsg(500, '', '', '该账号被禁用'));
            }
            return json(logomsg(200, 'admin', $hasUser, '登录成功'));
        } else {
            return json(logomsg(500, '', '', '登录失败'));
        }
    }

    public function info()
    {
        $data = input('param.');
        $res = db('admin')->where($data)->find();
        return json(logomsg(200, 'admin', $res, '成功'));
    }
    /*
  * 退出登陆
  */
    public function logout()
    {
        return json(logomsg(200, 'admin', '', '成功'));
    }
}