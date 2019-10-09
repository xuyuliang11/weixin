<?php

namespace App\Http\Controllers;
use App\Tools\Tools;
use Illuminate\Http\Request;
use DB;
class GroupController extends Controller
{
    public $tools;
    public function __construct(Tools $tools)
    {
        $this->tools = $tools;
    }
//    登陆试图
    public function login()
    {
        return view('practise/login');
    }
//    微信授权
    public function wechat_login()
    {
        $code='http://w3.la.cn/practise/code';
        $url='https://open.weixin.qq.com/connect/oauth2/authorize?appid='.env('WECHAT_APPID').'&redirect_uri='.urlencode($code).'&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect';
        header('Location:'.$url);
    }
//     获取code
    public function code()
    {
        $data=request()->all();
        $url=file_get_contents('https://api.weixin.qq.com/sns/oauth2/access_token?appid='.env('WECHAT_APPID').'&secret='.env('SECRET').'&code='.$data['code'].'&grant_type=authorization_code');
        $res=json_decode($url,1);
        $user_info=file_get_contents('https://api.weixin.qq.com/sns/userinfo?access_token='.$res['access_token'].'&openid='.$res['openid'].'&lang=zh_CN');
        $wechat_user_info=json_decode($user_info,1);
        $name=DB::table('practise')->where('openid','=',$wechat_user_info['openid'])->first();
        if($name=="")
        {
            DB::table('practise')->insert([
                'name'=>$wechat_user_info['nickname'],
                'pwd'=>'',
                'time'=>time(),
                'openid'=>$wechat_user_info['openid']
            ]);
            request()->session()->put('openid',$wechat_user_info);
            return redirect('practise/user_tag');
        }else{
            request()->session()->put('openid',$wechat_user_info);
            return redirect('practise/user_tag');
        }
    }
//    粉丝列表
    public function user_tag()
    {
        $url=file_get_contents('https://api.weixin.qq.com/cgi-bin/user/get?access_token='.$this->tools->get_wechat_access_token().'&next_openid=');
        $data=json_decode($url,1);
        $last_info = [];
        foreach($data['data']['openid'] as $k=>$v){
            $user_info = file_get_contents('https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$this->tools->get_wechat_access_token().'&openid='.$v.'&lang=zh_CN');
            $user = json_decode($user_info,1);
            $last_info[$k]['nickname'] = $user['nickname'];
            $last_info[$k]['openid'] = $v;
        }
        return view('practise/user_tag',['info'=>$last_info]);
    }
//    根据openid群发消息
    public function send()
    {
        $openid=request()->input('openid');
        $content=request()->input('content');
        $url='https://api.weixin.qq.com/cgi-bin/message/mass/send?access_token='.$this->tools->get_wechat_access_token();
        $data=[
            'touser'=>$openid,
            'msgtype'=>'text',
            'text'=>[
                'content'=>$content
            ],
        ];
        $this->tools->curl_post($url,json_encode($data,JSON_UNESCAPED_UNICODE));
        return redirect('practise/user_tag');
    }


}
