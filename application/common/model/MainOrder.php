<?php
/**
 * Created by PhpStorm.
 * User: jon
 * Date: 2018/12/29
 * Time: 1:40 PM
 */

namespace app\common\model;


class MainOrder extends BaseModel
{
    /**
     * 获取单条
     */
    public function banneritems()
    {
        return $this->hasOne('GoodsBanner', 'goods_id', 'id');
    }
    /**
     * 获取用户信息
     */
    public function userinfo()
    {
        return $this->hasOne('User', 'id', 'user_id');
    }
    /**
     * 获取订单从表
     */
    public function fromorder()
    {
        return $this->hasOne('FromOrder', 'order_id', 'id');

    }

    /**
     * 获取整个数据列表
     */
    public function bannerList()
    {
        return $this->hasMany('GoodsBanner', 'goods_id', 'id');
    }

    public static function GetByList($data)
    {
        $res = self::with('fromorder');


        if (!empty($data['user_id'])) {
            $res = $res->where('user_id', $data['user_id']);
        }
        if (!empty($data['status'])) {
            $res = $res->where('status', $data['status']);
        }
        $res = $res->paginate($data['limit'], false, ['query' => $data['page']]);
        return $res;
    }

    /**
     *获取详细信息
     */
    public static function GetDataBydetailed($id)
    {
        $res = self::with('fromorder')->where('id', $id)->find();
        return $res;
    }
    /**
     *根据订单号查询订单信息
     */
    public static function GetDataBytrade_no($out_trade_no)
    {
        $res = self::with( ['userinfo','fromorder'])->where('out_trade_no', $out_trade_no)->find();
        return $res;
    }

}