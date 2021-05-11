<?php
namespace Rc\Pms\Support;


use Rc\Pms\Exceptions\HttpException;
use Rc\Pms\OpenApi;

class Helper
{

    static function getSignature($params = array(),string $app_key){
        //ksort()对数组按照键名进行升序排序
        ksort($params);
        //reset()内部指针指向数组中的第一个元素
        reset($params);
        $sign = '';//初始化
        foreach ($params as $key => $val) { //遍历POST参数
            if ($val == ''||$key == 'Sign') continue; //跳过这些不签名
            if ($sign) $sign .= '&'; //第一个字符串签名不加& 其他加&连接起来参数
            $sign .= "$key=$val"; //拼接为url参数形式
        }
        return $sign.$app_key;
    }
    static function response(string $datas)
    {
        $data = json_decode($datas,true);
        if($data['Code'] != 10000) throw new HttpException($data['Message']);
        return $data;
    }
}