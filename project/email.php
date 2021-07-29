<?php include('logic.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Password Reset PHP</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<form class="login-form" action="email.php" method="post">
		<h2 class="form-title">Reset password</h2>
		<!-- form validation messages -->
		
		<div class="form-group">
			<label>Your email address</label>
			<input type="email" name="email">
		</div>
		<div class="form-group">
			<button type="submit" name="reset-password" class="login-btn">Submit</button>
		</div>
	</form>
</body>
</html>