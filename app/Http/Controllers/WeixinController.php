<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Redis;
use DB;
use App\Tools\Tools;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
class WeixinController extends Controller
{
    public $tools;
    public function __construct(Tools $tools)
    {
        $this->tools = $tools;
    }
//清除上线
    public function  clear_api(){
        $url = 'https://api.weixin.qq.com/cgi-bin/clear_quota?access_token='.$this->tools->tools->get_wechat_access_token();
        $data = ['appid'=>env('WECHAT_APPID')];
        $this->tools->curl_post($url,json_encode($data));
    }

//    下载素材
    public function sidebar(Client $client)
    {
        $id=request()->all();
        $res=DB::table('wechat_source')->where('id','=',$id)->first();
        $url='https://api.weixin.qq.com/cgi-bin/material/get_material?access_token='.$this->tools->get_wechat_access_token();
        $data=$this->tools->curl_post($url,json_encode(['media_id'=>$res->media_id]));
        if($res->type != 'video'){
            Storage::put('wechat/'.$res->type.'/'.$res->file_name,$data);
            DB::table('wechat_source')->where(['id'=>$id])->update([
                'path'=>'/storage/wechat/'.$res->type.'/'.$res->file_name,
            ]);
            dd('ok');
        }
        $result = json_decode($data,1);
        //设置超时参数
        $opts=array(
            "http"=>array(
                "method"=>"GET",
                "timeout"=>3  //单位秒
            ),
        );
        //创建数据流上下文
        $context = stream_context_create($opts);
        //$url请求的地址，例如：
        $read = file_get_contents($result['down_url'],false, $context);
        Storage::put('wechat/video/'.$res->file_name, $read);
        DB::table('wechat_source')->where(['id'=>$id])->update([
            'path'=>'/storage/wechat/'.$res->type.'/'.$res->file_name,
        ]);
        dd('ok');
        //Storage::put('file.mp3', $re);
    }
//    上传文件
    public function uplode()
    {
            return view('uplode/image');
    }
    public function uplode_do(Request $request , Client $client)
    {
        $type=request()->input('type');
        $name='form_data';
        if(request()->hasFile($name) && request()->file($name)->isValid())
        {
            $size = $request->file($name)->getClientSize() / 1024 / 1024;
//            图片
           if($type == 'image' && $size < 2){
               $ext = $request->file($name)->getClientOriginalExtension();  //文件类型
               $file_name = time().rand(1000,9999).'.'.$ext;
               $path = request()->file($name)->storeAs('wechat/'.$type,$file_name);
               $storage_path = '/storage/'.$path;
               $path = realpath('./storage/'.$path);
               $url = 'https://api.weixin.qq.com/cgi-bin/material/add_material?access_token='.$this->tools->get_wechat_access_token().'&type='.$type;
           }else if($type=='voice' && $size < 2){
//               语音
               $ext = $request->file($name)->getClientOriginalExtension();  //文件类型
               $file_name = time().rand(1000,9999).'.'.$ext;
               $path = request()->file($name)->storeAs('wechat/'.$type,$file_name);
               $storage_path = '/storage/'.$path;
               $path = realpath('./storage/'.$path);
               $url = 'https://api.weixin.qq.com/cgi-bin/material/add_material?access_token='.$this->tools->get_wechat_access_token().'&type='.$type;
           }else  if($type=='video' && $size < 10){
               $ext = $request->file($name)->getClientOriginalExtension();  //文件类型
//               视频
               $file_name = time().rand(1000,9999).'.'.$ext;
               $path = request()->file($name)->storeAs('wechat/'.$type,$file_name);
               $storage_path = '/storage/'.$path;
               $path = realpath('./storage/'.$path);
               $url = 'https://api.weixin.qq.com/cgi-bin/material/add_material?access_token='.$this->tools->get_wechat_access_token().'&type='.$type;
           }else  if($type=='thumb' && $size < 0.64){
               //           缩略图
               $ext = $request->file($name)->getClientOriginalExtension();  //文件类型
               $file_name = time().rand(1000,9999).'.'.$ext;
               $path = request()->file($name)->storeAs('wechat/'.$type,$file_name);
               $storage_path = '/storage/'.$path;
               $path = realpath('./storage/'.$path);
               $url = 'https://api.weixin.qq.com/cgi-bin/material/add_material?access_token='.$this->tools->get_wechat_access_token().'&type='.$type;
           }else{
               dd('文件类型过大或选择文件类型不正确');
           }
            if($type == 'video'){
                $title = '标题'; //视频标题
                $desc = '描述'; //视频描述
                $result = $this->tools->client_upload($url,$path,$client,1,$title,$desc);
            }else{
                $result=$this->tools->client_upload($url,$path,$client);
            }

            $re=json_decode($result,1);
            DB::table('wechat_source')->insert([
                'media_id'=>$re['media_id'],
                'type' => $type,
                'path' => $storage_path,
                'add_time'=>time()
            ]);
            return redirect('index/uplode_list');
        }
    }
//获取永久素材展示
    public function uplode_list(Client $client)
    {
        $type = request()->input('type');
//        $url = 'https://api.weixin.qq.com/cgi-bin/material/batchget_material?access_token='.$this->tools->get_wechat_access_token();
//        $data = [
//            'type' =>$type,
//            'offset' => 0,
//            'count' => 20
//        ];
//        $r = $client->request('POST', $url, [
//              'body' => json_encode($data)
//        ]);
//        $re = $r->getBody();
//        $res=json_decode($re);
//        $media_id_list = [];
//        foreach($res->item as $v){
//            $media_id=DB::table('wechat_source')->where('media_id','=',$v->media_id)->first();
//            if(empty($media_id)){
//                DB::table('wechat_source')->insert([
//                    'media_id'=>$v->media_id,
//                    'type' => $type,
//                    'add_time'=>$v->update_time,
//                    'file_name'=>$v->name
//                ]);
//            }
//            $media_id_list[] = $v->media_id;
//        }
//        微信
//        $source_info = DB::table('wechat_source')->whereIn('media_id',$media_id_list)->where('type','=',$type)->get();
//        数据库
        $source_info = DB::table('wechat_source')->where('type','=',$type)->get();

        return view('uplode/image_list',['info'=>$source_info,'type'=>$type]);
    }



    /**
     * 获取用户列表
     */
    public function get_user_list()
    {
        $tag_id=request()->input('id');

        $result = file_get_contents('https://api.weixin.qq.com/cgi-bin/user/get?access_token='.$this->tools->get_wechat_access_token().'&next_openid=');
        //dd($result);
        $re = json_decode($result,1);
        $last_info = [];
        foreach($re['data']['openid'] as $k=>$v){
            $user_info = file_get_contents('https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$this->tools->get_wechat_access_token().'&openid='.$v.'&lang=zh_CN');
            $user = json_decode($user_info,1);
            $last_info[$k]['nickname'] = $user['nickname'];
            $last_info[$k]['openid'] = $v;
        }
        //dd($last_info);
        foreach ($last_info as $v)
        {
            $res=DB::table('wechat_user')->where('open_id','=',$v['openid'])->first();
            if($res==''){
                DB::table('wechat_user')->insert([
                    'open_id'=>$v['openid'],
                    'nickname'=>$v['nickname']
                ]);
            }
        }
        return view('userList',['last_info'=>$last_info,'tag_id'=>$tag_id]);
    }
    /**
     * 获取access_token
     */
    public function get_access_token()
    {
        return $this->tools->get_wechat_access_token();
    }
//    获取token
}
