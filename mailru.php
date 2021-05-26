<?php

          session_name('mysession');
                   session_set_cookie_params(86400); 
                 //  $droot= str_replace('/', SLASH, $_SERVER['DOCUMENT_ROOT']);
//ini_set('session.save_path', $droot .SLASH.'protected'.SLASH.'sessions'.SLASH);
session_start();
if (isset($_GET['code'])) {
    $result = false;

    $params = array(
        'client_id'     => 'myid',
        'client_secret' => 'mysecret',
        'grant_type'    => 'authorization_code',
        'code'          => $_GET['code'],
        'redirect_uri'  => 'https://mysite/mailru.php'
    );

    $url = 'https://connect.mail.ru/oauth/token';
}
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_POSTFIELDS, urldecode(http_build_query($params)));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
$result = curl_exec($curl);
curl_close($curl);

$tokenInfo = json_decode($result, true);

if (isset($tokenInfo['access_token'])) {
    $sign = md5("app_id=783760method=users.getInfosecure=1session_key={$tokenInfo['access_token']}09620c428ed2d0ca42ce583b78d67fc0");

    $params = array(
        'method'       => 'users.getInfo',
        'secure'       => '1',
        'app_id'       => '783760',
        'session_key'  => $tokenInfo['access_token'],
        'sig'          => $sign
    );
    $userInfo = json_decode(file_get_contents('http://www.appsmail.ru/platform/api' . '?' . urldecode(http_build_query($params))), true);
    
 if(isset($userInfo[0]['email'])){$_SESSION['emailconfirmed']=$userInfo[0]['email'];}
}

header('Location:https://mysite.ru');

?>