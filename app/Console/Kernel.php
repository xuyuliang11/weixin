<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use DB;
use Illuminate\Support\Facades\Log;
use App\Tools\Tools;
class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {

        $schedule->call(function(){
            $tools=new Tools();
            $data=DB::table('wechat_user')->get();
            $url='https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$tools->get_wechat_access_token();
            foreach($data as $v){
                if($v->or_sign==1){
                    $v->or_sign='未签到';
                }else{
                    $v->or_sign='已签到';
                }
                $array=[
                    'touser'=>$v->open_id,
                    'template_id'=>'TaKwcrDeSUqM365TbRbSxy67wbVzteYfPVuMQpsZmIU',
                    'data'=>[
                        'first'=>['value'=>'签到提醒'],
                        'keyword1'=>['value'=>$v->nickname],
                        'keyword2'=>['value'=>$v->or_sign],
                        'keyword3'=>['value'=>$v->points],
                        'keyword4'=>['value'=>$v->sign_time],
                    ]
                ];
                //$tools->curl_post($url,json_encode($array,JSON_UNESCAPED_UNICODE));
                DB::table('wechat_user')->where(['or_sign'=>2])->update([
                    'sign'=>'0'
                ]);
                DB::table('wechat_user')->update([
                    'or_sign'=>2,
                    'sign_time'=>'1'
                ]);
            }

            \Log::info('123');

        })->cron('* * * * *');
//        $schedule->call(function(){
//
//
//        })->cron('* * * * *');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
