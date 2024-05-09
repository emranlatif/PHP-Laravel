<?php
namespace app\controller;

use app\BaseController;
use think\facade\Db;
use ipregistry\Ipregistry;

class Index extends BaseController
{
    public function index()
    {
        //添加IP
        $ip=get_client_ip();
        session('ip',$ip);
        if(Db::Name('ipinfo')->where('ip',$ip)->count()==0){
            $time=time();
            $ipinfo['ip']=$ip;
            $ipinfo['time']=$time;
            $ipinfo['date']=date("Y-m-d",$time);
            Db::Name('ipinfo')->save($ipinfo);
        }
        return redirect("login");
    }
}
