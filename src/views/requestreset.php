<?php 
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Request Password Reset</title>
<meta name="description" content="Home Page">
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
<h2>Request Password Reset</h2>
<h3><?php if(isset($emailSuccess)) echo $emailSuccess;?></h3>
<form action ="" method ="post">
<input type = "text" name ="email"  placeholder ="Enter Your Email eg john@gmail.com""> 
<input type = "submit" name ="requestreset"  value ="Request Password Reset"> 
<p class ="pbuttom">Already have an account <a href="login" class ="sign">Sign in</a>
<p class ="pbuttom">Don't have an account <a href="register" class ="sign">Sign up</a>
</form>
</div>
</div>
<div class="footer">
&copy; copyright  ABC limited
</div>
<script src="auth.js"></script>
</div>
</body>

