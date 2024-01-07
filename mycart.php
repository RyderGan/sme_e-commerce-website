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
	$uname_db = $get_user_email != null ? $get_user_email['firstName'] : null;
	$uemail_db = $get_user_email != null ? $get_user_email['email'] : null;
	$ulast_db = $get_user_email != null ? $get_user_email['lastName'] : null;

	$umob_db = $get_user_email != null ? $get_user_email['mobile'] : null;
	$uadd_db = $get_user_email != null ? $get_user_email['address'] : null;
}

if (isset($_REQUEST['uid'])) {

	$user2 = mysqli_real_escape_string($con, $_REQUEST['uid']);
	if ($user != $user2) {
		header('location: index.php');
	}
} else {
	header('location: index.php');
}

if (isset($_REQUEST['cid'])) {
	$cid = mysqli_real_escape_string($con, $_REQUEST['cid']);
	if (mysqli_query($con, "DELETE FROM orders WHERE pid='$cid' AND uid='$user'")) {
		header('location: mycart.php?uid=' . $user . '');
	} else {
		header('location: index.php');
	}
}

$search_value = "";


//order

if (isset($_POST['order'])) {
	// declare variables
	$mbl = $_POST['mobile'];
	$addr = $_POST['address'];
	$del = $_POST['Delivery'];

	try {
		if (empty($_POST['mobile'])) {
			throw new Exception('Mobile can not be empty');
		}
		if (empty($_POST['address'])) {
			throw new Exception('Address can not be empty');
		}
		if (empty($_POST['Delivery'])) {
			throw new Exception('Type of Delivery can not be empty');
		}

		// Check if email already exists


		// order date
		$d = date("Y-m-d"); // Year - Month - Day


		// delivery date
		$dd = date("Y-m-d", strtotime($d . "+2 weeks"));

		if ($del == 2) {
			// delivery date
			$dd = date("Y-m-d", strtotime($d . "+1 week"));
		}

		// Check product availability and update quantities
		$result = mysqli_query($con, "SELECT * FROM cart WHERE uid='$user'");
		$t = mysqli_num_rows($result);

		if ($t <= 0) {
			throw new Exception('Cart Is Empty!');
		}

		while ($get_p = mysqli_fetch_assoc($result)) {
			$num = $get_p['quantity'];
			$pid = $get_p['pid'];

			// Check product availability
			$productResult = mysqli_query($con, "SELECT * FROM products WHERE id='$pid'");
			$productData = mysqli_fetch_assoc($productResult);

			// Insert order details
			mysqli_query($con, "INSERT INTO orders (uid,pid,quantity,oplace,mobile,odate,ddate,delivery) VALUES ('$user','$pid',$num,'$_POST[address]','$_POST[mobile]','$d','$dd','$del')");
		}

		if (mysqli_query($con, "DELETE FROM cart WHERE uid='$user'")) {
			// success message
			$success_message = '';
		}
	} catch (Exception $e) {
		$error_message = $e->getMessage();
	}
}


?>

<!DOCTYPE html>
<html>

<head>
	<title>My Cart</title>
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
		<div id="srcheader">
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

	<div class="categoryHeadersMyCart">
		<table>
			<tr>
				<th>
					<?php echo '<a href="mycart.php?uid=' . $user . '" style="margin-left: 305px;" class="selectedItem">My Cart</a>'; ?>
				</th>
				<th>
					<?php echo '<a href="profile.php?uid=' . $user . '">My Orders</a>'; ?>
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

	<div>
		<div style="width: 57%;float: left; margin-left: 58px;">
			<ul>
				<li>
					<table class="rightsidemenu">
						<tr style="font-weight: bold;" bgcolor="#f5f5f5">
							<th>Product Name</th>
							<th>Price</th>
							<th>Pieces</th>
							<th>View</th>
							<th>Remove</th>
						</tr>
						<tr>
							<?php
							$query = "SELECT * FROM cart WHERE uid='$user' ORDER BY id DESC";
							$run = mysqli_query($con, $query);
							$total = 0;
							while ($row = mysqli_fetch_assoc($run)) {
								$pid = $row['pid'];
								$quantity = $row['quantity'];

								//get product info
								$query1 = "SELECT * FROM products WHERE id='$pid'";
								$run1 = mysqli_query($con, $query1);
								$row1 = mysqli_fetch_assoc($run1);
								$pId = $row1['id'];
								$name = substr($row1['name'], 0, 50);
								$price = $row1['price'];
								$picture = $row1['picture'];
								$item = $row1['item'];

								$total += ($quantity * $price);
								$_SESSION['total'] = $total;
							?>
								<th><?php echo $name; ?></th>
								<th><?php echo $price; ?>$</th>
								<th>
									<?php echo '<a href="delete_cart.php?sid=' . $pId . '" class="changeQuantityButton">-</a>' ?>
									<?php echo $quantity; ?>
									<?php echo '<a href="delete_cart.php?aid=' . $pId . '" class="changeQuantityButton">+</a>' ?>
								</th>
								<th>
									<?php echo '
									<div class="home-prodlist-img">
										<a href="products/view_product.php?pid=' . $pId . '">
											<img src="image/products/' . $item . '/' . $picture . '" 
												class="category-img" style="height: 100px; width: 100px;">
										</a>
									</div>' ?>
								</th>
								<th>
									<?php echo '
									<div class="home-prodlist-img">
										<a href="delete_cart.php?cid=' . $pId . '" class="xButton">X
										</a>
									</div>' ?>
								</th>
						</tr>
					<?php } ?>
					<tr style="font-weight: bold;">
						<th>Total</th>
						<th></th>
						<th><?php echo $total ?>$</th>
						<th></th>
						<th></th>
					</tr>
					</table>
				</li>
			</ul>
		</div>

		<div style="float: right; width: 32%">
			<?php
			if (isset($success_message)) {
				echo $success_message;

				echo '<p class="paymentDeliverHeader"> Payment & Delivery </p>';

				$user = $_SESSION['user_login'];
				$result = mysqli_query($con, "SELECT * FROM user WHERE id='$user'");
				$get_user_email = mysqli_fetch_assoc($result);
				$uname_db = $get_user_email['firstName'];
				$ulast_db = $get_user_email['lastName'];
				$uemail_db = $get_user_email['email'];
				$umob_db = $get_user_email['mobile'];
				$uadd_db = $get_user_email['address'];

				echo '<div class="paymentDetailsContainer">';
				echo '<div class="paymentDetailsPair">';
				echo '<h3 class="paymentDetailsField"> First Name </h3>';
				echo '<span class="paymentDetailsValue">' . $uname_db . '</span>';
				echo '</div>';

				echo '<div class="paymentDetailsPair">';
				echo '<h3 class="paymentDetailsField"> Last Name </h3>';
				echo '<span class="paymentDetailsValue">' . $ulast_db . '</span>';
				echo '</div>';

				echo '<div class="paymentDetailsPair">';
				echo '<h3 class="paymentDetailsField"> Email </h3>';
				echo '<span class="paymentDetailsValue">' . $uemail_db . '</span>';
				echo '</div>';

				echo '<div class="paymentDetailsPair">';
				echo '<h3 class="paymentDetailsField"> Contact Number </h3>';
				echo '<span class="paymentDetailsValue">' . $umob_db . '</span>';
				echo '</div>';

				echo '<div class="paymentDetailsPair">';
				echo '<h3 class="paymentDetailsField"> Address </h3>';
				echo '<span class="paymentDetailsValue">' . $uadd_db . '</span>';
				echo '</div>';

				$del = $_POST['Delivery'];
				echo '<div class="paymentDetailsPair">';
				echo '<h3 class="paymentDetailsField">Types of Delivery</h3>';
				echo '<span class="paymentDetailsValue">' . $del . '</span>';
				echo '</div>';

				echo '<div class="paymentDetailsPair">';
				echo '<h3 class="paymentDetailsFieldTotal"> Total </h3>';
				echo '<span class="paymentDetailsValueTotal">'  . $_SESSION['total'] . ' $</span>';
				echo '</div>';

				echo '</div>';
			} else {
				echo '
					<form action="" method="POST" class="registration">
				
						<div class="cartForm" >
						<h3 class="cashOnDeliveryText">Accepting CashOnDelivery Only</h3>
							<div>
								<td>
									<input name="fullname" placeholder="First Name" 
									required="required" class="email signupbox" type="text" size="30" value="' . $uname_db . '">
								</td>
							</div>
							
							<div>
								<td>
									<input name="lastname" placeholder="Last Name" 
									required="required" class="email signupbox" type="text" size="30" value="' . $ulast_db . '">
								</td>
							</div>
							
							<div>
								<td>
									<input name="mobile" placeholder="Contact Number" 
									required="required" class="email signupbox" type="text" size="30" value="' . $umob_db . '">
								</td>
							</div>
							
							<div>
								<td>
									<input name="address" id="password-1" required="required"  style="margin-bottom: 0px;"
									placeholder="Address" class=" signupbox " type="text" size="30" value="' . $uadd_db . '">
								</td>
							</div>

							<div>
								<td>
									<div class="mydict">
										<div>
											<label>
												<input type="radio" value="1" name="Delivery" checked="checked">
												<span>Standard Delivery</span>
											</label>
											<label>
												<input type="radio" value="2" name="Delivery">
												<span>Express Delivery</span>
											</label>
										</div>
									</div>
								</td>
							</div>	
							
							<div>
								<input name="order" class="uisignupbutton signupbutton" type="submit" value="Confirm Order" style="margin-top: 0px;">
							</div>
							<div class="signup_error_msg"> '; ?>
				<?php
				if (isset($error_message)) {
					echo $error_message;
				}

				?>
			<?php echo '</div>
						</div>
					</form>
					
				</div>
			</div>

			';
			}

			?>
			</h3>
		</div>
	</div>

</body>

</html>