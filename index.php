<?php
session_start();
$firtname = isset($firstname) ? $_SESSION['firstname'] : "";
$lastname = isset($lastname) ? $_SESSION['lastname'] : "";
?>
<?php


require_once "config/bootstrap.php";
require_once WORKING_DIRECTORY_PATH."/config/config.php";
require_once  WORKING_DIRECTORY_PATH."/src/model/data.php";
require_once WORKING_DIRECTORY_PATH."/src/controller/functions.php";

$action = isset($action)? $_GET['action'] : "";
switch ($action){
case "":
homepage();
break;
case "login":
   signin();
  break;
case "register":
    register();
   break;
case "logout":
   logout();
  break;
case "urlactivation":
   urlactivation();
  break;
case "dashboard":
   dashboard();
  break;
default:
urlActivation();
paswordReset();
 
}
?>

 

