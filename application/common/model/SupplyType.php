<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 2019/1/20
 * Time: 23:56
 */

namespace app\common\model;


class SupplyType extends BaseModel
{
    /**
     * 所属分类
     */
    public function typefind()
    {
        return $this->hasOne('GoodsType', 'id', 'type_id');
    }
    /**
     * @param $suuply_id 所属供货商id
     */
    public static function GetDataByList($data)
    {
        return self::where('supply_id', $data['supply_id'])->field('type_id,supply_id,proportion')->select();
    }

    public static function getSupplyByType($data){
        return self::with('typefind')->where($data)->select();
    }
}