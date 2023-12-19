<?php include ( "../inc/connect.inc.php" ); ?>
<?php 
ob_start();
session_start();
if (!isset($_SESSION['admin_login'])) {
	header("location: login.php");
	$user = "";
}
else {
	$user = $_SESSION['admin_login'];
	$result = mysqli_query($con, "SELECT * FROM admin WHERE id='$user'");
		$get_user_email = mysqli_fetch_assoc($result);
			$uname_db = $get_user_email['firstName'];
			$utype_db=$get_user_email['type'];
}
$search_value = "";
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Welcome to ebuybd online shop</title>
		<link rel="stylesheet" type="text/css" href="../css/style.css">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
		<script src="/js/homeslideshow.js"></script>
	</head>
	<body class="home-welcome-text" style="min-width: 980px; background-image: url(../image/homebackgrndimg1.jpg);">
		<div class="homepageheader" style="position: relative; padding-bottom: 100px;">
			<?php
				if ($user!="") {
					echo '<div class="signinButton loginButton">
					<a class="uiloginbutton signinButton loginButton" style="margin-right: 40px;" href="logout.php">
					<div style="text-decoration: none;color: #fff;">Log Out</div>
					</a>
					<a class="uiloginbutton signinButton loginButton" href="update_admin.php">
					<div style="text-decoration: none;color: #fff;">Hi '.$uname_db.'</br><span style="color: #fff">'.$utype_db.'</span></div>
					</a>
				</div>';
				}
				else {
					echo '<div class="signinButton loginButton">
					<div class="uiloginbutton signinButton loginButton" style="margin-right: 40px;">
					<a style="text-decoration: none;color: #fff;" href="signin.php">Sign Up</a>
					</div>
					<div class="uiloginbutton signinButton loginButton" >
					<a style="text-decoration: none;color: #fff;" href="login.php">Log In</a>
					</div>
				</div>';
				}
			?>
			<div style="float: left; margin: 5px 0px 0px 23px;">
				<a href="index.php">
					<img style=" height: 75px; width: 130px;" src="../image/cart.png">
				</a>
			</div>
			<div class="">
				<div >
					<form id="newsearch" method="get" action="search.php">
					        <input type="text" class="srctextinput" name="keywords" size="21" maxlength="120"  placeholder="Search Here..."><input type="submit" value="Search" class="srcbutton" >
					</form>
				<div class="srcclear"></div>
				</div>
			</div>
		</div>
		<div class="categoryHeaders">
			<table>
				<tr>
					<th><a href="index.php" style="text-decoration: none;color: #040403;padding: 4px 12px;background-color: #24bfae;border-radius: 12px;">Home</a></th>
					<th><a href="addproduct.php" >Add Product</a></th>
					<th><a href="orders.php" >Orders</a></th>
				<th><a href="DeliveryRecords.php" >DeliveryRecords</a></th>
					<?php 
						if($utype_db == 'admin'){
							echo '<th><a href="report.php" >Reports</a></th>
								<th><a href="newadmin.php" style="text-decoration: none;color: #040403;padding: 4px 12px;background-color: #e6b7b8;;border-radius: 12px;">New Admin</a></th>';
						}
					?>

				</tr>
			</table>
		</div>
		<div class="home-welcome" style="text-align: center; padding-bottom:20px; ">
			<div class="home-welcome-text">
				<h1>Welcome To Admin Panel</h1>
				<h2>You have all permission to do!</h2>
			</div>
		</div>
	</body>
</html>