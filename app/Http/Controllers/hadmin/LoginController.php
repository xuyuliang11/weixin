<?php

namespace App\Http\Controllers\hadmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\model\wechat;
use App\Tools\Tools;
use DB;
class LoginController extends Controller
{
     public $tools;
    public $wechat;
    public function __construct(Tools $tools,wechat $wechat)
    {
        $this->tools=$tools;
    }


    //后台登录
    public function h_login()
    {
        return view('jiekou.h_login');
    }
    public function h_do_login()
    {
        $name=request('name');
        $password=request('password');
        //用户名错误 密码错误   用户名或密码错误
        $data=DB::table('user')->where(['name'=>$name,'password'=>$password])->first();
       // dd($data);
        if(!data){
            //报错登录失败
            die;
        }
        $data=$data->toArray();
        //登录成功 存到session
        session(['data'=>$data]);
        return redirect('hadmin/index');
    }

    public function send(request $request)
    {
        $req=$request->all();
//        dd($req);
        //接收用户名 密码
        $name=$request->input('name');
      // dd($name);
        $password=$request->input('password');
        //发送验证码 4位 6位
        $code=rand(1000,9999);
        $url = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$this->tools->get_wechat_access_token();
//        dd($url);
        //参数
        $data=[
            'touser'=>'oqhTrwEdspKuEFklacqNIEdr0vwg',
            'template_id'=>'i8xq4J7WH85keBRR9x_gXV8wbkd9dZjb3UnGYwbHyEc',
            'data'=>[
                'code'=>[
                    'value'=>$code,
                    'color'=>''
                ],
                'name'=>[
                    'value'=>$name,
                    'color'=>''
                ],
                'time'=>[
                    'value'=>time(),
                    'color'=>''
                ],


            ]
        ];
       // dd($data);
        $re=$this->tools->curl_post($url,json_encode($data,JSON_UNESCAPED_UNICODE));
        $result=json_decode($re,1);
        dd($result);
    }


    public function bdzh()
    {
        return view('login.bdzh');
    }
    public function do_bdzh(request $request)
    {
        $name = request('name');
        $password = request('password');
        // sdd($password);
        $adminInfo = DB::table('h_login')->where(['name'=>$name,'password'=>$password])->first();
        // dd($adminInfo);
        if(!$adminInfo){
            echo json_encode(['ret'=>0,'msg'=>'用户名或密码错误']);die;
        }
        $openid = wechat::getOpenid();
        DB::table('h_login')->where(['name'=>$name,'password'=>$password])->update([
            'openid'=>$openid
        ]);
        $adminInfo->openid = $openid;
//        $adminInfo->save();
        echo "<script>alert('绑定账号成功');location.href='h_login';</script>";
    }

}
