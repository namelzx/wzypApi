<?php
/**
 * Created by PhpStorm.
 * User: jon
 * Date: 2019/1/5
 * Time: 2:16 AM
 */

namespace app\index\controller;

use app\common\model\MainOrder;

/**
 * Class Supply 供货商模块
 * @package app\index\controller
 */
class Supply extends Base
{

    public function PostDataByData()
    {

        $data = input('param.');

        if (!empty($data['id'])) {
            $res = \app\api\model\Goods::where('id', $data['id'])->data($data)->update();
            \app\api\model\GoodsBanner::where('goods_id', $data['id'])->delete();
            $bannner = [];
            for ($i = 0; $i < count($data['images']); $i++) {
                $bannner[$i]['url'] = $data['images'][$i];
                $bannner[$i]['goods_id'] = $data['id'];
            }
            \app\api\model\GoodsBanner::PostDataByInser($bannner);
            return json(msg(200, $bannner, '修改成功'));

        } else {
            $res = \app\api\model\Goods::PostDataByAll($data);
        }

        $bannner = [];
        for ($i = 0; $i < count($data['images']); $i++) {
            $bannner[$i]['url'] = $data['images'][$i];
            $bannner[$i]['goods_id'] = $res;
        }
        \app\api\model\GoodsBanner::PostDataByInser($bannner);
        return json(msg(200, $bannner, '获取成功'));
    }

    /**
     * 获取详情
     */
    public function GetDataByFind()
    {
        $data = input('param.');
        $res = \app\common\model\Goods::GetDataBydetailed($data);
        return json(msg(200, $res, '获取成功'));
    }


    /**
     * 获取商家商品
     */
    public function GetShopByGoods()
    {
        $data = input('param.');
        $res = \app\common\model\Goods::GetShopByGoods($data);
        return json(msg(200, $res, '获取成功'));
    }

    /**
     * 删除数据
     */
    public function GetShopGoodsByDelete()
    {
        $data = input('param.');
        $res = \app\common\model\Goods::GetShopGoodsByDelete($data);
        return json(msg(200, $res, '删除成功'));
    }

    /**
     * 修改商品状态
     */
    public function GetShopGoodsByStatus()
    {
        $data = input('param.');
        $res = \app\common\model\Goods::GetShopGoodsByStatus($data);
        return json(msg(200, $res, '修改成功'));
    }

    /**
     * 查询订单
     */
    public function queryOrder()
    {
        $data = input('param.');
        $res = MainOrder::GetDataBytrade_no($data['out_trade_no']);
        return json(msg(200, $res, '返回订单数据'));
    }

    /**
     * 供货商获取订单
     */
    public function getSupplyByOrder()
    {
        $data = input('param.');
        $res = MainOrder::getSupplyByOrder($data);
        return json(msg(200, $res, '返回订单数据'));
    }

    /**
     * 商家的基本情况
     */
    public function getMerchant()
    {
        $data = input('param.');

        $ordertoday = MainOrder::GetSupplyMainByList($data);//今天的订单
        $orderData = $this->todayOrder($ordertoday);//订单数据
        return json($orderData);
    }
    /**
     * 计算今日待确认订单
     */
    public function todayOrder($ordertoday)
    {
        $data = [
            'TBC' => 0,//待确认
            'SC' => 0,//已完成订单
            'tay' => 0,
            'taysum' => 0,//今日完成金额
            'monthsum' => 0,//本月完成金额
            'jxz' => 0,//进行中的订单
            'djzj' => 0,//等待完成订单利润
            'tayprofit'=>0,//今天的订单利润
            'monthprofit'=>0,//本月的营收利润
        ];
        $TBC = 0;//待确认
        $SC = 0;
        $tay = date("Y-m-d");//今天
        $month = date("Y-m");//本月
        foreach ($ordertoday as $v => $item) {
            if ($ordertoday[$v]['status'] == 0) {
                $data['TBC']++;
            }
            if ($ordertoday[$v]['status'] == 2) {
                $data['SC']++;
            }
            //进行中的订单
            if ($ordertoday[$v]['status'] == 0 || $ordertoday[$v]['status'] == 1) {
                $data['jxz']++;
                $fromorder = $ordertoday[$v]['fromorder'];
                $price = $fromorder['price'];   //订单完成价格
                $shelves_price = $fromorder['shelves_price'];//订单上架价格
                $proportion=$fromorder['proportion']/100;
                //我们先计算出分销商的利润，因此使用完成的价格减去 上架价格就是分销商的利润了
                $data['djzj']+=$price-($price-$shelves_price)-($price*$proportion);//得到分销商利润
                //需要计算订单的成交价格。和商品的用户比例和分成
            }
            //今天的订单
            if ($tay === substr($ordertoday[$v]['create_time'], 0, 10)) {
                if ($ordertoday[$v]['status'] == 2) {
                    //今天的销售额
                    $data['tay']++;
                    $data['taysum'] += $ordertoday[$v]['allGoodsAndYunPrice'];

                    //今天的营收利润金额
                    $fromorder = $ordertoday[$v]['fromorder'];
                    $price = $fromorder['price'];   //订单完成价格
                    $shelves_price = $fromorder['shelves_price'];//订单上架价格
                    $proportion=$fromorder['proportion']/100;
                    //我们先计算出分销商的利润，因此使用完成的价格减去 上架价格就是分销商的利润了
                    $data['tayprofit']+=$price-($price-$shelves_price)-($price*$proportion);//得到分销商利润
                }
            }
//           //本月的
            if ($month === substr($ordertoday[$v]['create_time'], 0, 7)) {
                if ($ordertoday[$v]['status'] == 2) {
                    $data['monthsum'] += $ordertoday[$v]['allGoodsAndYunPrice'];

                    //本月的的营收利润金额
                    $fromorder = $ordertoday[$v]['fromorder'];
                    $price = $fromorder['price'];   //订单完成价格
                    $shelves_price = $fromorder['shelves_price'];//订单上架价格
                    $proportion=$fromorder['proportion']/100;
                    //我们先计算出分销商的利润，因此使用完成的价格减去 上架价格就是分销商的利润了
                    $data['monthprofit']+=$price-($price-$shelves_price)-($price*$proportion);//得到分销商利润
                }
            }

        }
        return $data;
    }

}