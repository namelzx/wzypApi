<?php
/**
 * Created by PhpStorm.
 * User: jon
 * Date: 2018/12/27
 * Time: 1:35 AM
 */

namespace app\api\controller;


use app\api\model\GoodsType;

class Gtype extends Base
{


    /*
    * 获取数据列表
    */
    public function GetDataByList()
    {
        $data = input('param.');
        $res = GoodsType::GetByList($data);
        return json(msg(200, $res, '获取成功'));
    }

    /*
     * 提交数据
     */
    public function PostDataByData()
    {
        $data = input('param.');

        $res = GoodsType::PostDataByAll($data);
        return json(msg(200, $res, '获取成功'));
    }

    /*
      * 更新状态
      */
    public function GetDataByStatus()
    {
        $data = input('param.');
        $res = GoodsType::where('id', $data['id'])->data(['status' => $data['status']])->update();
        return json(msg(200, $res, '更新状态成功'));
    }

    /*
     * 修改信息
     */
    public function PostDataByUpdate()
    {
        $data = input('param.');
        $res = GoodsType::where('id', $data['id'])->data($data)->update();
        return json(msg(200, $res, '更新成功'));
    }

    /*
     * 删除信息
     */
    public function GetDataByDelete()
    {
        $data = input('param.');
        $res = GoodsType::where('id', $data['id'])->delete();
        return json(msg(200, $res, '删除成功'));
    }
}