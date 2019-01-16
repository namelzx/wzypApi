<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 2019/1/12
 * Time: 14:24
 */

namespace app\index\controller;

use OSS\Core\OssException;
use Oss\OssClient;

class Wechat extends Base
{
    /**
     * 获取微信token
     */
    public function GetToken()
    {
        $config = config('wx_config');
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $config['app_id'] . "&secret=" . $config['secret'] . "";
        $data = $this->curlSend($url);
        return json_encode($data['access_token']);
    }

    /**
     * 获取微信二维码
     */
    public function GetCode()
    {
        $postdata = input('param.');
        $url = "https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token=" . $postdata['token'];
        $data = [
            'scene' => "bis",
            'width' => 430,
            'auto_color' => false,
        ];
        if (!empty($postdata['scene'])) {
            $data['scene'] = $postdata['scene'];
        }
        $data = json_encode($data);
        $result = $this->_requestPost($url, $data);
        if (!$result) {
            return false;
        }
        $config = config('aliyun_oss');
        $fileName = time();
        if ($fileName) {
            //判断file文件中是否存在数据库当中
            file_put_contents("./uploads/" . $fileName . ".jpeg", $result);
            $path = "./uploads/" . $fileName . ".jpeg";
            $fil = $this->uploadFile($config['Bucket'], $fileName . ".jpeg", $path);
            if ($fil) {
                unlink($path);
            }
            if (!empty($postdata['type']) ) {
                if($postdata['type']==1){

                db('bis')->where('bis_id', $postdata['bis_id'])->data(['sharecode' => $config['url'] . $fileName . ".jpeg"])->update();

                }
            }
            return $config['url'] . $fileName . ".jpeg";
        }
        return json_encode($data);
    }


    public function Erweima()
    {

    }

    /**
     * 发送GET请求的方法
     * @param string $url URL
     * @param bool $ssl 是否为https协议
     * @return string 响应主体Content
     */
    protected function _requestPost($url, $data, $ssl = true)
    {
        //curl完成
        $curl = curl_init();
        //设置curl选项
        curl_setopt($curl, CURLOPT_URL, $url);//URL
        $user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '
    Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0 FirePHP/0.7.4';
        curl_setopt($curl, CURLOPT_USERAGENT, $user_agent);//user_agent，请求代理信息
        curl_setopt($curl, CURLOPT_AUTOREFERER, true);//referer头，请求来源
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);//设置超时时间
        //SSL相关
        if ($ssl) {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);//禁用后cURL将终止从服务端进行验证
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);//检查服务器SSL证书中是否存在一个公用名(common name)。
        }
        // 处理post相关选项
        curl_setopt($curl, CURLOPT_POST, true);// 是否为POST请求
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);// 处理请求数据
        // 处理响应结果
        curl_setopt($curl, CURLOPT_HEADER, false);//是否处理响应头
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);//curl_exec()是否返回响应结果

        // 发出请求
        $response = curl_exec($curl);
        if (false === $response) {
            echo '<br>', curl_error($curl), '<br>';
            return false;
        }
        curl_close($curl);
        return $response;

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