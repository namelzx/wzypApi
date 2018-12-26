<?php
/**
 * Created by PhpStorm.
 * User: jon
 * Date: 2018/12/25
 * Time: 4:11 PM
 */

namespace app\api\controller;


use think\Controller;


header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, authKey, sessionId, Access-Token, X-Token");

class Base extends Controller
{

}