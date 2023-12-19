<?php include ( "inc/connect.inc.php" ); ?>
<?php 
ob_start();
session_start();
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
<!DOCTYPE html>
<html>
	<head>
		<title>Nita's online grocery</title>
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
		<script src="/js/homeslideshow.js"></script>
	</head>
	<body style="min-width: 980px;">
		<div class="homepageheader" style="position: relative;">
			<?php 
				if ($user!="") {
					echo '<div class="signinButton loginButton">
					<a class="uiloginbutton signinButton loginButton" style="margin-right: 40px;" href="logout.php">
						<div style="text-decoration: none; color: #fff;">Log Out</div>
					</a>
					<a class="uiloginbutton signinButton loginButton" href="profile.php?uid='.$user.'">
						<div style="text-decoration: none; color: #fff;">Hi '.$uname_db.'</div>
					</a>
				</div>';
				}
				else {
					echo '<div class="signinButton loginButton">
					<a class="uiloginbutton signinButton loginButton" style="margin-right: 40px;" href="signin.php">
						<div style="color: #fff; text-decoration: none;">SIGN UP</div>
					</a>
					<a class="uiloginbutton signinButton loginButton" href="login.php">
						<div style="text-decoration: none; color: #fff;">Log In</div>
					</a>
				</div>';
				}
			?>
			<div style="float: left; margin: 5px 0px 0px 23px;">
				<a href="index.php">
					<img class="icon" src="image/icon.png">
				</a>
			</div>
			<div >
				<form id="newsearch" method="get" action="search.php">
					<input type="text" class="srctextinput" name="keywords" 
					size="21" maxlength="120"  placeholder="Search Here...">
					<input type="submit" value="Search" class="srcbutton" >
				</form>
				<div class="srcclear"></div>
			</div>
		</div>
		<img class="background" src="image/background.png" alt="Background">
		<p class="textHeader">PRODUCTS CATEGORY</p>
		<div class="home-prodlist">
			
			<div class="categoryList">

				<ul style="float: left;">
					<li style="padding: 25px;">
						<a href="OurProducts/NoodlesCanned.php">
							<img src="./image/products/cans/can.png" class="category-img">
						</a>
					</li>
				</ul>
				<ul style="float: left;">
					<li style="padding: 25px;">
						<a href="OurProducts/Snacks.php">
							<img src="./image/products/snacks/snacks.png" class="category-img">
						</a>
					</li>
				</ul>
				<ul style="float: left;">
					<li style="padding: 25px;">
						<a href="OurProducts/Sweets.php">
							<img src="./image/products/sweets/sweets.png" class="category-img">
						</a>
					</li>
				</ul>
				<ul style="float: left;">
					<li style="padding: 25px;">
						<a href="OurProducts/Drinks.php">
							<img src="./image/products/drinks/drinks.png" class="category-img"></a>
					</li>
				</ul>
				<ul style="float: left;">
					<li style="padding: 25px;">
						<a href="OurProducts/Seasonings.php">
							<img src="./image/products/condiments/condiments.png" class="category-img"></a>
					</li>
				</ul>
				<ul style="float: left;">
					<li style="padding: 25px;">
						<a href="OurProducts/Hygene.php">
							<img src="./image/products/hygiene/hygiene.png" class="category-img">
						</a>
					</li>
				</ul>
				<ul style="float: left;">
					<li style="padding: 25px;">
						<a href="OurProducts/Shampoo.php">
							<img src="./image/products/shampoo/shampoo.png" class="category-img"></a>
					</li>
				</ul>
				<ul style="float: left;">
					<li style="padding: 25px;">
						<a href="OurProducts/Soap&Detergent.php">
							<img src="./image/products/soap/soap.png" class="category-img"></a>
					</li>
				</ul>
			</div>

		</div>
	</body>
</html>
