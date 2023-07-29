<?php 
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Create An Account</title>
<meta name="description" content="Create An Account">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="auth.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<div id="container">
<div class="topnav">
<div id="mytopnav">
  <a href="#">About</a>
  <a href="#">Contact</a>
 </div>
<a href="javascript:void(0);" class="icon" onclick="displayIcon()"><i class="fa fa-bars"></i></a>
</div>
<div class="row">
 <div class="col-12">
<form action ="" method ="post">
<h2>Create Account</h2>
<p><?php if(isset($emailSuccess)) echo $emailSuccess;?></p>
<label for="firstname" class="userlogin">Firstname</label>
<label for="lastname" class="userlogin">Lastname</label>
<div>
<input type="text" class="userlogin" id="firstname" name="firstname" placeholder=" eg John" required>
<i class ="fa fa-user icona"></i>
</div>
<div>
<input type="text" class="userlogin" id="lastname" name="lastname" placeholder="eg Doe" required>
<i class ="fa fa-user icona"></i>
</div>
<label for="email" class="userlogin">Email:<?php echo $emailError;?></label>
<div class ="userlogin">
<input type="text" class="userlogin" id="email" name="email" placeholder="eg johndoe@gmail.com" required>
<i class ="fa fa-envelope icona"></i>
</div>
<label for="password" class="userlogin">Password:</label><?php if(isset($passwordError)) echo $passwordError;?>
<label for="confirmpassword" class="userlogin">Confirmpassword:</label><?php if(isset($confirmpasswordError)) echo $confirmpasswordError;?>
<div class ="userlogin">
<input type="text" class ="userlogin" id="password" name="password" placeholder="password" required>
<i class ="fa fa-key icona"></i>
</div>
<div class ="userlogin">
<input type="text" class ="userlogin" id="confirmpassword" name="confirmpassword" placeholder="password" required>
<i class ="fa fa-key icona"></i>
</div>
<input type ="radio">Contains at least one Upper case Letter<br>
<input type ="radio">Contains at least one special character<br>
<input type ="radio">Contains at least one number<br>
<input type ="radio">Mimimum of eight characters<br>
<input type ="radio">Passwords are matching
<input type="submit" name="signup" value="Sign Up">
</form>
<p class ="pbuttom">Already have an account <a href="/UserAuthentication/login2" class ="sign">Sign in</a>
</div>
</div>
<div class="footer">
&copy; copyright  ABC limited"
</div>
<script src="auth.js"></script>
</div>
</body>
</htm
