<?php
session_start();
$_SESSION['fname'] = isset($_SESSION['fname']) ? $_SESSION['fname'] : "";
$_SESSION['lname'] = isset($_SESSION['lname']) ? $_SESSION['lname'] : "";
?>
<?php


require_once "config/bootstrap.php";
require_once WORKING_DIRECTORY_PATH."/config/config.php";
require_once  WORKING_DIRECTORY_PATH."/src/model/data.php";
require_once WORKING_DIRECTORY_PATH."/src/controller/functions.php";

$action = isset($_GET['action']) ? $_GET['action'] : "";
switch ($action){
case "login":
   signin();
  break;
case "logout":
   logout();
  break;
case "urlactivation":
   urlactivation();
  break;
case "dashboard":
   dashboard());
  break;
default:
 homepage();
}
?>

 

