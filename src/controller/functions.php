
<?php

 function signin(){
   $emailError = "";
   $passwordError ="";
   include WORKING_DIRECTORY_PATH."/src/views/signin.php";
if(isset($_POST['signin'])){
   $user  = new User($_POST);
   $user->verifyEmail();
   if(!$emailResult) {$emailError = "Email Does not Exist"; return  $emailError;}
   $user->verifypassword();
   if(!$pswResult) {$passwordError = "Incorret password"; return $passwordError; }
   if($pswResult) {$_SESSION['lname'] = $pswResult['firstname'];  $_SESSION['fname'] = $pswResult['lastname']; 
    header("location:/views/dashboard");}}
if(isset($_POST['cancel'])) {include WORKING_DIRECTORY_PATH."/src/views/signin.php";}
 }


function logout(){
    unset($_SESSION);
    session_destroy();
      header("Location:/src/views/homepage.php");
    }  


function signup(){
   include WORKING_DIRECTORY_PATH."/src/views/signup.php"; 
if(isset($_POST['signup'])){
   $emailError = "";
   $signupError ="";
$user =  new User($_POST);
$user->verifyemail();
if(!$resultEmail){$emailError ="Email does not exist";return $emailError;}
$user->connect();
$user->insert();
if($successinsert){sendemail();}
if(!$successinsert){$signupError = "account not created try again"; return $signupError;}
}

}

function dashboard(){

   if(isset($_SESSION['lname']) && isset($_SESSION['lname'])){
   include WORKING_DIRECTORY_PATH."/src/views/dashboard.php";
   }
}

function homepage(){
   include WORKING_DIRECTORY_PATH."/src/views/homepage.php";
}
   

function sendemail(){
//generate activation URL
//send activation email
$EmailSuccess = 0;
$changeurl =md5(rand(0,999).time());
if(isset($register)){
$register = $_POST['register'];
$to = $_POST['email'];
$subject = " Activate your account";
$msg = 'Click on email below to activate <br>
<a href="/activation.php?changeurl='.$changeurl.'">
Click to activate</a >';
$headers = "From:bejibay@gmail.com";
if(mail($to,$subject,$msg,$headers)) $EmailSuccess = " check your email to activate your account";}
elseif(isset($requestpasswordreset)){
$requestpasswordreset = $_POST['requestpasswordreset'] ;
$to = $_POST['email'];
$subject = " Reset your password";
$msg = 'Click on email below to reset password <br>
<a href="/resturl.php?changeurl='.$changeurl.'">
Click to reset</a >';
$headers = "From:bejibay@gmail.com";
if(mail($to,$subject,$msg,$headers)) $EmailSuccess = " check your email to reset your account";}
return $EmailSuccess;

else{return false;}  
}


function requestpasswordreset(){
   include WORKING_DIRECTORY_PATH."/src/views/requestreset.php";
 if(isset($_POST['requestpasswordreset'])) {
   $user= new User($_POST);
   $user->verifyemail();
   sendemail();
 }  
}


function urlactivation(){
   include WORKING_DIRECTORY_PATH."/src/views/activationurl.php";
   $activationResult = 0;
   if(isset($changeurl)){
   $changeurl = $_GET['changeurl'];
$user = new User($_POST);
$user->activateaccount();
if(count($result)>0){$activationResult = "<p>Your account is now activated login in below</p>"
   ."<p><a href='/views/login'>click to login</a>";

}
else{$activationResult = "<p>account does not exist try to register below</p>".
   "<p><a href='/views/singup'>Click to register</a>";
   
}
return $activationResult;
}
}

function passwordreset(){
   include WORKING_DIRECTORY_PATH."/src/views/reseturl.php";
   $resetResult = 0;
   if(isset($_GET['changeurl'])){
  $changeurl =$_GET['changeurl'];
  if(isset($_POST['resetpassword]')){
   $user =new User($_POST);
   $user->verifyemail();
   $user->resetaccountstatus();
   if($result){$resetResult = "Password Updated";}
   else{$result = "Password not updated";}
   return $result;
  }

   }
}
?>
