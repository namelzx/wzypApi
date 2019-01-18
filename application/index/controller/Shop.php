<?php
/**
 * Created by PhpStorm.
 * User: jon
 * Date: 2019/1/2
 * Time: 8:24 PM
 */

namespace app\index\controller;


use app\common\model\BisGoods;
use app\common\model\MainOrder;

class Shop extends Base
{
    /**
     * 商家店铺
     */
    public function GetShopList()
    {
        $data = input('param.');
        $all = BisGoods::where('user_id', $data['bis_id'])->all();
        $whereorder = [];
        foreach ($all as $v => $item) {
            $whereorder[$v] = $all[$v]['goods_id'];
        }
        $res = \app\common\model\Goods::GetShopByList($data, $whereorder);
        return json(msg(200, $res, '获取成功'));
    }

    /**
     * 获取分销商的订单信息
     */
     public function GetShopOrder(){

         $data=input('param.');
         $res=MainOrder::GetShopMainByList($data);
         $order=$this->todayOrder($res,$data['shop_id']);
         return json($order);
     }



    /**
     * 计算今日待确认订单
     */
    public function todayOrder($ordertoday,$user_id)
    {
        $data = [
            'sum' => 0,// 订单总数
            'profit' => 0,//已完成订单
            'goodsum'=>0,
        ];
        foreach ($ordertoday as $v => $item) {
           $data['sum']++;
            if(!empty($ordertoday[$v]['log'])){
                 $data['profit']+=$ordertoday[$v]['log']['shelves_price'];
            }
        }
        $data['goodsum']=db('bis_goods')->where('user_id',$user_id)->count();
        return $data;
    }

}