<?php
session_start();
$statusurl = md5(rand(0,999).time());
$requesturl ="";


if(isset($_SERVER['REQUEST_URI'])){
$requesturl = $_SERVER['REQUEST_URI'];
}
$path = explode('/',$requesturl);

if(isset($path[2])){$path2 = $path[2];}
if(isset($path[3])){$path3 = $path[3];}

require_once "config/bootstrap.php";
require_once WORKING_DIRECTORY_PATH."/config/config.php";
require_once  WORKING_DIRECTORY_PATH."/src/model/data.php";
require_once WORKING_DIRECTORY_PATH."/src/controller/functions.php";

switch ($requesturl){
   case "/":
      homepage();
break;
case "/UserAuthentication/":
   homepage();
break;
case "/UserAuthentication/login":
   signin();
   break;
case "/UserAuthentication/register":
    signup();
   break;
case "/UserAuthentication/requestreset":
   requestReset();
  break;
case "/UserAuthentication/logout":
   logout();
  break;
case "/UserAuthentication/dashboard":
   dashboard();
  break;
default:
otherurls();
}



?>

 

