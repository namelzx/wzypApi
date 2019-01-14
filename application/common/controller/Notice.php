<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 2019/1/9
 * Time: 1:53 AM
 */

namespace app\common\controller;


use EasyWeChat\Factory;
use think\Collection;

class Notice extends Collection
{
    public function test(){
        $config=['wx_config'];
        $app=Factory::miniProgram($config);
        dump($app->template_message->list());
    }

}