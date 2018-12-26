<?php
/**
 * Created by PhpStorm.
 * User: jon
 * Date: 2018/12/25
 * Time: 4:26 PM
 */

namespace app\api\model;


class Admin extends BaseModel
{
    public static function GetByList($data)
    {
        $res = self::paginate($data['limit'], false, ['query' => $data['page']]);
        return $res;
    }

    public static function PostByData($data)
    {
        $res = self::insert($data);
        return $res;
    }

}