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

</head>
<body>
<div id="container">
<div class="row">
 <div class="col-12">
<h2>Request Password Reset</h2>
<h3><?php if(isset($emailSuccess)) echo $emailSuccess;?></h3>
<form action ="" method ="post">
<input type = "text" name ="email"  placeholder ="Enter Your Email eg john@gmail.com""> 
<input type = "submit" name ="requestreset"  value ="Request Password Reset"> 
</form>
</div>
</div>
<div class="footer">
&copy; copyright  ABC limited
</div>
<script src="auth.js"></script>
</div>
</body>

