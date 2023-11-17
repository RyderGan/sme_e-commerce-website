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
			throw new Exception('Full Name can not be empty');
		}
		if (empty($_POST['last_name'])) {
			throw new Exception('Last Name can not be empty');
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
						<div class="signupform_content">
							<h2>Registration Successfull</h2>
							<div style="font-size: 18px; text-align: center;">
								<p class="activation-header">Activation code sent to your email</p>
								<p class="activation-field">Email</p>
								<p class="activation-value">' . $u_email . '</p>
								<p class="activation-field">Your activation code</p>
								<p class="activation-value">' . $confirmCode . '</p>
							</div>
						</div>';
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

<body class="home-welcome-text" style="background-color: #F5F5F5">
	<div class="homepageheader" style="position: inherit;">
		<div class="signinButton loginButton">
			<div class="uiloginbutton signinButton loginButton" style="margin-right: 40px;">
				<a style="text-decoration: none; ; color: #fff;" href="login.php">Log In</a>
			</div>
			<div style="float: left; margin: 5px 0px 0px 23px;">
				<a href="index.php">
					<img class="icon" src="image/icon.png">
				</a>
			</div>
			<?php
			if (isset($success_message)) {
				echo $success_message;
			} else {
				echo '
					<div  style="float: right; margin-right: 36%;">
						<div class="signupform_content">
							<h2>Sign Up Form</h2>
							<form action="" method="POST" class="registration">
								<div class="signup_form">
									<div>
										<td >
											<input name="first_name" id="first_name" placeholder="First Name" required="required" class="first_name signupbox" type="text" size="30" value="' . $u_fname . '" >
										</td>
									</div>
									<div>
										<td >
											<input name="last_name" id="last_name" placeholder="Last Name" required="required" class="last_name signupbox" type="text" size="30" value="' . $u_lname . '" >
										</td>
									</div>
									<div>
										<td>
											<input name="email" placeholder="Enter Your Email" required="required" class="email signupbox" type="email" size="30" value="' . $u_email . '">
										</td>										
									</div>
									<div>
										<td>
											<input name="mobile" placeholder="Enter Your Mobile" required="required" class="email signupbox" type="text" size="30" value="' . $u_mobile . '">
										</td>
									</div>
									<div>
										<td>
											<input name="signupaddress" placeholder="Write Your Full Address" required="required" class="email signupbox" type="text" size="30" value="' . $u_address . '">
										</td>
									</div>
									<div>
										<td>
											<input name="password" id="password-1" required="required"  placeholder="Enter New Password" class="password signupbox " type="password" size="30" value="' . $u_pass . '">
										</td>
									</div>
									<div>
										<input name="signup" class="uisignupbutton signupbutton" type="submit" value="Sign Me Up!">
									</div>
									<div class="signup_error_msg">';

				if (isset($error_message)) {
					echo $error_message;
				}


				echo '</div>
								</div>
							</form>
						</div>
					</div>
				';
			}

			?>
		</div>
	</div>
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