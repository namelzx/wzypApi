<?php
/**
 * Created by PhpStorm.
 * User: jon
 * Date: 2018/12/28
 * Time: 9:00 PM
 */

namespace app\common\model;


class BisGoods extends BaseModel
{

    public static function PostDataByAll($data)
    {
        $res = self::insertGetId($data);
        return $res;
    }

}