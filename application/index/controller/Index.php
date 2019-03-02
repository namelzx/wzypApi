<?php

namespace app\index\controller;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;


class Index extends Base
{

    public function index()
    {
//        AlibabaCloud::accessKeyClient('LTAI4G7m7lF5SkXU', 'PbcsuZTY2CMVPjr1K2DGzMejeotVTI')
//            ->regionId('cn-hangzhou') // replace regionId as you need
//            ->asGlobalClient();
//
//        try {
//            $result = AlibabaCloud::rpcRequest()
//                ->product('Dysmsapi')
//                // ->scheme('https')
//                ->version('2017-05-25')
//                ->action('SendSms')
//                ->method('POST')
//                ->options([
//                    'query' => [
//                        'PhoneNumbers' => '18577610926',
//                        'SignName' => '便民生活服务平台',
//                        'TemplateCode' => 'SMS_157280783',
//                        'TemplateParam' => '{"consignee": "1234","number":"18577610926","goodsname": "测试" }',
//                    ],
//                ])
//                ->request();
//            print_r($result->toArray());
//        } catch (ClientException $e) {
//            echo $e->getErrorMessage() . PHP_EOL;
//        } catch (ServerException $e) {
//            echo $e->getErrorMessage() . PHP_EOL;
//        }
    }

    public function hello($name = 'ThinkPHP5')
    {
        return 'hello,' . $name;
    }
}
