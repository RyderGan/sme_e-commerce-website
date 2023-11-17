<?php 

include("inc/connect.inc.php");

ob_start();
session_start();
if (!isset($_SESSION['user_login'])) {
	header("location: login.php");
} else {
	$user = $_SESSION['user_login'];
	$result = mysqli_query($con, "SELECT * FROM user WHERE id='$user'");
	$get_user_email = mysqli_fetch_assoc($result);
	$uname_db = $get_user_email['firstName'];
	$uemail_db = $get_user_email['email'];
	$upass = $get_user_email['password'];

	$umob_db = $get_user_email['mobile'];
	$uadd_db = $get_user_email['address'];
}

if (isset($_REQUEST['uid'])) {

	$user2 = mysqli_real_escape_string($con, $_REQUEST['uid']);
	if ($user != $user2) {
		header('location: index.php');
	}
} else {
	header('location: index.php');
}

if (isset($_POST['changesettings'])) {
	//declere veriable
	$email = $_POST['email'];
	$opass = $_POST['opass'];
	$npass = $_POST['npass'];
	$npass1 = $_POST['npass1'];
	//triming name
	try {
		if (empty($_POST['email'])) {
			throw new Exception('Email can not be empty');
		}
		if (isset($opass) && isset($npass) && isset($npass1) && ($opass != "" && $npass != "" && $npass1 != "")) {
			if (md5($opass) == $upass) {
				if ($npass == $npass1) {
					$npass = md5($npass);
					mysqli_query($con, "UPDATE user SET password='$npass' WHERE id='$user'");
					$success_message = '
						<div class="signupform_text" style="font-size: 18px; text-align: center;">
						<font face="bookman">
							Password changed.
						</font></div>';
				} else {
					$success_message = '
						<div class="signupform_text" style=" color: red; font-size: 18px; text-align: center;">
						<font face="bookman">
							New password not matched!
						</font></div>';
				}
			} else {
				$success_message = '
					<div class="signupform_text" style=" color: red; font-size: 18px; text-align: center;">
					<font face="bookman">
						Fillup password field exactly.
					</font></div>';
			}
		} else {
			$success_message = '
					<div class="signupform_text" style=" color: red; font-size: 18px; text-align: center;">
					<font face="bookman">
						Fillup password field exactly.
					</font></div>';
		}

		if ($uemail_db != $email) {
			if (mysqli_query($con, "UPDATE user SET  email='$email' WHERE id='$user'")) {
				//success message
				$success_message = '
					<div class="signupform_text" style="font-size: 18px; text-align: center;">
					<font face="bookman">
						Settings change successfull.
					</font></div>';
			}
		}
		header("Refresh:0");
	} catch (Exception $e) {
		$error_message = $e->getMessage();
	}
}


?>

<!DOCTYPE html>
<html>

<head>
	<title>Settings</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body >
	<div class="homepageheader" style="position: relative;">
		<div class="signinButton loginButton">
			<div class="uiloginbutton signinButton loginButton" style="margin-right: 40px;">
				<?php
				if ($user != "") {
					echo '<a style="text-decoration: none; color: #fff;" href="logout.php">Log Out</a>';
				} else {
					echo '<a style="text-decoration: none; color: #fff;" href="signin.php">Sign Up</a>';
				}
				?>

			</div>
			<div class="uiloginbutton signinButton loginButton" >
				<?php
				if ($user != "") {
					echo '<a style="text-decoration: none; color: #fff;" href="profile.php?uid=' . $user . '">Hi ' . $uname_db . '</a>';
				} else {
					echo '<a style="text-decoration: none; color: #fff;" href="login.php">Log In</a>';
				}
				?>
			</div>
		</div>
		<div style="float: left; margin: 5px 0px 0px 23px;">
				<a href="index.php">
					<img class="icon" src="image/icon.png">
				</a>
		</div>
		<div >
			<form id="newsearch" method="get" action="search.php" style="margin-top: 7px;">
				<input type="text" class="srctextinput" name="q" size="21" maxlength="120" placeholder="Search Here...">
				<input type="submit" value="search" class="srcbutton">
			</form>
		</div>
	</div>
	<div class="categoryHeaders">
		<table>
			<tr>
				<th>
					<?php echo '<a href="mycart.php?uid='.$user.'" style="margin-left: 305px;">My Cart</a>'; ?>
				</th>
				<th>
					<?php echo '<a href="profile.php?uid='.$user.'" >My Orders</a>'; ?>
				</th>
				<th>
					<?php echo '<a href="my_delivery.php?uid='.$user.'" >My Delivery History</a>'; ?>
				</th>
				<th>
					<?php echo '<a href="settings.php?uid='.$user.'" class="selectedItem">Settings</a>'; ?>
				</th>
			</tr>
		</table>
	</div>

	<div style="width: 1250px; margin: 0 auto;">
		<ul>
			<li>
				<div class="settingContainer">
					<form action="" method="POST">
						<div class="signupform_content ">
							<div class="settingsHeader">
								<tr>Change Password</tr></br>
							</div>
							<div>
								<tr><input class="email signupbox" type="password" name="opass" placeholder="Old Password"></tr>
							</div>
							<div>
								<tr><input class="email signupbox" type="password" name="npass" placeholder="New Password"></tr>
							</div>
							<div>
								<tr><input class="email signupbox" type="password" name="npass1" placeholder="Repeat Password"></tr>
							</div>
							<div class="settingsHeader">
								<tr>Change Email<br></tr>
							</div>
							<div>
								<tr><?php echo '<input class="email signupbox" required type="email" 
								name="email" placeholder="New Email" value="' . $uemail_db . '">'; ?>
								</tr>
							</div>
							<div>
								<tr><input class="uisignupbutton signupbutton" type="submit" name="changesettings" 
								value="Update Settings">
								</tr>
							</div>
							<div>
								<?php if (isset($success_message)) {
									echo $success_message;
								} ?>
							</div>
						</div>
					</form>
				</div>
			</li>
		</ul>
	</div>

</body>

</html>
