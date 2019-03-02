<?php
/**
 * Created by PhpStorm.
 * User: jon
 * Date: 2018/12/25
 * Time: 4:20 PM
 */

namespace app\api\controller;

use app\api\model\Admin;
use Firebase\JWT\JWT;

define('KEY', '1gHuiop975cdashyex9Ud23ldsvm2Xq'); //密钥


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
            $token = [
                'iss' => 'http://www.helloweba.net', //签发者
                'aud' => 'http://www.helloweba.net', //jwt所面向的用户
                'iat' => time(), //签发时间
                'nbf' => time() + 1, //在什么时间之后该jwt才可用
                'exp' => time() + 10, //过期时间-10min
                'data' => [
                    'user' => $hasUser,
                ]
            ];
            $jwt = JWT::encode($token, KEY);//加密
            return json(logomsg(200, $jwt, $hasUser, '登录成功'));
        } else {
            return json(logomsg(500, '', '', '登录失败'));
        }
    }

    public function info()
    {
        $jwt = isset($_SERVER['HTTP_X_TOKEN']) ? $_SERVER['HTTP_X_TOKEN'] : '';
        if (empty($jwt)) {
            $res['msg'] = 'You do not have permission to access.';
            echo json_encode($res);
            exit;
        }

        try {
            JWT::$leeway = 60000000;
            $decoded = JWT::decode($jwt, KEY, ['HS256']);
            $arr = (array)$decoded;
//            if ($arr['exp'] < time()) {
//                $res['msg'] = '请重新登录';
//            } else {
            $res['result'] = 'success';
            $res['info'] = $arr;
//            }
        } catch (Exception $e) {
            $res['msg'] = 'Token验证失败,请重新登录';
            return json(logomsg(204, $jwt, $res, $res['msg']));

        }
        return json(logomsg(200, $jwt, $res, '获取jwt数据'));
    }

    /*
  * 退出登陆
  */
    public function logout()
    {
        return json(logomsg(200, 'admin', '', '成功'));
    }
}