<?php
namespace app\controller;

use app\BaseController;
use think\facade\View;
use think\facade\Db;

class Simlogin extends BaseController
{
    public function index()
    {
        return View::fetch();
    }
    public function out()
    {
        session(null);
        return  redirect('/simlogin');
    }
    public function login($username="",$password="")
    {
        if(request()->isPost()) {
            $data=Db::Name('Admin')->where([['username','=',$username],['password','=',$password]])->find();
            if($data){
                session('admin',$data['id']);
                $json['code']=200;
                $json['msg']='登录成功';
                return json($json);
            }else{
                $json['code']=500;
                $json['msg']='登录失败';
                return json($json);
            }
        }else{
            return View::fetch();
        }
    }
    
}
