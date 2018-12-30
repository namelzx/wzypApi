<?php
/**
 * Created by PhpStorm.
 * User: jon
 * Date: 2018/12/27
 * Time: 10:11 PM
 */

namespace app\index\controller;


use app\common\model\User;
use think\Controller;

class Base extends Controller
{
    public function GetUserByOenid()
    {
        $data = input('param.');
        $url = "https://api.weixin.qq.com/sns/jscode2session?appid=" . $data['appid'] . "&secret=" . $data['secret'] . "&js_code=" . $data['js_code'] . "&grant_type=authorization_code";
        $data = $this->curlSend($url);
        return json_encode($data);
    }

    /**
     * 检测用户是否存在
     */
    public function CheckUser()
    {
        $PostData = input('param.');
        $data = User::where('openid', $PostData['openid'])->find();
        if (empty($data)) {
            $res = User::create($PostData);
            return json(['token' => 'user', 'data' => $res]);
        } else {
            return json(['token' => 'user', 'data' => $data]);
        }
    }

    //调用获取路径
    public function curlSend($url, $data = '')
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //不进行证书验证
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); //不进行主机头验证
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); //结果不直接输出在屏幕上
        $data && curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $data ? curl_setopt($ch, CURLOPT_POST, true) : curl_setopt($ch, CURLOPT_POST, false);  //发送的方式
        curl_setopt($ch, CURLOPT_URL, $url);   //发送的地址
        $result = curl_exec($ch);
        curl_close($ch);
        $info = json_decode($result, true);
        return $info;
    }

}