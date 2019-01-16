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

use EasyWeChat\Factory;

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
            $bisdata = [
                'bis_id' => $res['id'],
                'name'=>$PostData['nickName']."的小店",
                'introduce'=>"店家什么都没有说",
                'banner'=>'https://wzyp.oss-cn-beijing.aliyuncs.com/banner/banner2.png'
            ];
            db('bis')->insert($bisdata);
            return json(['token' => 'user', 'data' => $res, 'status' => 204]);
        } else {
            return json(['token' => 'user', 'data' => $data, 'status' => 200]);
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

    /**
     * 模版消息
     * @param $data
     * @return \think\response\Json
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     */
    public function templateMessage($data){
        $config = [
            'app_id' => 'wx5b41a56038e8ec76',
            'secret' => 'e8dedad2705f30a4e9ff9e16dabe915f',

            // 下面为可选项
            // 指定 API 调用返回结果的类型：array(default)/collection/object/raw/自定义类名
            'response_type' => 'array',

            'log' => [
                'level' => 'debug',
                'file' => __DIR__ . '/wechat.log',
            ],
        ];
        $app = Factory::miniProgram($config);
        $res = $app->template_message->send([
            'touser' => $data['openid'],
            'template_id' =>$data['template_id'],
            'page' => $data['page'],
            'form_id' => $data['formId'],
            'data' => [
                'keyword1' => $data['keyword1'],
                'keyword2' => $data['keyword2'],
                'keyword3' => $data['keyword3'],
                'keyword4' => $data['keyword4'],
                'keyword5' => $data['keyword5'],
            ],
        ]);
        //记录日志
        $tem = [
            'log' => $res['errcode'] . $res['errmsg'] . $data['formId']
        ];
        db('log')->insert($tem);
        return json($res);
    }

}