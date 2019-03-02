<?php
/**
 * Created by PhpStorm.
 * User: jon
 * Date: 2018/12/28
 * Time: 10:15 PM
 */

namespace app\common\model;


class User extends BaseModel
{
    /**
     *获取供货商
     */
    public static function GetSupplierByList($data)
    {
        $res = self::where('status', 'neq', 0);

        $res = $res->order('id desc')->paginate($data['limit'], false, ['query' => $data['page']]);
        return $res;
    }
    /**
     * 获取所有的用户
     */
    public static function GetUserByList($data)
    {

        $res = self::order('id desc')->paginate($data['limit'], false, ['query' => $data['page']]);
        return $res;
    }

}