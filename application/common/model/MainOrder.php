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
     * 获取订单从表
     */
    public function fromorder()
    {
        return $this->hasMany('FromOrder', 'order_id', 'id');

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
        if(!empty($data['status'])){
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
        $res = self::with('bannerList')->where($id)->find();
        return $res;
    }

}