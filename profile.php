<?php include("inc/connect.inc.php"); ?>
<?php

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

$search_value = "";
?>

<!DOCTYPE html>
<html>

<head>
	<title>My Orders</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<link rel="icon" href="image/icon.png" type="image/x-icon">
</head>

<body>
	<div class="homepageheader" style="position: relative;">
		<?php
		if ($user != "") {
			echo '<div class="signupButton loginButton">
					<a class="uiloginbutton signupButton loginButton" style="margin-right: 40px;" href="logout.php">
						<div style="text-decoration: none; color: #fff;">Log Out</div>
					</a>
					<a class="uiloginbutton signupButton loginButton" href="profile.php?uid=' . $user . '">
						<div style="text-decoration: none; color: #fff;">Hi ' . $uname_db . '</div>
					</a>
				</div>';
		} else {
			echo '<div class="signupButton loginButton">
					<a class="uiloginbutton signupButton loginButton" style="margin-right: 40px;" href="signup.php">
						<div style="color: #fff; text-decoration: none;">Sign Up</div>
					</a>
					<a class="uiloginbutton signupButton loginButton" href="login.php">
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
		<div>
			<form id="newsearch" method="get" action="search.php">
				<?php
				echo '<input type="text" class="srctextinput" name="keywords" 
						size="21" maxlength="120"  placeholder="Search Here..." 
						value="' . $search_value . '"><input type="submit" value="Search" 
						class="srcbutton" >';
				?>
			</form>
		</div>
	</div>
	<div class="categoryHeaders">
		<table>
			<tr>
				<th>
					<?php echo '<a href="mycart.php?uid=' . $user . '" style="margin-left: 305px;">My Cart</a>'; ?>
				</th>
				<th>
					<?php echo '<a href="profile.php?uid=' . $user . '" class="selectedItem">My Orders</a>'; ?>
				</th>
				<th>
					<?php echo '<a href="my_delivery.php?uid=' . $user . '" >My Delivery History</a>'; ?>
				</th>
				<th>
					<?php echo '<a href="settings.php?uid=' . $user . '" >Settings</a>'; ?>
				</th>
			</tr>
		</table>
	</div>


	<div style="width: 1250px; margin: 0 auto;">
		<ul>
			<li>
				<table class="rightsidemenu">
					<tr bgcolor="#f5f5f5">
						<th>Product Name</th>
						<th>Product Price</th>
						<th>Total Product</th>
						<th>Total Price</th>
						<th>Order Date</th>
						<th>Delivery Date</th>
						<th>Delivery Place</th>
						<th>Delivery Status</th>
						<th>Delivery Type</th>
						<th>View</th>
					</tr>
					<tr>
						<?php include("inc/connect.inc.php");
						$query = "SELECT * FROM orders WHERE uid='$user' ORDER BY id DESC";
						$run = mysqli_query($con, $query);
						while ($row = mysqli_fetch_assoc($run)) {
							$pid = $row['pid'];
							$quantity = $row['quantity'];
							$oplace = $row['oplace'];
							$mobile = $row['mobile'];
							$odate = $row['odate'];
							$ddate = $row['ddate'];
							$dstatus = $row['dstatus'];
							$delivaryType = $row['delivery'] == 1 ? "Standard" : "Express";

							//get product info
							$query1 = "SELECT * FROM products WHERE id='$pid'";
							$run1 = mysqli_query($con, $query1);
							$row1 = mysqli_fetch_assoc($run1);
							$pId = $row1['id'];
							$name = substr($row1['name'], 0, 50);
							$price = $row1['price'];
							$totalPrice = $row1['price'] * $quantity;
							$picture = $row1['picture'];
							$item = $row1['item'];
						?>
							<th><?php echo $name; ?></th>
							<th><?php echo $price; ?>$</th>
							<th><?php echo $quantity; ?></th>
							<th><?php echo $totalPrice; ?>$</th>
							<th><?php echo $odate; ?></th>
							<th><?php echo $ddate; ?></th>
							<th><?php echo $oplace; ?></th>
							<th><?php echo $dstatus; ?></th>
							<th><?php echo $delivaryType; ?></th>
							<th><?php echo '
								<div class="home-prodlist-img">
									<a href="products/view_product.php?pid=' . $pId . '">
										<img src="image/products/' . $item . '/' . $picture . '" class="category-img" style="height: 100px; width: 100px;">
									</a>
								</div>' ?>
							</th>
					</tr>
				<?php } ?>
				</table>
			</li>
		</ul>
	</div>

</body>

</html>