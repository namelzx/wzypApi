<?php
/**
 * Created by PhpStorm.
 * User: jon
 * Date: 2018/12/27
 * Time: 1:32 AM
 */

namespace app\api\model;


class GoodsType extends BaseModel
{

    public static function PostDataByAll($data)
    {
        $res = self::insert($data);
        return $res;
    }

    public static function GetByList($data)
    {
        $res = self::paginate($data['limit'], false, ['query' => $data['page']]);
        return $res;
    }
}