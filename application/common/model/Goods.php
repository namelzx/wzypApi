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
            $res = $res->with(['banneritems','bis'])->whereIn('id', $shop);
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
