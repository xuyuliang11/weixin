<?php

namespace App\Http\Controllers;

use App\Tools\Tools;
use Illuminate\Http\Request;
use DB;

class MenuController extends Controller
{
    public $tools;

    public function __construct(Tools $tools)
    {
        $this->tools = $tools;
    }

    public function menu_list()
    {
        echo 1111;
        $data = DB::table('menu')->get();
        return view('menu/list', ['data' => $data]);
    }

    public function create_menu()
    {
        $res = request()->all();
        if ($res['name2'] != "") {
            $res['button_type'] = "2";
        } else {
            $res['button_type'] = "1";
        }
        DB::table('menu')->insert([
            'name1' => $res['name1'],
            'name2' => $res['name2'],
            'type' => $res['type'],
            'event_value' => $res['event_value'],
            'button_type' => $res['button_type']
        ]);
        $this->menu();
    }
//菜单
    public function menu()
    {

        $data = [];
        $menu_list = DB::table('menu')->select(['name1'])->groupBy('name1')->get();
        foreach ($menu_list as $vv) {
            $menu_info = DB::table('menu')->where(['name1' => $vv->name1])->get();
            $menu = [];
            foreach ($menu_info as $v) {
                $menu[] = (array)$v;
            }
            $arr = [];
            foreach ($menu as $v) {
                if ($v['button_type'] == 1) { //普通一级菜单
                    if ($v['type'] == 'click') { //click
                        $arr = [
                            'type' => 'click',
                            'name' => $v['name1'],
                            'key' => $v['event_value']
                        ];
                    } elseif ($v['type'] == 'view') {//view
                        $arr = [
                            'type' => 'view',
                            'name' => $v['name1'],
                            'url' => $v['event_value']
                        ];
                    }
                } elseif ($v['button_type'] == 2) { //带有二级菜单的一级菜单
                    $arr['name'] = $v['name1'];
                    if ($v['type'] == 'click') { //click
                        $button_arr = [
                            'type' => 'click',
                            'name' => $v['name2'],
                            'key' => $v['event_value']
                        ];
                    } elseif ($v['type'] == 'view') {//view
                        $button_arr = [
                            'type' => 'view',
                            'name' => $v['name2'],
                            'url' => $v['event_value']
                        ];
                    }
                    $arr['sub_button'][] = $button_arr;
                }
            }
            $data['button'][] = $arr;
        }
        $url = 'https://api.weixin.qq.com/cgi-bin/menu/create?access_token=' . $this->tools->get_wechat_access_token();
        $res = $this->tools->curl_post($url, json_encode($data, JSON_UNESCAPED_UNICODE));
        dd($res);
    }
//微信删除一个菜单
    public function menu_del()
    {
        $id = request()->input('id');
        DB::table('menu')->where('id', '=', $id)->delete();
        $this->menu();
        return redirect('index/menu_list');
    }
//    微信获取地理位置
    public function location()
    {
        $url='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        $jsapi_ticket = $this->tools->get_wechat_jsapi_ticket();
        $timestamp = time();
        $nonceStr = rand(1000,9999).'suibian';
        $sign_str = 'jsapi_ticket='.$jsapi_ticket.'&noncestr='.$nonceStr.'&timestamp='.$timestamp.'&url='.$url;
        $signature = sha1($sign_str);
        return view('wechat.location',['nonceStr'=>$nonceStr,'timestamp'=>$timestamp,'signature'=>$signature]);

    }
}
