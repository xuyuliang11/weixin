<?php

namespace App\Http\Controllers;

use App\Tools\Tools;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Storage;
class QrcodeContronller extends Controller
{
    public $tools;
    public function __construct(Tools $tools)
    {
        $this->tools = $tools;
    }
    public function qrcode_list()
    {
        $data=DB::table('wechat_user')->get();
        return view('qrcode/qrcode_list',['data'=>$data]);
    }
//    生成二维码
    public function qrcode()
    {
        $id=request()->input('id');
        $url='https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token='.$this->tools->get_wechat_access_token();
        $data=[
            'action_name'=>'QR_LIMIT_SCENE',
            'action_info'=>[
                'scene'=>[
                    'scene_id'=>$id
                ]
            ]
        ];
        $res=$this->tools->curl_post($url,json_encode($data));
        $qrcode_ticket=json_decode($res,1);
        $ticket=file_get_contents('https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='.$qrcode_ticket['ticket']);
        $url='wechat/qrcode/'.time().'.jpg';
        $pathres=Storage::put($url,$ticket);
        DB::table('wechat_user')->where('id','=',$id)->update([
            'path'=>$url
    ]);
        echo 'ok';
    }
}
