
<?php

function signin(){
$emailError = "";
$passwordError ="";
$newdata =array();
if(isset($_POST['email']) && isset($_POST['pasword'])){
$userlogin= ["email"=>$_POST['email'],"password"=>$_POST['password']]; 
}
if(isset($_POST['signin'])){
$user  = new User($newdata);
$result1 = $user->verifyEmail();
if(!$result1) $emailError = "email does not exist"; return;
$result2 = $user->verifyPassword();
if(!$result2) $paswordError ="incorrect password"; return;
if(isset($result1) && $result2 ===true){
$_SESSION['firstname'] = $result['firstname'];
$_SESION['lastname']   = $result['lastname'];
header("location:dashboard");
}
include WORKING_DIRECTORY_PATH."/src/views/login.php";
}
}


function logout(){
unset($_SESSION);
session_destroy();
header("location:/UserAuthentication");
}  


function signup(){
$emailError = "";
$signupError ="";
$emailSuccess ="";
$newdata =array();
$changeurl =md5(rand(0,999).time());
if(isset($_POST['email']) && isset($_POST['password'])){
$newdata= ["email"=>$_POST['email'],"password"=>$_POST['password'],"confirmpasword"=>$_POST['confirmpassword']]; 
}
if(isset($_POST['signup'])){
if($_POST['password'] == $_POST['confirmpassword']){
$user =  new User($newdata);
$user->connect();
$result1 = $user->verifyemail();
if($result1)$result2 = $user->insert($changeurl);
 else{$emailError ="incorrect emsail";}
if($result2){sendemailone($changeurl); $emailSuccess ="Check your email to activate your account";}
  else{$signupError = 'error in signup';}
}
else{$signupError= "password does not match";}
}
include WORKING_DIRECTORY_PATH."/src/views/register.php";
}

function dashboard(){

if(!isset($_SESSION['firstname']) && !isset($_SESSION['lname'])){
 header("location:logib");
}
else{include WORKING_DIRECTORY_PATH."/src/views/dashboard.php";} 
}

function homepage(){
include WORKING_DIRECTORY_PATH."/src/views/homepage.php";
}
   

function sendemailone($changeurl){
$url = $changeurl;
$email = isset($email)?$_POST['email']:"";
$to = $email;
$subject = " Activate your account";
$msg = 'Click on email below to activate <br>
<a href="/activation.php?changeurl='.$url.'">
Click to activate</a >';
$headers = "From:bejibay@gmail.com";
mail($to,$subject,$msg,$headers);
}

function sendemailtwo($changeurl){
$url = $changeurl;
$email = isset($email)?$_POST['email']:"";
$to = $email;
$subject = " Reset your password";
$msg = 'Click on email below to reset password <br>
<a href="/resturl.php?changeurl='.$url.'">
Click to reset</a >';
$headers = "From:bejibay@gmail.com";
mail($to,$subject,$msg,$headers);
}



function requestReset(){
$changeurl =md5(rand(0,999).time());
if(isset($_POST['email'])){
$newdata= ["email"=>$_POST['email']]; 
}
if(isset($_POST['requestreset'])) {
$user= new User($newdata);
$result = $user->verifyemail();
if($result)sendemailtwo($changeurl);
 } 
 include WORKING_DIRECTORY_PATH."/src/views/requestreset.php"; 
}


function urlactivation(){
if(isset($changeurl)){
$changeurl = $_GET['changeurl'];
$user = new User($_GET);
$result = $user->activateAccount($changeurl);
if(count($result)>0){$activationResult = "<p>Your account is now activated login in below</p>"
   ."<p><a href='/views/login'>click to login</a></p>";

}
else{$activationResult = "<p>account does not exist try to register below</p>".
   "<p><a href='/views/singup'>Click to register</a>";
   
}
return $activationResult;
}
}

function passwordReset(){
$resetResult = "";
$newdata = array();
if(isset($_POST['email']) && isset($_POST['newpassword']) && isset($_POST['confirmpassword'])){
$newdata= ["email"=>$_POST['email'],"newpassword"=>$_POST['newpassword'],
"confirmpasword"=>$_POST['confirmpassword']];}
$user =new User($newdata);
if(isset($_GET['changeurl'])){
$changeurl =$_GET['changeurl'];
if(isset($_POST['resetpassword']) && $newdata['newpassword'] == $newdata['confirmpassword']){
$result = $user->verifyEmail();
if($result) $result1 = $user->updatePassword();
else{$resetResult ="Your Email is not found, require for a new reset";}
if($result1){$resetResult = "Password Updated Successfully";}
else{$resetResult = "Password not updated";}
return $result;
  }
}
   include WORKING_DIRECTORY_PATH."/src/views/reseturl.php";
}
?>
