<?php
/**
 * Created by PhpStorm.
 * User: jon
 * Date: 2018/12/27
 * Time: 2:43 AM
 */

namespace app\api\controller;

use app\api\model\Goods as GoodsModel;
use app\api\model\GoodsBanner;

class Goods extends Base
{
    /*
   * 获取数据列表
   */
    public function GetDataByList()
    {
        $data = input('param.');
        $res = GoodsModel::GetByList($data);
        return json(msg(200, $res, '获取成功'));
    }

    /*
     * 提交数据
     */
    public function PostDataByData()
    {
        $data = input('param.');

        $res = GoodsModel::PostDataByAll($data['ruleForm']);
        $bannner = [];
        for ($i = 0; $i < count($data['banner']); $i++) {
            $bannner[$i]['name'] = $data['banner'][$i]['name'];
            $bannner[$i]['url'] = $data['banner'][$i]['url'];
            $bannner[$i]['goods_id'] = $res;
        }

        GoodsBanner::PostDataByInser($bannner);
        return json(msg(200, $bannner, '获取成功'));
    }

    /*
      * 更新状态
      */
    public function GetDataByStatus()
    {
        $data = input('param.');
        $res = GoodsModel::where('id', $data['id'])->data(['status' => $data['status']])->update();
        return json(msg(200, $res, '更新状态成功'));
    }

    /*
     * 修改信息
     */
    public function PostDataByUpdate()
    {
        $data = input('param.');
        $res = GoodsModel::where('id', $data['ruleForm']['id'])->strict(false)->data($data['ruleForm'])->update();

        GoodsBanner::where('goods_id', $data['ruleForm']['id'])->delete();//先删除图片
        $bannner = [];
        for ($i = 0; $i < count($data['banner']); $i++) {
            $bannner[$i]['name'] = $data['banner'][$i]['name'];
            $bannner[$i]['url'] = $data['banner'][$i]['url'];
            $bannner[$i]['goods_id'] = $data['ruleForm']['id'];
        }
        GoodsBanner::PostDataByInser($bannner);//再添加图片
        return json(msg(200, $data, '更新成功'));
    }

    /*
     * 删除信息
     */
    public function GetDataByDelete()
    {
        $data = input('param.');
        $res = GoodsModel::where('id', $data['id'])->delete();
        return json(msg(200, $res, '删除成功'));
    }

    /*
     * 详细信息
     */
    public function GetDataBydetailed()
    {
        $data = input('param.');
        $res = GoodsModel::GetDataBydetailed($data['id']);
        return json(msg(200, $res, '获取成功'));
    }

}