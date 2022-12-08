
<?php


function signin(){
$emailError = "";
$passwordError ="";
$newdata =array();
if(isset($_POST['email']) && isset($_POST['password'])){
$newdata= ["email"=>$_POST['email'],"password"=>$_POST['password']]; 
}
$user  = new User($newdata);
$result1 = $user->verifyEmail($newdata);
if(!$result1){$emailError = "Email does not exist";}
$result2 = $user->verifyPassword($newdata);
if($result2 == false){$passwordError = "password is not correct";}
if(isset($_POST['signin'])){
if($result1 && $result2 == true){
$_SESSION['firstname'] = $result1['firstname']; $_SESION['lastname']= $result1['lastname'];}
if(isset($_SESSION{'lastname'}) && isset($_SESION['lastname'])){header("location:dashboard");}
 else{header("location:login");}
}
include WORKING_DIRECTORY_PATH."/src/views/login.php";
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
global $statusurl;
if(isset($_POST['firstname'])  && isset($_POST['lastname']) && isset($_POST['email']) && isset($_POST['password'])
&& isset($_POST['confirmpassword']) && isset($_POST['created'])){
$newdata= ["firstname"=>$_POST['firstname'],"lastname"=>$_POST['lastname'],"email"=>$_POST['email'],
"password"=>$_POST['password'],"confirmpassword"=>$_POST['confirmpassword'], "created"=>$_POST['created']]; 
}
$user =  new User($newdata);
$result1 = $user->verifyemail($newdata);
if(!$result1){
 if(isset($_POST['signup'])){
   if(isset($_POST['password']) && isset($_POST['confirmpassword']) && $_POST['password']== $_POST['confirmpassword'])
   {$result2 = $user->insert($statusurl,$newdata);}
   if($result2){sendemailone($statusurl);$emilSuccess= "Check Your Email to activate Your Account";}
 } 
  }
  include WORKING_DIRECTORY_PATH."/src/views/register.php";
}

function dashboard(){

if(!isset($_SESSION['firstname']) && !isset($_SESSION['lname'])){
 header("location:login");
}
else{include WORKING_DIRECTORY_PATH."/src/views/dashboard.php";} 
}

function homepage(){
include WORKING_DIRECTORY_PATH."/src/views/homepage.php";
$data = "ilove";

}
   

function sendemailone($statusurl){
global $statusurl;
$url = $statusurl;
$email = isset($email)?$_POST['email']:"";
$to = $email;
$subject = " Activate your account";
$msg = 'Click on email below to activate <br>
<a href="/activation/".$url>
Click to activate</a >';
$headers = "From:bejibay@gmail.com";
mail($to,$subject,$msg,$headers);
}

function sendemailtwo($statusurl){
global $statusurl;
$url = $statusurl;
$email = isset($email)?$_POST['email']:"";
$to = $email;
$subject = " Reset your password";
$msg = 'Click on email below to reset password <br>
<a href="/reseturl/".$url>
Click to reset</a >';
$headers = "From:bejibay@gmail.com";
mail($to,$subject,$msg,$headers);
}



function requestReset(){
$changeurl =md5(rand(0,999).time());
$newdata = array();
if(isset($_POST['email'])){
$newdata= ["email"=>$_POST['email']]; }
$user= new User($newdata);
$result = $user->verifyemail($newdata);
if(isset($_POST['requestreset'])) {
if($result)sendemailtwo($changeurl);
 } 
 include WORKING_DIRECTORY_PATH."/src/views/requestreset.php"; 
}


function accountActivation(){
global $path3;
$result =0;
$activationResult = "";
$newdata = [];
$user = new User($newdata);

if(isset($path2)){
$changeurl = $path2;

$result = $user->activateAccount($changeurl);
if(count($result)>0){$activationResult = "<p>Your account is now activated login in below</p>"
   ."<p><a href='/UserAuthentication/login'>click to login</a></p>";

}
else{$activationResult = "<p>account does not exist try to register below</p>".
   "<p><a href='/UserAuthentication/singup'>Click to register</a>";
   }

}
include WORKING_DIRECTORY_PATH."/src/views/activationurl.php";
}


function otherurls(){
   global $path2;
   global $path3;
   if(isset($path2) && isset($path3) && $path2 =="activation"){
      accountActivation();
   }
   if(isset($path2) && isset($path3) && $path2 =="reseturl"){
      resetPassword();
   }

}
   

function resetPassword(){
global $path3;
$emailError = "";
$resetResult = "";
$newdata = array();
if(isset($_POST['email']) && isset($_POST['newpassword']) && isset($_POST['confirmpassword'])){
$newdata= ["email"=>$_POST['email'],"newpassword"=>$_POST['newpassword'],
"confirmpasword"=>$_POST['confirmpassword']];}
$user =new User($newdata);
$result = $user->verifyEmail($newdata);
if(!$result) $emailError = "email does not exist";
if(isset($path3)){
$statusurl =$path3;
if(isset($_POST['resetpassword']) && $newdata['newpassword'] == $newdata['confirmpassword']){
if($result) $result1 = $user->updatePassword($statusurl,$newdata);
else{$resetResult ="Your Email is not found, require for a new reset";}
if($result1){$resetResult = "Password Updated Successfully";}
else{$resetResult = "Password not updated";}
  }
}
   include WORKING_DIRECTORY_PATH."/src/views/reseturl.php";
}
?>
