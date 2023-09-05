<?php 

$routes = [
    ["pattern"=>"/^\/UserAuthentication\/$/",
    "methods"=>['GET','HEAD'],
    "function"=>"homepage"],
    ["pattern"=>"/^\/UserAuthentication\/register$/",
    "methods"=>['GET','POST','HEAD'],
    "function"=>"signup"],
    ["pattern"=>"/^\/UserAuthentication\/login$/",
    "methods"=>['GET','POST','HEAD'],
    "function"=>"login"],
    ["pattern"=>"/^\/UserAuthentication\/logout$/",
    "methods"=>['GET','HEAD'],
    "function"=>"logout"],
    ["pattern"=>"/^\/UserAuthentication\/requestreset$/",
    "methods"=>['GET','POST','HEAD'],
    "function"=>"requestForReset"],
    ["pattern"=>"/^\/UserAuthentication\/activate\/([a-z0-9]+)$/",
    "methods"=>['GET','HEAD'],
    "function"=>"activateUser"],
    ["pattern"=>"/^\/UserAuthentication\/reset\/([a-z0-9]+)$/",
    "methods"=>['GET','POST','HEAD'],
    "function"=>"resetUser"],
    ["pattern"=>"/^\/UserAuthentication\/adminboard$/",
    "methods"=>['GET','HEAD'],
    "function"=>"admin"]
    ];

?>
 

 