<?php
/**
 * Created by PhpStorm.
 * User: jon
 * Date: 2018/12/29
 * Time: 1:52 PM
 */

namespace app\index\controller;


use app\common\model\FromOrder;
use app\common\model\MainOrder;

class Order extends Base
{
    /*
 * 获取数据列表
 */
    public function GetDataByList()
    {
        $data = input('param.');
        $res = MainOrder::GetByList($data);
        return json(msg(200, $res, '获取成功'));
    }

    /*
     * 提交数据
     */
    public function PostDataByData()
    {
        $data = input('param.');
        $Model = new FromOrder();

        $out_trade_no = date('Ymd') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
        $main = [
            'out_trade_no' => $out_trade_no,
            'user_id' => $data['user_id'],
            'address_id' => $data['address_id'],
            'allGoodsAndYunPrice' => $data['allGoodsAndYunPrice'],
            'remark' => $data['remark'],
            'create_time'=>time()
        ];
        $order_id = MainOrder::insertGetId($main);

        for ($i = 0; $i < count($data['goodsList']); $i++) {
            $ret[$i] = $data['goodsList'][$i];
            $ret[$i]['order_id'] = $order_id;
        }

        $from=$Model->allowField(true)->saveAll($ret);
        return json(msg(200, $from, '添加成功'));
    }

    /*
      * 更新状态
      */
    public function GetDataByStatus()
    {
        $data = input('param.');
        $res = MainOrder::where('id', $data['id'])->data(['status' => $data['status']])->update();
        return json(msg(200, $res, '更新状态成功'));
    }


    /*
     * 删除信息
     */
    public function GetDataByDelete()
    {
        $data = input('param.');
        $res = MainOrder::where('id', $data['id'])->delete();
        return json(msg(200, $res, '删除成功'));
    }

    /*
     * 详细信息
     */
    public function GetDataBydetailed()
    {
        $data = input('param.');
        $res = MainOrder::GetDataBydetailed($data['id']);
        return json(msg(200, $res, '获取成功'));
    }


}