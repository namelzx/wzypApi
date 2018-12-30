<?php
/**
 * Created by PhpStorm.
 * User: jon
 * Date: 2018/12/27
 * Time: 3:30 PM
 */

namespace app\common\controller;


use think\Controller;



header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, authKey, sessionId, Access-Token, X-Token");

class Images extends Controller
{
    public function index(){
        return json(11);
    }

}