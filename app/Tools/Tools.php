<?php
namespace App\Tools;

class Tools {
    public $redis;
    public function __construct()
    {
        $this->redis = new \Redis();
        $this->redis->connect('127.0.0.1','6379');
    }
//    获取access_token
    public function get_wechat_access_token()
    {

//        //加入缓存
        if($this->redis->exists('wechat_access_token')){
            //存在
            return$this->redis->get('wechat_access_token');
        }else{
            //不存在
            $result = file_get_contents('https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wx36ede3bf907bbde6&secret=6729c768df1aab121ad378ae04d6f495');
            $res = json_decode($result,1);
            $this->redis->set('wechat_access_token',$res['access_token'],7200);  //加入缓存
            return $res['access_token'];
        }
    }
//
    public function client_upload($url,$path,$client,$is_video=0,$title='',$desc=''){
        $multipart =  [
            [
                'name'     => 'media',
                'contents' => fopen($path, 'r')
            ]
        ];
        if($is_video == 1){
            $multipart[] = [
                'name'=>'description',
                'contents' => json_encode(['title'=>$title,'introduction'=>$desc],JSON_UNESCAPED_UNICODE)
            ];
        }
        $result = $client->request('POST',$url,[
            'multipart' => $multipart
        ]);
        return $result->getBody();
    }
//    curl
    public function curl_post($url,$data)
    {
        $curl = curl_init($url);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl,CURLOPT_POST,true);  //发送post
        curl_setopt($curl,CURLOPT_POSTFIELDS,$data);
        $data = curl_exec($curl);
        $errno = curl_errno($curl);  //错误码
        $err_msg = curl_error($curl); //错误信息
        curl_close($curl);
        return $data;
    }
    /**
     * jsapi_ticket
     * @return bool|string
     */
    public function get_wechat_jsapi_ticket()
    {
        //加入缓存
        if($this->redis->exists('wechat_jsapi_ticket')){
            //存在
            return $this->redis->get('wechat_jsapi_ticket');
        }else{
            //不存在
            $result = file_get_contents('https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token='.$this->get_wechat_access_token().'&type=jsapi');
            $re = json_decode($result,1);
            $this->redis->set('wechat_jsapi_ticket',$re['ticket'],7200);  //加入缓存
            return $re['ticket'];
        }
    }
}