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
			$uname_db = $get_user_email['firstName'];
}

if (isset($_REQUEST['keywords'])) {

	$epid = mysqli_real_escape_string($con, $_REQUEST['keywords']);
	if($epid != "" && ctype_alnum($epid)){
		
	}else {
		header('location: index.php');
	}
}else {
	header('location: index.php');
}

$search_value = "";
$search_value = trim($_GET['keywords']);

?>

<!DOCTYPE html>
<html>
<head>
	<title>Search</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
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
				<form id="newsearch" method="get" action="search.php" style="margin-top: 7px;">
				        <?php 
				        	echo '<input type="text" class="srctextinput" name="keywords" 
						size="21" maxlength="120"  placeholder="Search Here..." 
						value="'.$search_value.'">
						<input type="submit" value="Search" class="srcbutton" >';
				         ?>
				</form>
			<div class="srcclear"></div>
		</div>
	</div>
	<div class="categoryHeaders">
		<table>
			<tr>
				<th><a href="OurProducts/NoodlesCanned.php" >Cans</a></th>
				<th><a href="OurProducts/Snacks.php" >Snacks</a></th>
				<th><a href="OurProducts/Sweets.php" >Sweets</a></th>
				<th><a href="OurProducts/Drinks.php" >Drinks</a></th>
				<th><a href="OurProducts/Seasonings.php" >Condiments</a></th>
				<th><a href="OurProducts/Hygene.php" >Hygene</a></th>
				<th><a href="OurProducts/Shampoo.php" >Shampoo</a></th>
				<th><a href="OurProducts/Soap&Detergent.php" >Soap</a></th>
			</tr>
		</table>
	</div>
	<div class="categoryList">
		<?php 
			if (isset($_GET['keywords']) && $_GET['keywords'] != ""){
				$search_value = trim($_GET['keywords']);
				$getposts = mysqli_query($con, "SELECT * FROM products WHERE pName like '%$search_value%'  ORDER BY id DESC") or die(mysqlI_error($con));
					if ( $total = mysqli_num_rows($getposts)) {
					echo '<ul id="recs">';
					echo '<div class="searchNumber"> '.$total.' Products Found</div><br>';
						while ($row = mysqli_fetch_assoc($getposts)) {
							$id = $row['id'];
							$pName = $row['pName'];
							$price = $row['price'];
							$description = $row['description'];
							$picture = $row['picture'];
							$item = $row['item'];
							
							echo '
								<ul style="float: left;">
									<li style="float: left; padding: 0px 25px 25px 25px;">
										<div class="home-prodlist-img"><a href="women/view_product.php?pid='.$id.'">
											<img src="image/product/'.$item.'/'.$picture.'" class="category-img">
											</a>
											<div class="itemDescription"> 
												<span style="font-size: 15px;">'.$pName.'</span><br> Price: '.$price.' Php
											</div>
										</div>
									</li>
								</ul>
							';

						}
					}
					else {
						echo '<div class="searchNumber"> No Products Found!</div><br>';
					}
			}else {
				echo "Input Someting";
			}
		?>
	</div>
</body>
</html>
