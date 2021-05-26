<?php

          session_name('mysession');
                   session_set_cookie_params(86400); 
                 
session_start();
if (isset($_GET['code'])) {
    $result = false;

    $params = array(
        'client_id'     => 'myid',
        'client_secret' => 'mysecret',
        'grant_type'    => 'authorization_code',
        'code'          => $_GET['code'],
        'redirect_uri'  => 'https://mysite.ru/google.php'
    );

$url = 'https://accounts.google.com/o/oauth2/token ';

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_POSTFIELDS, urldecode(http_build_query($params)));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
$result = curl_exec($curl);
curl_close($curl);

$tokenInfo = json_decode($result, true);
//var_dump($tokenInfo); die();
}
if (isset($tokenInfo['access_token'])) {
   
     $params = array(
        'format'       => 'json',
        'oauth_token'  => $tokenInfo['access_token']
    );
    $userInfo = json_decode(file_get_contents('https://www.googleapis.com/oauth2/v1/userinfo' . '?' . urldecode(http_build_query($params))), true);
//   var_dump($userInfo); die();
 if(isset($userInfo['email'])){$_SESSION['emailconfirmed']=$userInfo['email'];}
}

header('Location:https://mysite.ru');

?>