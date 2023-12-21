<?php include ( "connect.inc.php" ); ?>
<?php 
if (!isset($_SESSION['user_login'])) {
	$user = "";
}
else {
	$user = $_SESSION['user_login'];
	$result = mysqli_query($con, "SELECT * FROM user WHERE id='$user'");
	$get_user_email = mysqli_fetch_assoc($result);
	$uname_db = $get_user_email != null ? $get_user_email['firstName'] : null;
}
?>
<div class="homepageheader" style="position: relative;">
	<?php
		if ($user!="") {
			echo '<div class="signupButton loginButton">
			<a class="uiloginbutton signupButton loginButton" style="margin-right: 40px;" href="../logout.php">
				<div style="text-decoration: none; color: #fff;">Log Out</div>
			</a>
			<a class="uiloginbutton signupButton loginButton" href="../profile.php?uid='.$user.'">
				<div style="text-decoration: none; color: #fff;">Hi '.$uname_db.'</div>
			</a>
		</div>';
		}
		else {
			echo '<div class="signupButton loginButton">
			<a class="uiloginbutton signupButton loginButton" style="margin-right: 40px;" href="../signup.php">
				<div style="color: #fff; text-decoration: none;">Sign Up</div>
			</a>
			<a class="uiloginbutton signupButton loginButton" href="../login.php">
				<div style="text-decoration: none; color: #fff;">Log In</div>
			</a>
		</div>';
		}
	?>
	<div style="float: left; margin: 5px 0px 0px 23px;">
		<a href="../index.php">
			<img class="icon" src="../image/icon.png">
		</a>
	</div>
	<div >
				<form id="newsearch" method="get" action="../search.php" >
			<input type="text" class="srctextinput" name="keywords" 
			size="21" maxlength="120"  placeholder="Search Here...">
			<input type="submit" value="Search" class="srcbutton" >
		</form>
	</div>
</div>
