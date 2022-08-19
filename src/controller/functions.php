
<?php

 function signin(){
   $emailError = "";
   $passwordError ="";
   include WORKING_DIRECTORY_PATH."/src/views/signin.php";
if(isset($_POST['signin'])){
   $user  = new User();
   $user->verifyEmail($_POST['email']);
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

if(isset($_POST['signup'])){
   $mailError = "";
   $signupError ="";
include WORKING_DIRECTORY_PATH."/src/views/signup.php"; 
$user =  new User();
$user->verifyemail();
if(!$resultEmail){$emailError ="Email does not exist";return $emailError;}
$user->__construct($_POST);
$user->connect();
$user->insert();
if($successinsert){sendemail();}
if(!$successinsert){$signupError = "account not created try again"; return;}
}

}

function dashboard($lname,$fname){

   if(isset($fname) && isset($lname)){$lname = $_SESSION['lname']; $fname= $_SESSION['fname'];
   include WORKING_DIRECTORY_PATH."/src/views/dashboard.php";
   }
}

function homepage(){
   include WORKING_DIRECTORY_PATH."/src/views/homepage.php";
}
   

function sendemail(){
//generate activation URL
//send activation email
$activationurl =md5(rand(0,999).time());
$to = $_POST['email'];
$subject = " Activate your account";
$msg = 'Click on email below to activate <br>
<a href="/activation.php?activationurl='.$activationurl.'">
Click to activate</a >';
$headers = "From:bejibay@gmail.com";
if(mail($to,$subject,$msg,$headers)) $EmailSuccess = " check your email to activate your account";
return $EmailSuccess;
}


function urlactivation(){
   

$user = new User();
$user->activateaccount($_GET['activationurl']);
if(count($result)>0){$acctivationSuccess = "<p>Your account is now activated login in below</p>"
   ."<p><a href='/views/login'>click to login</a>";

}
else{$activationError = "<p>account does not exist try to register below</p>".
   "<p><a href='/views/singup'>Click to register</a>";
   
}
include WORKING_DIRECTORY_PATH."/src/views/activationurl.php";
}
?>
