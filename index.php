<?php
session_start();
$requesturl ="";

//explode the incoming url
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

//swith the various urls for routing
switch ($requesturl){
case "/UserAuthentication/":
   homepage();
   break;
case "/UserAuthentication/register":
   signup();
   break;
case "/UserAuthentication/login":
    login();
   break;
case "/UserAuthentication/requestreset":
   requestForReset();
   break;
case "/UserAuthentication/adminboard":
      admin();
      break;
case "/UserAuthentication/logout":
   logout();
   break;
default:
otherurls();
}
?>

 

