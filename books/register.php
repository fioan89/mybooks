<?php ?>

<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

		<!-- Ubuntu font family-->
		<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
		<script src="http://crypto-js.googlecode.com/svn/tags/3.1.2/build/rollups/md5.js"></script>
		<script src="../js/registermanager.js"></script>

		<link href='http://fonts.googleapis.com/css?family=Ubuntu:500&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" type="text/css" href="../css3/basicformat.css"/>
		<link rel="stylesheet" type="text/css" href="../css3/bookstyle.css"/>
		<link rel="stylesheet" type="text/css" href="../css3/contact.css" />
		<title>Login to My Books</title>
	</head>
	<body>

		<div class="mainlogin">
			<label>First Name</label>
			<input id="fname_value" name="fname" type="text" placeholder="Type Here">
			<label>Last Name</label>
			<input id="lname_value" name="lname" type="text" placeholder="Type Here">
			<label>Email</label>
			<input id="email_value" name="email" type="email" placeholder="Type Here">

			<label>Password</label>
			<input id="password_value" name="password" type="password" placeholder="Type Here">
			<label>Retype Password</label>
			<input id="rpassword_value" name="rpassword" type="password" placeholder="Type Here">
			<span id="error_message" class = "error_message"></span>
			<br>
			<a href="./register.php">Don't have an account? Click here!</a>
			<input id="submituser" name="submit" type="submit" value="Sign In">
		</div>
		<div class = "copyright">
			<footer>
				&copy; Copyright  by Faur Ioan-Aurel
			</footer>
		</div>

	</body>
</html>
