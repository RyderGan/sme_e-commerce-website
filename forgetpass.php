<!DOCTYPE html>
<html>
<head>
	<title>Password Recover</title>
	<link rel="icon" href="image/icon.png" type="image/x-icon">
	<meta charset="uft-8">
	<link rel="stylesheet" type="text/css" href="./css/style.css">
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<body style="background-color: #F5F5F5">
	<div class="homepageheader">
		<div class="signupButton loginButton">
			<div class="uiloginbutton signupButton loginButton" style="margin-right: 40px;">
				<a style="text-decoration: none; color: #fff;" href="signup.php">Sign Up</a>
			</div>
			<div class="uiloginbutton signupButton loginButton" >
				<a style="text-decoration: none; color: #fff;" href="login.php">Log In</a>
			</div>
		</div>
		<div style="float: left; margin: 5px 0px 0px 23px;">
			<a href="index.php">
				<img class="icon" src="image/icon.png">
			</a>
		</div>
	</div>
	<div  class="findAccount">
		<div class="loginform_content">
			<h2>Find Account</h2>
			<form action="" method="POST">
				<input style="width: 100%;" type="text" name="username" class="signupbox" placeholder="Write  Email..." size="30" required autofocus>
				<input class="uisignupbutton signupbutton" type="submit" name="searchId" id="senddata" value="Search">
			</form>
		</div>
	</div>
</body>
</html>
