<?php 
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Login Page</title>
<meta name="description" content="login page">
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
 <div class="col-6">
<form action ="" method ="post">
<h2>Sign In</h2>

<div>
<label for="email">Email:<?php echo $emailError; ?></label>
<div>

  <div>
<input type="text" id="email" name="email" placeholder="johndoe@gmail.com" required>
<i class ="fa fa-envelope icona"></i>
</div>

<div>
<label for="password">Password:<?php  echo $passwordError;?></label>
</div>

<div>
<input type="text"  id="password" name="password" placeholder="Enter your password" required>
<i class ="fa fa-key icona"></i>
</div>

<p><input type="submit" name="signin" value="Sign In"></p>
</form>

<p>Don't have an account <a href="register" class ="sign">Sign up</a>
<p>Forget password <a href="requestreset" class ="sign">Request Password Reset</a>
</div>
</div>
</div>

<div class="footer">
&copy; copyright  ABC limited"
</div>
<script src="auth.js"></script>
</div>
</body>
</html>
