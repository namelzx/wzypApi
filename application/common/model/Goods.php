<?php
/**
 * Created by PhpStorm.
 * User: jon
 * Date: 2018/12/27
 * Time: 10:09 PM
 */

namespace app\common\model;


use think\Model;

class Goods extends Model
{
    /**
     * 获取单条
     */
    public function banneritems()
    {
        return $this->hasOne('GoodsBanner', 'goods_id', 'id');
    }
    /**
     * 获取商家信息
     */
    public function supply(){
        return $this->hasOne('User', 'id', 'bis_id');
    }

    /**
     * 获取整个数据列表
     */
    public function bannerList()
    {
        return $this->hasMany('GoodsBanner', 'goods_id', 'id');
    }

    /**
     * 获取整个数据列表
     */
    public function bis()
    {
        return $this->hasOne('BisGoods', 'goods_id', 'id');
    }

    public static function GetByList($data, $shop = null)
    {
        $res = self::with('banneritems');

        if (!empty($data['type_id'])) {
            $res = $res->where('type_id', $data['type_id']);
        }
        if (!empty($shop)) {
            $res = $res->with(['banneritems', 'bis'])->whereIn('id', $shop);
        }
        $res = $res->where('status', 1)->paginate($data['limit'], false, ['query' => $data['page']]);
        return $res;
    }

    /**
     * 获取商家商品
     *
     */
    public static function GetShopByList($data, $shop = null)
    {
        $res = self::with('banneritems');
        $res = $res->with(['banneritems', 'bis'])->whereIn('id', $shop);
        $res = $res->where('status', 1)->paginate($data['limit'], false, ['query' => $data['page']]);
        return $res;
    }


    /**
     *获取详细信息
     */
    public static function GetDataBydetailed($id)
    {
        $res = self::with(['bannerList','bis'])->where($id)->find();
        return $res;
    }
    /**
     *获取商家自己的商品
     */
    public static function GetShopByGoods($data)
    {
        $res = self::with('banneritems')->where('supply_id', $data['bis_id']);

        if (!empty($data['type_id'])) {
            $res = $res->where('type_id', $data['type_id']);
        }
        if (!empty($data['status'])) {
            if ($data['status'] != 3) {
                $res = $res->where('status', $data['status']);
            }
        }
        if (empty($data['status'])) {
            $res = $res->where('status', 0);
        }
        if (!empty($shop)) {
            $res = $res->with(['banneritems', 'bis'])->whereIn('id', $shop);
        }
        $res = $res->paginate($data['limit'], false, ['query' => $data['page']]);
        return $res;
    }

    /**
     * 删除商品
     */
    public static function GetShopGoodsByDelete($data)
    {
        $res = self::where($data)->delete();
        return $res;
    }

    /**
     * 修改商品状态
     */
    public static function GetShopGoodsByStatus($data)
    {
        $res = self::where('id', $data['id'])->data($data)->update();
        return $res;
    }

    /**
     * 根据商品id获取商家信息
     */
    public static function GetSupplyByinfo($id){
        $res=self::with('supply')->where('id',91)->find();
        return $res;
    }

}
