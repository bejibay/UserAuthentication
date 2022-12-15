
<?php
function signin(){
$emailError = "";
$passwordError ="";
$newdata =array();
if(isset($_POST['email']) && isset($_POST['password'])){
$newdata= ["email"=>$_POST['email'],"password"=>$_POST['password']]; 
}
$user  = new User($newdata);
if(isset($_POST['email']))$email = $_POST['email'];
if(isset($_POST['email']) && isset($_POST['password'])){
$passworddata =["email"=>$_POST['email'],"password"=>$_POST['password']];}
if(isset($_POST['signin'])){
$result1 = $user->verifyEmail($email);
if(!$result1)$emailError = "Email does not exist";
$result2 = $user->verifyPassword($passworddata);
if($result2 == false){$passwordError = "password is not correct";}
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
$email = array();
global $statusurl;
if(isset($_POST['firstname'])  && isset($_POST['lastname']) && isset($_POST['email']) && isset($_POST['password'])
&& isset($_POST['confirmpassword'])){
$newdata= ["firstname"=>$_POST['firstname'],"lastname"=>$_POST['lastname'],"email"=>$_POST['email'],
"password"=>$_POST['password'],"confirmpassword"=>$_POST['confirmpassword']]; 
}
$user =  new User($newdata);
$email = isset($_POST['email'])?$_POST['email']:"";
if(isset($_POST['signup'])){
$result1 = $user->verifyEmail($email);
if(isset($_POST['password']) && isset($_POST['confirmpassword']) && $_POST['password']== $_POST['confirmpassword']){
$result1 = $user->verifyEmail($email);
if(!$result1){$result2 = $user->insert($statusurl,$newdata);
   if($result2){activateEmail($statusurl);$emilSuccess= "Check Your Email to activate Your Account";}
 } 
  }
if($result1)$emailError ="Email akready exists" ;
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


}
   

function activateEmail($statusurl){
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

function resetEmail($statusurl){
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



function requestForReset(){
$newdata = array();
global $statusurl;
if(isset($_POST['email'])){
$newdata= ["email"=>$_POST['email']]; }
$user= new User($newdata);
if(isset($_POST['requestreset'])) {
$result1 = $user->verifyEmail($newdata);
if($result1){$result2 = $user->requestReset($statusurl,$newdata);
if($result2)requestEmail($statusurl);
$emailSuccess= "Check your email to reset your password";
}

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
$email = isset($_POST['email'])?$_POST['email']:"";
if(isset($path3)){
$statusurl =$path3;
if(isset($_POST['resetpassword']) && $newdata['newpassword'] == $newdata['confirmpassword']){
$result1 = $user->verifyEmail($email);
if($result1){$result12 = $user->updatePassword($statusurl,$newdata);
  if($result2)$resetResult = "Password Updated Successfully";
  else{$resetResult = "Password not updated";}
}
else{$emailError ="Your Email is not found, require for a new reset";}
}
}
include WORKING_DIRECTORY_PATH."/src/views/reseturl.php";
}
?>
