<?php
/**
 * Created by PhpStorm.
 * User: jon
 * Date: 2018/12/29
 * Time: 1:00 AM
 */

namespace app\common\model;


class Address extends BaseModel
{

    public static function PostDataByadd($data)
    {
        $res = self::insert($data);
        return $res;
    }

}