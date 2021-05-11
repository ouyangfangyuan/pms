<?php
namespace Rc\Pms;

use GuzzleHttp\Client;
use Rc\Pms\Support\Helper;

class OpenApi
{
   protected $app_key,$channel_key;
    const URL="http://pms.beyondh.com:7897";
    public $requester;

    public function __construct(string $app_key,string $channel_key)
    {
        $this->channel_key = $channel_key;
        $this->app_key = $app_key;
        $this->requester = new Client(["headers"=>["Content-Type"=>"application/json",'domain'=>'pms']]);
    }

    /**
     * @param string $method_name  接口方法名
     * @param array $options    相关参数
     * @return mixed
     * @throws Exceptions\HttpException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function sendRequest(string $method_name,array $options)
    {
        return Helper::response($this->requester->post(self::URL,['body'=>$this->_setParams($method_name,$options)])->getBody()->getContents());

    }
    protected function _setParams(string $method_name,array $biz_content):string
    {
        $arr1 = [
            'ChannelKey'=>$this->channel_key,
            'Method'=>$method_name,
            'BizContent'=>\json_encode($biz_content),
            'Sign'=>'',
            'SignType'=>"MD5",
            'Format'=>"json",
            'Charset'=>"utf-8",
            'Version'=>"1.0",
            "Timestamp"=>date('Y-m-d H:i:s',time())
        ];
        $arr1['Sign'] = strtoupper(md5(Helper::getSignature($arr1,$this->app_key)));
        return \json_encode($arr1);
    }

}