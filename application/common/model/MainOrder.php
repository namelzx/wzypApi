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
     * 获取器
     * @param $value
     * @return mixed
     */
//    public function getStatusAttr($value)
//    {
//        $status = [0=>'等待接单',1=>'待使用',2=>'已消费',3=>'退款中',4=>'已退款',5=>'订单取消'];
//        return $status[$value];
//    }

    /**
     * 获取已完成订单的收益情况
     */
    public function log()
    {
        return $this->hasOne('OrderSucceedLog', 'order_id', 'id');
    }
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

    public static function GetByList($data, $status = 0)
    {
        $res = self::with('fromorder');
        $status = $data['status'];
        if (!empty($data['user_id'])) {
            $res = $res->where('user_id', $data['user_id']);
        }
        if (!empty($data['status'])) {
            if ($data['status'] != 2) {
                $res = $res->where('status', $data['status']);
            }

        }
        if ($status == 0) {
            $res = $res->where('status', 0);
        }


        $res = $res->order('id desc')->paginate($data['limit'], false, ['query' => $data['page']]);
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
        $res = self::with(['userinfo', 'fromorder'])->where('out_trade_no', $out_trade_no)->find();
        return $res;
    }

    /**
     * 获取供货商主页订单数据
     */
    public static function GetSupplyMainByList($data)
    {
        $res = self::with('fromorder');

        $orderwhere = [
            'supply_id' => $data['supply_id']
        ];
        $res = $res->where($orderwhere)->order('id desc')->select();
        return $res;
    }

    public static function getSupplyByOrder($data)
    {
        $res = self::with(['fromorder', 'userinfo']);
        $orderwhere = [
            'supply_id' => $data['supply_id']
        ];
        if (!empty($data['type'])) {
            if ($data['type'] == 1) {//当状态等于1的时候 就是供货商首页订单查询。这个时候不显示已经被取消的订单
                $res = $res->where('status', 'neq', '5');
            }
            if ($data['type'] == 2) {
                if ($data['status'] == 5) {
                    $res = $res->where('status', 5);
                }
                if ($data['status'] == 9) {

                } else {
                    $res = $res->where('status', 0);
                }


            }
        }

        $res = $res->where($orderwhere)->order('id desc')->order('status asc')->paginate($data['limit'], false, ['query' => $data['page']]);
        return $res;
    }

    /**
     * 获取分销商订单汇总信息
     */

    public static function GetShopMainByList($data)
    {
        $res = self::with('log');

        $orderwhere = [
            'shop_id' => $data['shop_id']
        ];
        $res = $res->where($orderwhere)->order('id desc')->select();
        return $res;
    }

}