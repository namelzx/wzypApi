<?php
/**
 * Created by PhpStorm.
 * User: jon
 * Date: 2019/1/2
 * Time: 8:24 PM
 */

namespace app\index\controller;


use app\common\model\BisGoods;

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
        $res = \app\common\model\Goods::GetByList($data, $whereorder);
        return json(msg(200, $res, '获取成功'));
    }

}