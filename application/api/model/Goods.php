<?php
/**
 * Created by PhpStorm.
 * User: jon
 * Date: 2018/12/27
 * Time: 2:43 AM
 */

namespace app\api\model;


class Goods extends BaseModel
{
    protected $field = true;

    public function banneritems()
    {
        return $this->hasMany('GoodsBanner', 'goods_id', 'id');
    }

    public function gtype()
    {
        return $this->hasOne('GoodsType', 'id', 'type_id');
    }

    public static function GetDataBydetailed($id)
    {
        $res = self::with('banneritems')->where('id', $id)->find();
        return $res;
    }

    public static function PostDataByAll($data)
    {
        $res = self::insertGetId($data);
        return $res;
    }

    public static function GetByList($data)
    {
        $res = self::with('gtype');
        if (!empty($data['name'])) {
            $res=  $res->where('name','like','%'.$data['name'].'%');
        }
        if(!empty($data['type_id'])){
          $res=  $res->where('type_id',$data['type_id']);
        }
        $res = $res->paginate($data['limit'], false, ['query' => $data['page']]);
        return $res;
    }
}