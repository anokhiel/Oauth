<?php

          session_name('mysession');
                   session_set_cookie_params(86400);
             
session_start();
if(isset($_GET['code'])){
$tokenInfo=  json_decode(file_get_contents('https://graph.facebook.com/v10.0/oauth/access_token?client_id=myid&redirect_uri=https://mysite.ru/fb.php&client_secret=mysecret&code='.$_GET['code']),true);
 if (count($tokenInfo) > 0 && isset($tokenInfo['access_token'])) {
        $params = array('access_token' => $tokenInfo['access_token'],'fields'=>'email');

        $userInfo = json_decode(file_get_contents('https://graph.facebook.com/me' . '?' . urldecode(http_build_query($params))), true);
        if (isset($userInfo['id'])) {
            $userInfo = $userInfo;
            $result = true;
        }
    }
   
   $_SESSION['emailconfirmed']=$userInfo['email']; 
}
header('Location:https://mysite.ru');

?>