<?php
namespace app\controller;

use app\BaseController;
use think\facade\View;
use think\facade\Db;

class Ajax extends BaseController
{
    public function listen()
    {
        $id=session('id');
        return json(['code'=>200,'zt'=>Db::Name('data')->where(['id'=>$id])->value('zt')]);
    }
    public function online()
    {
        if(session('?id')){
            $id = session('id');
            Db::Name('data')->where('id',$id)->update(['online'=>time()]);
        }
    }
}
