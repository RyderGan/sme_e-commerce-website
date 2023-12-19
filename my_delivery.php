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

$search_value = "";
?>

<!DOCTYPE html>
<html>
<head>
	<title>My Delivery History</title>
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
						value="'.$search_value.'"><input type="submit" value="Search" 
						class="srcbutton" >';
				         ?>
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
						<?php echo '<a href="profile.php?uid='.$user.'">My Orders</a>'; ?>
					</th>
					<th>
						<?php echo '<a href="my_delivery.php?uid='.$user.'" class="selectedItem">My Delivery History</a>'; ?>
					</th>
					<th>
						<?php echo '<a href="settings.php?uid='.$user.'" >Settings</a>'; ?>
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
						<th>Delevery Date</th>
					</tr>
					<tr>
						<?php include ( "inc/connect.inc.php");
						$query = "SELECT * FROM orders WHERE uid='$user' ORDER BY id DESC";
						$run = mysqli_query($con, $query);
						while ($row=mysqli_fetch_assoc($run)) {
							$pid = $row['pid'];
							$quantity = $row['quantity'];
							$oplace = $row['oplace'];
							$mobile = $row['mobile'];
							$odate = $row['odate'];
							$ddate = $row['ddate'];
							$dstatus = $row['dstatus'];
							
							//get product info
							$query1 = "SELECT * FROM products WHERE id='$pid'";
							$run1 = mysqli_query($con, $query1);
							$row1=mysqli_fetch_assoc($run1);
							$pId = $row1['id'];
							$pName = substr($row1['pName'], 0,50);
							$price = $row1['price'];
							$picture = $row1['picture'];
							$item = $row1['item'];
							$category = $row1['category'];
							?>
						<th><?php echo $pName; ?></th>
						<th><?php echo $ddate; ?></th>
					</tr>
					<?php } ?>
				</table>
			</li>
		</ul>
	</div>

</body>
</html>
