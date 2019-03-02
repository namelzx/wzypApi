<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 2019/1/28
 * Time: 15:23
 */

namespace app\api\controller;


use app\common\model\SupplyType;
use app\common\model\User;

class Tuser extends Base
{

    /**
     * 获取供货商列表
     */
    public function getUserByList()
    {

        $data = input('param.');
        $res = User::GetUserByList($data);
        return json(msg(200, $res, '获取成功'));
    }

    /*
     *  修改用户信息
    */
    public function DataStatus()
    {
        $data = input('param.');
        $data['create_time'] = time();
        $res = User::where('id', $data['id'])->data($data)->update();
        return json(msg(200, $res, '操作成功'));
    }

    /**
     * 获取供货商的分类
     */
    public function GetDataTypeByList()
    {
        $data = input('param.');
        $res = SupplyType::GetDataByList($data);
        return json(msg(200, $res, '获取成功'));
    }

    /**
     * 获取供货商的分类
     */
    public function PostDataedit()
    {
        $data = input('param.');
        db('supply_type')->where('supply_id', $data['supply_id'])->delete();
        $res = db('supply_type')->insertAll($data['data']);
        return json(msg(200, $res, '设置成功'));
    }
}