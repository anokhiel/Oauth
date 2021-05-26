<?php

          session_name('mysession');
                   session_set_cookie_params(86400); 
                 //  $droot= str_replace('/', SLASH, $_SERVER['DOCUMENT_ROOT']);
//ini_set('session.save_path', $droot .SLASH.'protected'.SLASH.'sessions'.SLASH);
session_start();
if(isset($_GET['code'])){
 $rar=  json_decode(file_get_contents('https://oauth.vk.com/access_token?client_id=myid&client_secret=mysecret&redirect_uri=https://mysite.ru/vk.php&code='.$_GET['code']),true);
   if(isset($rar['email'])){$_SESSION['emailconfirmed']=$rar['email'];}
}
header('Location:https://mysite.ru');

?>