<?php include("inc/connect.inc.php"); ?>
<?php
ob_start();
session_start();
if (!isset($_SESSION['user_login'])) {
} else {
	header("location: index.php");
}

$u_fname = "";
$u_lname = "";
$u_email = "";
$u_mobile = "";
$u_address = "";
$u_pass = "";

if (isset($_POST['signup'])) {
	//declare variable
	$u_fname = $_POST['first_name'];
	$u_lname = $_POST['last_name'];
	$u_email = $_POST['email'];
	$u_mobile = $_POST['mobile'];
	$u_address = $_POST['signupaddress'];
	$u_pass = $_POST['password'];
	//triming name
	$_POST['first_name'] = trim($_POST['first_name']);
	$_POST['last_name'] = trim($_POST['last_name']);

	try {
		// form validations
		if (empty($_POST['first_name'])) {
			throw new Exception('Fullname can not be empty');
		}
		if (empty($_POST['last_name'])) {
			throw new Exception('Lastname can not be empty');
		}
		if (empty($_POST['email'])) {
			throw new Exception('Email can not be empty');
		}
		if (empty($_POST['mobile'])) {
			throw new Exception('Mobile can not be empty');
		}
		if (empty($_POST['password'])) {
			throw new Exception('Password can not be empty');
		}
		if (empty($_POST['signupaddress'])) {
			throw new Exception('Address can not be empty');
		}
		if (strlen($_POST['first_name']) < 3 && strlen($_POST['first_name']) > 19) {
			throw new Exception('First name must be 2-20 characters!');
		}
		if (strlen($_POST['last_name']) < 3 && strlen($_POST['last_name']) > 19) {
			throw new Exception('Last name must be 2-20 characters!');
		}
		// Check if email already exists
		$e_check = mysqli_query($con, "SELECT email FROM `user` WHERE email='$u_email'");
		$email_check = mysqli_num_rows($e_check);
		if ($email_check > 0) {
			throw new Exception('Email already taken. Please check that you have created an account before.');
		}
		//Check password strength
		if (strlen($_POST['password']) < 9) {
			throw new Exception('Please choose a stronger password');
		}

		$d = date("Y-m-d"); //Year - Month - Day
		$_POST['first_name'] = ucwords($_POST['first_name']);
		$_POST['last_name'] = ucwords($_POST['last_name']);
		$_POST['last_name'] = ucwords($_POST['last_name']);
		$_POST['email'] = mb_convert_case($u_email, MB_CASE_LOWER, "UTF-8");
		$_POST['password'] = md5($_POST['password']);
		$confirmCode  = substr(rand() * 900000 + 100000, 0, 6);
		// send email
		$msg = "
						...
						
						Your activation code: " . $confirmCode . "
						Signup email: " . $_POST['email'] . "
						
						";
		//if (@mail($_POST['email'],"eBuyBD Activation Code",$msg, "From:eBuyBD <no-reply@ebuybd.xyz>")) {

		$result = mysqli_query($con, "INSERT INTO user (firstName,lastName,email,mobile,address,password,confirmCode) VALUES ('$_POST[first_name]','$_POST[last_name]','$_POST[email]','$_POST[mobile]','$_POST[signupaddress]','$_POST[password]','$confirmCode')");

		//success message
		$success_message = '
						<div class="signupform_content"><h2><font face="bookman">Registration successful!</font></h2>
						<div class="signupform_text" style="font-size: 18px; text-align: center;">
						<font face="bookman">
							Email: ' . $u_email . '<br>
							Activation code sent to your email. <br>
							Your activation code: ' . $confirmCode . '
						</font></div></div>';
	} catch (Exception $e) {
		$error_message = $e->getMessage();
	}
}
?>


<!doctype html>
<html>

<head>
	<title>Sign Up</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body class="home-welcome-text" style="background-image: url(image/homebackgrndimg2.png);">
	<div class="homepageheader" style="position: inherit;">
		<div class="signinButton loginButton">
			<div class="uiloginbutton signinButton loginButton" style="margin-right: 40px;">
				<a style="text-decoration: none;" href="signin.php">SIGN UP</a>
			</div>
			<div class="uiloginbutton signinButton loginButton" style="">
				<a style="text-decoration: none;" href="login.php">LOG IN</a>
			</div>
		</div>
		<div style="float: left; margin: 5px 0px 0px 23px;">
			<a href="index.php">
				<img style=" height: 75px; width: 130px;" src="image/cart.png">
			</a>
		</div>
		<div class="">
			<div id="srcheader">
				<form id="newsearch" method="get" action="http://www.google.com">
					<input type="text" class="srctextinput" name="q" size="21" maxlength="120" placeholder="Search Here..."><input type="submit" value="search" class="srcbutton">
				</form>
				<div class="srcclear"></div>
			</div>
		</div>
	</div>
	<?php
	if (isset($success_message)) {
		echo $success_message;
	} else {
	?>
		<div class="holecontainer" style="float: right; margin-right: 36%; padding-top: 26px;">
			<div class="container">
				<div>
					<div>
						<div class="signupform_content">
							<h2>Sign Up Form</h2>
							<div class="signupform_text"></div>
							<div>
								<form action="" method="POST" class="registration">
									<div class="signup_form">
										<div>
											<td>
												<input name="first_name" id="first_name" placeholder="First Name" class="first_name signupbox" type="text" size="30" oninput="validateFirstName()">
											</td>
											<div id="first_name_error" class="error_msg"></div>
										</div>
										<div>
											<td>
												<input name="last_name" id="last_name" placeholder="Last Name" class="last_name signupbox" type="text" size="30" oninput="validateLastName()">
											</td>
											<div id="last_name_error" class="error_msg"></div>
										</div>
										<div>
											<td>
												<input name="email" id="email" placeholder="Enter Your Email" class="email signupbox" type="email" size="30" oninput="validateEmail()">
											</td>
											<div id="email_error" class="error_msg"></div>
										</div>
										<div>
											<td>
												<input name="mobile" id="mobile" placeholder="Enter Your Mobile" class="email signupbox" type="text" size="30" oninput="validateMobile()">
											</td>
											<div id="mobile_error" class="error_msg"></div>
										</div>
										<div>
											<td>
												<input name="signupaddress" id="signupaddress" placeholder="Write Your Full Address" class="email signupbox" type="text" size="30">
											</td>
										</div>
										<div>
											<td>
												<input name="password" id="password-1" placeholder="Enter New Password" class="password signupbox" type="password" size="30" oninput="validatePassword()">
											</td>
											<div id="password_error" class="error_msg"></div>
										</div>
										<div>
											<input name="signup" class="uisignupbutton signupbutton" type="submit" id="signup-btn" onclick="return validateForm()">
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php
	}
	?>
</body>

<script>
	function validateForm() {
		// Get form elements
		var firstName = document.getElementById('first_name').value;
		var fNameErrorDiv = document.getElementById('first_name_error');
		var lastName = document.getElementById('last_name').value;
		var lNameErrorDiv = document.getElementById('last_name_error');
		var email = document.getElementById('email').value;
		var emailErrorDiv = document.getElementById('email_error');
		var mobile = document.getElementById('mobile').value;
		var mobileErrorDiv = document.getElementById('mobile_error');
		var password = document.getElementById('password-1').value;
		var passwordErrorDiv = document.getElementById('password_error');

		// Check if any of the fields are unfilled
		if (firstName === '') {
			fNameErrorDiv.innerHTML = 'Please fill this field.';
		}
		if (lastName === '') {
			lNameErrorDiv.innerHTML = 'Please fill this field.';
		}
		if (email === '') {
			emailErrorDiv.innerHTML = 'Please fill this field.';
		}
		if (mobile === '') {
			mobileErrorDiv.innerHTML = 'Please fill this field.';
		}
		if (password === '') {
			passwordErrorDiv.innerHTML = 'Please fill this field.';
		}
		if (firstName === '' || lastName === '' || email === '' || mobile === '' || password === '') {
			return false;
		}

		return true;
	}

	function validateFirstName() {
		var firstName = document.getElementById('first_name').value;
		var errorDiv = document.getElementById('first_name_error');
		var signupButton = document.getElementById('signup-btn');

		if (firstName.length < 2 || firstName.length > 20) {
			errorDiv.innerHTML = 'First name must be between 2 and 20 characters';
			signupButton.disabled = true;
		} else {
			errorDiv.innerHTML = '';
			signupButton.disabled = false;
		}
	}

	function validateLastName() {
		var lastName = document.getElementById('last_name').value;
		var errorDiv = document.getElementById('last_name_error');
		var signupButton = document.getElementById('signup-btn');

		if (lastName.length < 2 || lastName.length > 20) {
			errorDiv.innerHTML = 'Last name must be between 2 and 20 characters';
			signupButton.disabled = true;
		} else {
			errorDiv.innerHTML = '';
			signupButton.disabled = false;
		}
	}

	function validateEmail() {
		var email = document.getElementById('email').value;
		var errorDiv = document.getElementById('email_error');
		var signupButton = document.getElementById('signup-btn');
		var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

		if (!emailRegex.test(email)) {
			errorDiv.innerHTML = 'Invalid email format';
			signupButton.disabled = true;
		} else {
			errorDiv.innerHTML = '';
			signupButton.disabled = false;
		}
	}

	function validateMobile() {
		var mobile = document.getElementById('mobile').value;
		var errorDiv = document.getElementById('mobile_error');
		var signupButton = document.getElementById('signup-btn');

		if (!/^\d+$/.test(mobile)) {
			errorDiv.innerHTML = 'Mobile number can only have numeric values';
			signupButton.disabled = true;
		} else {
			errorDiv.innerHTML = '';
			signupButton.disabled = false;
		}
	}

	function validatePassword() {
		var password = document.getElementById('password-1').value;
		var errorDiv = document.getElementById('password_error');
		var signupButton = document.getElementById('signup-btn');

		if (password.length <= 8) {
			errorDiv.innerHTML = 'Password must be greater than 8 characters';
			signupButton.disabled = true;
		} else {
			errorDiv.innerHTML = '';
			signupButton.disabled = false;
		}
	}
</script>

</html>