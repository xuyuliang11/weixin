<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Tools\Tools;
use DB;
class TagController extends Controller
{
    public $tools;
    public function __construct(Tools $tools)
    {
        $this->tools = $tools;
    }
//  标签列表
    public function tog_list()
    {

        $data=file_get_contents('https://api.weixin.qq.com/cgi-bin/tags/get?access_token='.$this->tools->get_wechat_access_token());
        $data=json_decode($data,1);

        return view('wechat.toglist',['info'=>$data['tags']]);
    }
//    粉丝添加视图
    public function tog_save()
    {
        return view('wechat.togadd');
    }
    public function tog_do()
    {
        $data=request()->all('name');
        $url='https://api.weixin.qq.com/cgi-bin/tags/create?access_token='.$this->tools->get_wechat_access_token();
        $res=$this->tools->curl_post($url,json_encode(['tag'=>$data],JSON_UNESCAPED_UNICODE));
        if($res){
            return redirect('index/tog_list');
        }
    }
//    修改用户标签
    public function tagup()
    {
        $id=request()->input('id');
        $name=request()->input('name');
        return view('wechat.togup',['id'=>$id,'name'=>$name]);
    }
    public function tagup_do()
    {
        $id=request()->input('id');
        $name=request()->input('name');
        $url='https://api.weixin.qq.com/cgi-bin/tags/update?access_token='.$this->tools->get_wechat_access_token();
        $res=$this->tools->curl_post($url,json_encode(['tag'=>['id'=>$id,'name'=>$name]],JSON_UNESCAPED_UNICODE));
        return redirect('index/tog_list');
    }
//    删除用户标签
    public function tagdel($id)
    {
        $url='https://api.weixin.qq.com/cgi-bin/tags/delete?access_token='.$this->tools->get_wechat_access_token();
        $res=$this->tools->curl_post($url,json_encode(['tag'=>['id'=>$id]],JSON_UNESCAPED_UNICODE));
        return redirect('index/tog_list');
    }
//  粉丝打标签
    public function tag_souer()
    {
        $openid_list=request()->input('openid_list');
        $tag_id=request()->input('tag_id');
        $url='https://api.weixin.qq.com/cgi-bin/tags/members/batchtagging?access_token='.$this->tools->get_wechat_access_token();
        $data=[
            'openid_list'=>$openid_list,
            'tagid'=>$tag_id
        ];
        $res=$this->tools->curl_post($url,json_encode($data));
        return redirect('index/tog_list');
    }
//    粉丝列表
    public function user_tag()
    {
        $tag_id=request()->input('id');
        $name=request()->input('name');
        $url='https://api.weixin.qq.com/cgi-bin/user/tag/get?access_token='.$this->tools->get_wechat_access_token();
        $data=[
          'tagid'=>$tag_id,
            'next_openid'=>''
        ];
        $res=$this->tools->curl_post($url,json_encode($data));
        $res=json_decode($res,1);
        return view('wechat/user_tag',['res'=>$res['data']['openid'],'name'=>$name]);
    }
    public function tag_send()
    {
        $tag_id=request()->input('id');
        return view('wechat.tag_send',['tag_id'=>$tag_id]);
    }
//    根据标签群发消息
    public function tag_send_do()
    {
        $tag_id=request()->input('tag_id');
        $text=request()->input('text');
//        获取标签下面的用户
        $url='https://api.weixin.qq.com/cgi-bin/user/tag/get?access_token='.$this->tools->get_wechat_access_token();
        $data=[
            'tagid'=>$tag_id,
            'next_openid'=>''
        ];
        $res=$this->tools->curl_post($url,json_encode($data));
        $res=json_decode($res,1);
//        群发消息
        $urlsend='https://api.weixin.qq.com/cgi-bin/message/mass/send?access_token='.$this->tools->get_wechat_access_token();
        $datasend=[
            'touser'=>$res['data']['openid'],
            'msgtype'=>'text',
            'text'=>[
                'content'=>$text
            ]
        ];
        $ressend=$this->tools->curl_post($urlsend,json_encode($datasend,JSON_UNESCAPED_UNICODE));
        return redirect('index/tog_list');
    }
//    获取用户下有哪些标签
        public function getidlist()
        {
            $openid=request()->input('id');
        
            $nickname=request()->input('nickname');
                // dd($nickname);
            $url='https://api.weixin.qq.com/cgi-bin/tags/getidlist?access_token='.$this->tools->get_wechat_access_token();
            $data=[
                'openid'=>$openid
            ];
            $res=$this->tools->curl_post($url,json_encode($data));
            $re=json_decode($res,1);
            // dd($re->tagid_list);
            $tagdata=file_get_contents('https://api.weixin.qq.com/cgi-bin/tags/get?access_token='.$this->tools->get_wechat_access_token());
            $tagdata=json_decode($tagdata,1);
            $tag_arr = [];
            // dd($tagdata);
            foreach ($tagdata['tags'] as $v)
            {
                $tag_arr[$v['id']] = $v['name'];
            }
            foreach($re['tagid_list'] as $v){
            echo $tag_arr[$v]."<br/>";
        }
            return view('wechat.getidlist',['re'=>$re]);
        }
//
        public function fomwork()
        {
//            $point=DB::table('wechat_user')->where(['open_id'=>'o5TRIs5L3naN6dSDtMwDTkjVsqlI'])->first();
//            $data=file_get_contents('https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$this->tools->get_wechat_access_token().'&openid=o5TRIs5L3naN6dSDtMwDTkjVsqlI&lang=zh_CN');
//            $data=json_decode($data);
//            if(empty($point)){
//                DB::table('wechat_user')->insert([
//                    'open_id'=>'o5TRIs5L3naN6dSDtMwDTkjVsqlI',
//                    'nickname'=>$data->nickname
//                ]);
//            }
//            $message='欢迎'.$data->nickname.'同学，感谢您的关注';
//            echo $message;
        }
}
