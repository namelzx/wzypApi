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
        if (empty($data['phone'])) {
            return json(msg(404, '', '请输入手机号码'));
        }
        $main = [
            'out_trade_no' => $data['out_trade_no'],
            'user_id' => $data['user_id'],
            'allGoodsAndYunPrice' => $data['allGoodsAndYunPrice'],
//            'remark' => $data['remark'],
            'create_time' => time(),
            'shop_id' => $data['bis_id'],
            'phone' => $data['phone'],
            'code' => $data['code'],
            'supply_id' => $data['supply_id'],
        ];
        $order_id = MainOrder::insertGetId($main);
        $data['goodsList']['order_id'] = $order_id;
        $data['goodsList']['bis_id'] = $data['bis_id'];//分销商id
        $Model->allowField(true)->insert($data['goodsList']);

        return json(msg(200, $order_id, '成功下单'));
    }

    /**
     * 更新状态
     */
    public function GetDataByStatus()
    {
        $data = input('param.');
        $res = MainOrder::where('id', $data['id'])->data(['status' => $data['status']])->update();
        return json(msg(200, $res, '更新状态成功'));
    }


    /**
     * 删除信息
     */
    public function GetDataByDelete()
    {
        $data = input('param.');
        $res = MainOrder::where('id', $data['id'])->delete();
        return json(msg(200, $res, '删除成功'));
    }

    /**
     * 详细信息
     */
    public function GetDataBydetailed()
    {
        $data = input('param.');
        $res = MainOrder::GetDataBydetailed($data['id']);
        return json(msg(200, $res, '获取订单信息'));
    }

    /**
     * 修改订单状态
     */
    public function PostOrderBystate()
    {
        $data = input('param.');
        if ($data['type'] == 1) {
            //判断发送类型。 1 是用户操作。所以需要发送给商家。那么就应该查询该商品的id是属于那个商家根据商品的bis_id 根据bis_id去查询user表查询用户的openid再发送给商家信息
            $bis = \app\common\model\Goods::GetSupplyByinfo($data['goods_id']);
            $data['data']['openid'] = $bis['supply']['openid'];
        }
        if ($data['type'] == 2) {
            $bis = db('user')->where('id', $data['user_id'])->field('openid')->find();
            $data['data']['openid'] = $bis['openid'];
        }
        //订单等于2的时候就是使用订单。 在使用订单后就应该利润分成
        if ($data['status'] == 2) {
            $res = MainOrder::get($data['id']);
            $order_log = [
                'order_id' => $data['id'],
                'ordersum' => 0,
                'admin_price' => 0,
                'shelves_price' => 0,
                'create_time' => time(),
                'supply_price' => 0
            ];
            $ordergoods = $res->fromorder;//订单的相关信息
            $order_log['ordersum'] = $res['allGoodsAndYunPrice'];//订单总价

            $order_log ['admin_price'] = $ordergoods['proportion'] * $ordergoods['number'];//
            
            $order_log['shelves_price'] = $ordergoods['shelves_price']
                * $ordergoods['number'];//根据商品的分销利润和数量向乘得到。
            $order_log['supply_price'] = $order_log['ordersum']
                - $order_log['shelves_price']
                - $order_log ['admin_price'];//最后供货商得到的利润就是成交总价-平台分红-分销商分红
            db('order_succeed_log')->insert($order_log);
            db('goods')->where('id',$data['goods_id'])->setInc('sales', $ordergoods['number']);
        }
       $res=   MainOrder::where('id', $data['id'])->data(['status' => $data['status']])->update();
        return json(msg(400, $res, '执行成功'));
    }




}