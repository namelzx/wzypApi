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
        $res=MainOrder::GetDataBytrade_no($data['out_trade_no']);
        return json(msg(200, $res, '返回订单数据'));
    }

}