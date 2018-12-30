<?php
/**
 * Created by PhpStorm.
 * User: jon
 * Date: 2018/12/27
 * Time: 5:34 PM
 */

namespace app\api\model;


class GoodsBanner extends BaseModel
{

    public static function PostDataByInser($data)
    {
        $res = self::insertAll($data);
        return $res;
    }

}