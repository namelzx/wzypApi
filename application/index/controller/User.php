<?php
/**
 * Created by PhpStorm.
 * User: jon
 * Date: 2018/12/29
 * Time: 1:00 AM
 */

namespace app\index\controller;


use app\common\model\Address;

class User extends Base
{
    public function postAddress()
    {
        $data = input('param.');
        if (empty($data['id'])) {
            $res = Address::PostDataByadd($data);
        } else {
            $res = Address::where('id', $data['id'])->data($data)->update();
            return json(msg(200, $res, '修改成功'));
        }
        return json(msg(200, $res, '获取成功'));
    }

    public function gettAddress()
    {
        $data = input('param.');
        $data['status'] = 1;
        $res = Address::where($data)->find();
        return json(msg(200, $res, '获取成功'));
    }

    public function getAddressByItems()
    {
        $data = input('param.');
        $res = Address::where($data)->select();
        return json(msg(200, $res, '获取成功'));

    }


    public function getAddressBydetailed()
    {
        $data = input('param.');

        $res = Address::get($data);

        return json(msg(200, $res, '获取成功'));
    }

    /**
     *删除数据
     *
     */
    public function GetDataByDelete()
    {
        $data = input('param.');
        $AddMoldel = new Address();
        $res = $AddMoldel->where($data)->delete();
        return json(msg(200, $res, '获取成功'));
    }

    /**
     * 修改默认地址信息
     */
    public function getDefaultAddress()
    {
        $data = input('param.');
        Address::where('user_id', $data['user_id'])->data('status', 0)->update();
        $res = Address::where('id', $data['id'])->data('status', 1)->update();
        return json(msg(200, $res, '获取成功'));
    }

}