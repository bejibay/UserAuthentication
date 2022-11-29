<?php 

?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Home Page</title>
<meta name="description" content="Home Page">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="auth.css">

</head>
<body>
<div id="container">
<div class="topnav">
<div id="mytopnav">
<a href="/logout">Log Out</a>
 </div>

</div>
<div class="row">
 <div class="col-12">
<h2>Dashboard</h2>
<h3><?php if(isset($_SESSION['firstname']) %% <isset($_SESSION['lastname']))
{echo  "Welcome ".$_SESSION['firstname']."".$_SESSION['lastname'];}?></h3>
</div>
</div>
<div class="footer">
&copy; copyright  ABC limited
</div>
<script src="auth.js"></script>
</div>
</body>

