<?php

include("inc/connect.inc.php");

ob_start();
session_start();
if (!isset($_SESSION['user_login'])) {
} else {
	header("location: index.php");
}
$emails = "";
$passs = "";
if (isset($_POST['login'])) {
	if (isset($_POST['email']) && isset($_POST['password'])) {
		$user_login = mysqli_real_escape_string($con, $_POST['email']);
		$user_login = mb_convert_case($user_login, MB_CASE_LOWER, "UTF-8");
		$password_login = mysqli_real_escape_string($con, $_POST['password']);
		$num = 0;
		$password_login_md5 = md5($password_login);
		$result = mysqli_query($con, "SELECT * FROM user WHERE (email='$user_login') AND password='$password_login_md5' AND activation='yes'");
		$num = mysqli_num_rows($result);
		$get_user_email = mysqli_fetch_assoc($result);
		if ($num > 0) {
			$get_user_uname_db = $get_user_email['id'];
			$_SESSION['user_login'] = $get_user_uname_db;
			setcookie('user_login', $user_login, time() + (365 * 24 * 60 * 60), "/");

			if (isset($_REQUEST['ono'])) {
				$ono = mysqli_real_escape_string($con, $_REQUEST['ono']);
				header("location: orderform.php?poid=" . $ono . "");
			} else {
				header('location: index.php');
			}
			exit();
		} else {
			$result1 = mysqli_query($con, "SELECT * FROM user WHERE (email='$user_login') AND password='$password_login_md5' AND activation='no'");
			$num1 = mysqli_num_rows($result1);
			$get_user_email1 = mysqli_fetch_assoc($result1);
			if ($num1 > 0) {
				$emails = $user_login;
				$activacc = '';
			} else {
				$emails = $user_login;
				$passs = $password_login;
				$error_message = '<br><br>
				<div class="maincontent_text" style="text-align: center; font-size: 18px;">
				<font face="bookman">Email or Password incorrect.<br>
				</font></div>';
			}
		}
	}
}
$acemails = "";
$acccode = "";
if (isset($_POST['activate'])) {
	if (isset($_POST['actcode'])) {
		$user_login = mysqli_real_escape_string($con, $_POST['acemail']);
		$user_login = mb_convert_case($user_login, MB_CASE_LOWER, "UTF-8");
		$user_acccode = mysqli_real_escape_string($con, $_POST['actcode']);
		$result2 = mysqli_query($con, "SELECT * FROM user WHERE (email='$user_login') AND confirmCode='$user_acccode'");
		$num3 = mysqli_num_rows($result2);
		echo $user_login;
		if ($num3 > 0) {
			$get_user_email = mysqli_fetch_assoc($result2);
			$get_user_uname_db = $get_user_email['id'];
			$_SESSION['user_login'] = $get_user_uname_db;
			setcookie('user_login', $user_login, time() + (365 * 24 * 60 * 60), "/");
			mysqli_query($con, "UPDATE user SET confirmCode='0', activation='yes' WHERE email='$user_login'");
			if (isset($_REQUEST['ono'])) {
				$ono = mysqli_real_escape_string($con, $_REQUEST['ono']);
				header("location: orderform.php?poid=" . $ono . "");
			} else {
				header('location: index.php');
			}
			exit();
		} else {
			$emails = $user_login;
			$error_message = '<br><br>
				<div class="maincontent_text" style="text-align: center; font-size: 18px;">
				<font face="bookman">Code not matched!<br>
				</font></div>';
		}
	} else {
		$error_message = '<br><br>
				<div class="maincontent_text" style="text-align: center; font-size: 18px;">
				<font face="bookman">Activation code not matched!<br>
				</font></div>';
	}
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="icon" href="image/icon.png" type="image/x-icon">
</head>

<body class="home-welcome-text" style="background-color: #F5F5F5">
    <div class="homepageheader">
        <div class="signupButton loginButton">
            <div class="uiloginbutton signupButton loginButton" style="margin-right: 40px;">
                <a style="text-decoration: none; color: #fff;" href="signup.php">Sign Up</a>
            </div>
        </div>

        <div style="float: left; margin: 5px 0px 0px 23px;">
            <a href="index.php">
                <img class="icon" src="image/icon.png">
            </a>
        </div>

        <div class="loginContainer">
            <div class="loginform_content">
                <h2><?php echo isset($activacc) ? 'Activation' : 'Login'; ?></h2>
                <form action="" method="POST">
                    <div class="signup_error_msg">
                        <?php
                        if (isset($error_message)) {
                            echo '<div style="text-align: center; font-size: 18px;">' . $error_message . '<br></div>';
                        }
                        ?>
                    </div>

                    <?php
                    if (isset($activacc)) {
                        echo '
                            <div class="signup_error_msg">
                                <div style="text-align: center; font-size: 18px;">Check your email!<br></div>
                            </div>
                            <div>
                                <input name="acemail" placeholder="Enter Your Email" required="required" class="signupbox" type="email" size="30" value="' . $emails . '">
                            </div>
                            <div>
                                <input name="actcode" placeholder="Activation Code" required="required" class="signupbox" type="text" size="30" value="' . $acccode . '">
                            </div>
                            <div>
                                <input name="activate" class="uisignupbutton signupbutton" type="submit" value="Activate Account">
                            </div>
                        ';
                    } else {
                        echo '
                            <div>
                                <input name="email" placeholder="Enter Your Email" required="required" class="signupbox" type="email" size="30" value="' . $emails . '">
                            </div>
                            <div>
                                <input name="password" id="password-1" required="required" placeholder="Enter Password" class="signupbox" type="password" size="30" value="' . $passs . '">
                            </div>
                            <div>
                                <input name="login" class="uisignupbutton signupbutton" type="submit" value="Log In">
                            </div>
                        ';
                    }
                    ?>

                    <p class="forgetpass">
                        <a href="forgetpass.php">Forget The Password?</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
