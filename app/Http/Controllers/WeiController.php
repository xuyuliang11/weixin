<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tools\Tools;
use DB;
class WeiController extends Controller
{
      public $tools;

    public function __construct(Tools $tools)
    {
        $this->tools = $tools;
    }
    public function wei_list()
    {
        $data = DB::table('user_weixin')->get();
        return view('list', ['data' => $data]);
    }
    public function wei()
    {
    	  $url = 'https://api.weixin.qq.com/cgi-bin/menu/create?access_token=' . $this->tools->get_wechat_access_token();

        dd($url);
    }
}
