<?php include ( "inc/connect.inc.php" ); ?>
<?php 

ob_start();
session_start();
if (!isset($_SESSION['user_login'])) {
	header("location: login.php");
}
else {
	$user = $_SESSION['user_login'];
	$result = mysqli_query($con, "SELECT * FROM user WHERE id='$user'");
		$get_user_email = mysqli_fetch_assoc($result);
			$uname_db = $get_user_email['firstName'];
			$uemail_db = $get_user_email['email'];

			$umob_db = $get_user_email['mobile'];
			$uadd_db = $get_user_email['address'];
}

if (isset($_REQUEST['uid'])) {
	
	$user2 = mysqli_real_escape_string($con, $_REQUEST['uid']);
	if($user != $user2){
		header('location: index.php');
	}
}else {
	header('location: index.php');
}

if (isset($_REQUEST['cid'])) {
		$cid = mysqli_real_escape_string($con, $_REQUEST['cid']);
		if(mysqli_query($con, "DELETE FROM orders WHERE pid='$cid' AND uid='$user'")){
		header('location: mycart.php?uid='.$user.'');
	}else{
		header('location: index.php');
	}
}

$search_value = "";

?>

<!DOCTYPE html>
<html>
<head>
	<title>Delivery Details</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body style="background-image: url(image/homebackgrndimg1.jpg);">
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
				        <?php 
				        	echo '<input type="text" class="srctextinput" name="keywords" size="21" maxlength="120"  placeholder="Search Here..." value="'.$search_value.'"><input type="submit" value="Search" class="srcbutton" >';
				         ?>
				</form>
			<div class="srcclear"></div>
			</div>
		</div>
		<div class="categoryHeaders">
			<table>
				<tr>
					<th><?php echo '<a href="mycart.php?uid='.$user.'" >My Cart</a>'; ?></th>
					<th>
						<?php echo '<a href="profile.php?uid='.$user.'" style="text-decoration: none;color: #040403;padding: 4px 12px;background-color: #fff;border-radius: 12px;">My Orders</a>'; ?>
					</th>
					<th>
						<?php echo '<a href="#" >My Delivery History</a>'; ?>
					</th>
					<th><?php echo '<a href="settings.php?uid='.$user.'" style="text-decoration: none;color: #040403;padding: 4px 12px;background-color: #fff;border-radius: 12px;">Settings</a>'; ?></th>
					

				</tr>
			</table>
		</div>
	<div style="margin-top: 20px;">
		<div style="width: 900px; margin: 0 auto;">
		
			<ul>
				<li style=" background-color: #fff;">
					<div>
						<div>
							<table class="rightsidemenu">
								<tr style="font-weight: bold;" colspan="10" bgcolor="#3A5487">
									<th>Product Name</th>
									<th>Delivery Date</th>
									
									
								</tr>
								<tr>
									<?php include ( "inc/connect.inc.php");
									$query = "SELECT * FROM cart WHERE uid='$user' ORDER BY id DESC";
									$run = mysqli_query($con, $query);
									while ($row=mysqli_fetch_assoc($run)) {
										$pid = $row['pid'];
										$quantity = $row['quantity'];
										
										//get product info
										$query1 = "SELECT * FROM products WHERE id='$pid'";
										$run1 = mysqli_query($con, $query1);
										$row1=mysqli_fetch_assoc($run1);
										$pId = $row1['id'];
										$pName = substr($row1['pName'], 0,50);
										$price = $row1['price'];
										$description = $row1['description'];
										$picture = $row1['picture'];
										$item = $row1['item'];
										$category = $row1['category'];
									 ?>
									<th><?php echo $pName; ?></th>
									<th><?php echo $price; ?></th>
									<th><?php echo $quantity; ?></th>
									<th><?php echo $description; ?></th>
									<th><?php echo '<div class="home-prodlist-img"><a href="'.$category.'/view_product.php?pid='.$pId.'">
													<img src="image/product/'.$item.'/'.$picture.'" class="category-img" style="height: 75px; width: 75px;">
													</a>
												</div>' ?></th>
									<th><?php echo '<div class="home-prodlist-img"><a href="delete_cart.php?cid='.$pId.'" style="text-decoration: none;">X</a>
												</div>' ?></th>
								</tr>
								<?php } ?>
							</table>
						</div>
					</div>
				</li>
				
			</ul>
		</div>
	</div>

</body>
</html>
