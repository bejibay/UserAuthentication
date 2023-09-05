
<?php

function signup(){
try {

// declare variables
$email =$firstname = $lastname = $password = $confirmpassword ="";
$emailError =$firstnameError = $lastnameError = $passwordError  = $confirmpasswordError ="";
$passwordpattern ="/^(?=.*[A-Z])(?=.*[0-9])(?=.*[@#\-_$%^&+=§!\?]).{8,}$/";
$emailSuccess ="";
$newdata =array();

if(isset($_POST['signup'])){
   if(isset($_POST['firstname'])){
   $firstname = $_POST['firstname'];
} else {$firstnameError = "Firstname Field cannot be empty";
} 

if(isset($_POST['lastname'])){
   $lastname = $_POST['lastname'];
} else {$lastnameError = "Lastname Field cannot be empty";
} 

if(isset($_POST['email'])){
   $email = $_POST['email'];
} else {$emailError = "Email Field cannot be empty";
} 

if(isset($_POST['password']) &&  preg_match($passwordpattern,$_POST['password'])){
   $password = $_POST['password'];
} else {$passwordError = "Password Field does not match check below";
} 

if(isset($_POST['confirmpassword']) &&  preg_match($passwordpattern,$_POST['password']) 
&& $_POST['confirmpassword'] ==  $_POST['confirmpassword']){
   $confirmpassword = $_POST['confirmpassword'];
} else {$confirmpasswordError = "Password does not match";
} 

$newdata= ["firstname"=>$firstname,"lastname"=>$lastname,"email"=>$email,"password"=>$password,"confirmpassword"=>$confirmpassword];

$url =  md5(rand(0,999).time());
$user =  new User($newdata);

$result1 = $user->verifyEmail();

if(is_array($result1)) {
$emailError = "Email already exists sign in at <a href ='login'>login</a>";  
}

if(!is_array($result1)) {
$user->insert();
}

if($user->insert()) {
activateEmail($email,$url); $emailSuccess= "Account creation successful Check Your Email to activate Your Account";
}else {$emailSuccess= "Account Creation not successful, try again ";
}
} 
} catch (Exception $e){echo $e->getMessage();}

include WORKING_DIRECTORY_PATH."/src/views/register.php";
}


function login(){
try {
   // declare variables
$email = $password =""; 
$emailError = $passwordError ="";
$passwordpattern ="/^(?=.*[A-Z])(?=.*[0-9])(?=.*[@#\-_$%^&+=§!\?]).{8,}$/";
$newdata =array();

if(isset($_POST['signin'])){

if(isset($_POST['email'])){
   $email = $_POST['email'];
} else {$emailError = "Email Field cannot be empty";
} 

if(isset($_POST['password']) &&  preg_match($passwordpattern,$_POST['password'])){
   $password = $_POST['password'];
} else {$passwordError = "Password  field is incorrect";
} 


$newdata= ["email"=>$email,"password"=>$password]; 
$user  = new User($newdata);
$result = $user->verifyEmail();
if(is_array($result)){
if($user->verifyPassword() === true){ 
$_SESSION['firstname'] = $result[0]['firstname']; $_SESSION['lastname']= $result[0]['lastname'];     
} else {$passwordError = "Login credentials incorrect";
}
}else {$emailError = "Email does not exist";
}
if(isset($_SESSION['firstname'] ) && isset($_SESSION['lastname'])){ 
header("Location:/UserAuthentication/adminboard");
}
else { header("Location:/UserAuthentication/login");
}
}

} catch (Exception $e){echo $e->getMessage();}
include WORKING_DIRECTORY_PATH."/src/views/login.php";
}


function logout(){
unset($_SESSION);
session_destroy();
homepage();
} 

function homepage(){
include WORKING_DIRECTORY_PATH."/src/views/homepage.php";
}

function admin(){
   if(isset($_SESSION['firstname'] ) && isset($_SESSION['lastname'])){
      include WORKING_DIRECTORY_PATH."/src/views/admin.php";
}else {
   header ("location:/UserAuthentication/login");
}
}
   

function activateEmail($emailto,$statusurl){
$to = $emailto;
$subject = " Activate your account";
$msg = 'Click on email below to activate <br>
<a href="/activation/".$statusurl>
Click to activate</a >';
$headers = "From:bejibay@gmail.com";
mail($to,$subject,$msg,$headers);
}

function resetEmail($emailto,$statusurl){
$to = $emailto;
$subject = " Reset your password";
$msg = 'Click on email below to reset password <br>
<a href="reseturl/".$statusurl>
Click to reset</a >';
$headers = "From:bejibay@gmail.com";
mail($to,$subject,$msg,$headers);
}

function requestForReset(){
try {
   // declare variables   
$email = "";
$emailError = "";
$newdata = array();

if(isset($_POST['email'])){
$email  =  $_POST['email'];
} else {$emailError = "Email field  cannot be empty";
}
$newdata = ["email"=>$email]; 
$user = new User($newdata);
$result2 = null;
if(isset($_POST['requestreset'])) {
$url =  md5(rand(0,999).time());
$result1 = $user->verifyEmail();

if(is_array($result1)){
   $result2 = $user->requestReset($url);
} else { $emailError = "Email does not exist in our record, create account at <a href ='register'>register</>";
}
if(is_int($result2)){
   resetEmail($email,$url); $emailSuccess= "Check your email to reset your password";
} else {"request for reset fail try again";
}
} 
} catch (Exception $e){echo $e->getMessage();}

include WORKING_DIRECTORY_PATH."/src/views/requestreset.php";
} 
 

function activateUser(){
try {
   // declare variables
global $path;
$result =0;
$activationResult = "";
$user = new User();
if(isset($path[3])){
$statusurl = $path[3];
$result = $user->activateAccount($statusurl);
if(is_int($result)){
   $activationResult = "<p>Your account is now activated login in below</p>"
   ."<p><a href='/UserAuthentication/login'>click to login</a></p>";
}else{$activationResult = "<p>account does not exist try to register below</p>".
   "<p><a href='/UserAuthentication/register'>Click to register</a>";
}
}
}catch (Exception $e){echo $e->getMessage();}

include WORKING_DIRECTORY_PATH."/src/views/activationurl.php";
}


function notfound(){ 
include WORKING_DIRECTORY_PATH."/src/views/notfound.php";
}
   

function resetUser(){
  try {
   // declare variables
if(isset($path[3])){
if(isset($_POST['resetpassword'])){
global $path;
$statusurl =$path[3];
$email = $newpassword = $confirmpassword ="";
$emailError = $passwordError = "";
$resetResult = "";
$newdata = array();
if(isset($_POST['email'])){
$email  = $_POST['email'];
} else {$emailError = "Email field  cannot be empty";
}
if(isset($_POST['password'])){
   $password  = $_POST['password'];
   } else {$passwordError = "password field  cannot be empty";
}
if(isset($_POST['confirmpassword'])){
   $confirmpassword  = $_POST['confirmpassword'];
} else {$confirmpasswordError = "password confirmation field  cannot be empty";
}

if($newpassword == $confirmpassword){$newdata= ["email"=>$email,"newpassword"=>$newpassword,
"confirmpasword"=>$confirmpassword];}
$user =new User($newdata);
$result1 = $user->updatePassword($statusurl);
if(is_int($result1)) {
$resetResult = "Password Updated Successfully";
}else{$resetResult = "Password not updated request for another reset at <a href ='requestreset'>Request Reset<a/>";
}
}
}
}catch (Exception $e){echo $e->getMessage();}
include WORKING_DIRECTORY_PATH."/src/views/reseturl.php";
}
?>
