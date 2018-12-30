<?php
/**
 * Created by PhpStorm.
 * User: jon
 * Date: 2018/12/27
 * Time: 10:11 PM
 */

namespace app\index\controller;

use app\common\model\BisGoods;
use app\common\model\Goods as GoodsModel;

class Goods extends Base
{
    /**
     * 获取数据列表
     */
    public function GetDataByList()
    {
        $data = input('param.');
        $res = GoodsModel::GetByList($data);
        return json(msg(200, $res, '获取成功'));
    }

    /**
     * 详细信息
     */
    public function GetDataBydetailed()
    {
        $data = input('param.');
        $res = GoodsModel::GetDataBydetailed($data);
        return json(msg(200, $res, '获取成功'));
    }

    /**
     * 用户添加商品进自己店铺
     */
    public function PostBisGoodsByAdd()
    {
        $data=input('param.');
        //检测商品是否上架
        $checkGoods=BisGoods::where(['goods_id'=>$data['goods_id'],'user_id'=>$data['user_id']])->count();
        if($checkGoods<1){
           $res= BisGoods::PostDataByAll($data);
            return json(msg(200, $res, '已加入店铺'));

        }
        return json(msg(200, '', '商品已存在'));

    }


}