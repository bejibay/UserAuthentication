<?php 
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Account Activation</title>
<meta name="description" content="Home Page">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="auth.css">

</head>
<body>
<div id="container">
<div class="row">
 <div class="col-12">
<h2>Account Activation</h2>
<h3><?php if(isset($activationResult)) echo $activationResult;?></h3>
</div>
</div>
<div class="footer">
&copy; copyright  ABC limited
</div>
<script src="auth.js"></script>
</div>
</body>

