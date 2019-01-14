<?php

namespace app\index\controller;


use EasyWeChat\Factory;

class Index
{
    public function index()
    {
        $data=input('param.');
        $config = [
            'app_id' => 'wx5b41a56038e8ec76',
            'secret' => 'e8dedad2705f30a4e9ff9e16dabe915f',

            // 下面为可选项
            // 指定 API 调用返回结果的类型：array(default)/collection/object/raw/自定义类名
            'response_type' => 'array',

            'log' => [
                'level' => 'debug',
                'file' => __DIR__.'/wechat.log',
            ],
        ];

        $app = Factory::miniProgram($config);

       $res= $app->template_message->send([
            'touser' => 'ow5-45a1YF7DuDgSGD_dFzRnBv1Q',
            'template_id' => 'jSug2iNgl5sqXyptRMvtNcLQlZWIQY6vYA5GDgBjU0g',
            'page' => 'index',
            'form_id' => $data['fid'],
            'data' => [
                'keyword1' => 'VALUE',
                'keyword2' => 'VALUE2',
                'keyword3' => 'VALUE',
                'keyword4' => 'VALUE2',
                // ...
            ],
        ]);
       return json($res);

    }

    public function hello($name = 'ThinkPHP5')
    {
        return 'hello,' . $name;
    }
}
