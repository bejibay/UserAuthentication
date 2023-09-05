<?php
session_start();
require_once __DIR__."/config/bootstrap.php";
require_once WORKING_DIRECTORY_PATH."/config/config.php";
require_once  WORKING_DIRECTORY_PATH."/src/model/data.php";
require_once WORKING_DIRECTORY_PATH."/src/controller/functions.php";
require_once WORKING_DIRECTORY_PATH."/route.php";

$requestUrl = $_SERVER['REQUEST_URI'];
$url = parse_url($requestUrl,PHP_URL_PATH);
$path = explode("/",$url);
if(isset($requestUrl)){  
foreach($routes as $route){
if(($route['pattern']) && preg_match($route['pattern'],$requestUrl,$matches)){
if(isset($route['methods']) && in_array($_SERVER['REQUEST_METHOD'],$route['methods'])){
if(isset($route['function']) && is_callable($route['function'])){
if($matches){call_user_func($route['function']);
}
}
}
}
}if(!$matches){call_user_func('notfound');}
}

?>