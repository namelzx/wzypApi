<?php
/**
 * Created by PhpStorm.
 * User: jon
 * Date: 2018/12/27
 * Time: 1:33 AM
 */

namespace app\api\controller;

use app\api\model\GoodsType;
use OSS\Core\OssException;
use Oss\OssClient;

/**
 * Class Common 常用模块 主要作用是存一些公用调用方法 比如 产品类型这些
 * @package app\api\controller
 */
class Common extends Base
{
    public function getGoodsTypeByList()
    {
        $res = GoodsType::all();
        return json(msg(200, $res, '获取成功'));
    }

    /*
     * 前端上传
     */
    public function indexupload()
    {
        $config = config('aliyun_oss');
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('file');


//        dump($file);
        // 移动到框架应用根目录/uploads/ 目录下
        $info = $file->move('./uploads', '');
        if ($info) {
            $path = $info->getSaveName();
            $fileName = 'uploads/' . $info->getSaveName();
            $fil = $this->uploadFile($config['Bucket'], $fileName, $info->getPathname());
            if ($fil) {
                unlink($fileName);
            }
            $bis_id = input('param.user_id');
            if (!empty($bis_id)) {    //bis不是空的。那么就是商家更新自己的商家表id
               db('bis')->where('bis_id', $bis_id)->data(['banner'=> $config['url'].'uploads/' . $info->getSaveName()])->update();
            }
            return $info->getSaveName();
        } else {
            // 上传失败获取错误信息
            echo $file->getError();
        }


        return json($file);
    }

//模板编辑图片
    public function tempupload()
    {
        $config = config('aliyun_oss');
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('image');

//        dump($file);
        // 移动到框架应用根目录/uploads/ 目录下
        $info = $file->move('./uploads', '');
        if ($info) {
            $path = $info->getSaveName();
            $fileName = 'uploads/' . $info->getSaveName();
            $fil = $this->uploadFile($config['Bucket'], $fileName, $info->getPathname());
            if ($fil) {
                unlink($fileName);
            }
            return $info->getSaveName();
        } else {
            // 上传失败获取错误信息
            echo $file->getError();
        }
        return json($file);
    }

    /**
     * 后端上传
     */
    public function upload()
    {
        $config = config('aliyun_oss');
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('file');
//        dump($file);
        // 移动到框架应用根目录/uploads/ 目录下
        $info = $file->move('./uploads', '');
        if ($info) {
            $path = $info->getSaveName();
            $fileName = 'uploads/' . $info->getSaveName();
            $fil = $this->uploadFile($config['Bucket'], $fileName, $info->getPathname());
            if ($fil) {
                unlink($fileName);
            }
            return json(array('state' => 1, 'path' => $config['url'] . $fileName));
        } else {
            // 上传失败获取错误信息
            echo $file->getError();
        }
        return json($file);
    }


    /**
     * 实例化阿里云OSS
     * @return object 实例化得到的对象
     * @return 此步作为共用对象，可提供给多个模块统一调用
     */
    function new_oss()
    {
        //获取配置项，并赋值给对象$config
        $config = config('aliyun_oss');
        //实例化OSS
        $oss = new \OSS\OssClient($config['KeyId'], $config['KeySecret'], $config['Endpoint']);
        return $oss;
    }


    /**
     * 上传指定的本地文件内容
     *
     * @param OssClient $ossClient OSSClient实例
     * @param string $bucket 存储空间名称
     * @param string $object 上传的文件名称
     * @param string $Path 本地文件路径
     * @return null
     */
    function uploadFile($bucket, $object, $Path)
    {
        //try 要执行的代码,如果代码执行过程中某一条语句发生异常,则程序直接跳转到CATCH块中,由$e收集错误信息和显示
        try {
            //没忘吧，new_oss()是我们上一步所写的自定义函数
            $ossClient = $this->new_oss();
            //uploadFile的上传方法
            $res = $ossClient->uploadFile($bucket, $object, $Path);
            return json($res);
        } catch (OssException $e) {
            //如果出错这里返回报错信息
            return $e->getMessage();
        }
    }

}