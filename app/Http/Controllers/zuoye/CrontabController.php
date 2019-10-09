<?php

namespace App\Http\Controllers\zuoye;
use App\Tools\Tools;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class CrontabController extends Controller
{
    public $tools;
    public function __construct(Tools $tools)
    {
        $this->tools = $tools;
    }
//    登陆
    public function login()
    {
        return view('zuoye.login');
    }
    public function login_do()
    {
        
    }
    public  function  wechat()
    {
        $redirect_uri='http://www.mayansen.cn/zuo/code';
        $url='https://open.weixin.qq.com/connect/oauth2/authorize?appid='.env('WECHAT_APPID').'&redirect_uri='.urlencode($redirect_uri).'&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect';
        header('Location:'.$url);
    }
    public function code()
    {
        $res=request()->all();
        $result = file_get_contents('https://api.weixin.qq.com/sns/oauth2/access_token?appid='.env('WECHAT_APPID').'&secret='.env('SECRET').'&code='.$res['code'].'&grant_type=authorization_code');
        $re = json_decode($result,1);
        return redirect('index/tog_list');
    }

}
