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

?>


<!doctype html>
<html>
	<head>
		<title>Welcome to ebuybd online shop</title>
		<link rel="stylesheet" type="text/css" href="../css/style.css">
	</head>
	<body class="home-welcome-text" style="min-width: 980px; background-image: url(../image/homebackgrndimg2.png);">
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
					<th><a href="index.php" >Home</a></th>
					<th><a href="addproduct.php" >Add Product</a></th>
					<th><a href="orders.php" >Orders</a></th>
				<th><a href="DeliveryRecords.php" style="text-decoration: none;color: #040403;padding: 4px 12px;background-color: #24bfae;border-radius: 12px;">DeliveryRecords</a></th>
					<?php 
						if($utype_db == 'admin'){
							echo '<th><a href="report.php" >Reports</a></th>
								<th><a href="newadmin.php" style="text-decoration: none;color: #040403;padding: 4px 12px;background-color: #e6b7b8;;border-radius: 12px;">New Admin</a></th>';
						}
					?>

				</tr>
			</table>
		</div>
		<div>
			<table class="rightsidemenu">
				<tr style="font-weight: bold;" colspan="10" bgcolor="#4DB849">
					
					<th>Product Name</th>
					<th>First Name</th>
					<th>Last Name</th>
					<th>Payent</th>
					<th>Date of Delivery</th>
					<th>Type of Delivery</th>
					<th>Delevery Address</th>
				</tr>
				<tr>
					<?php include ( "../inc/connect.inc.php");
					$query = "SELECT * FROM orders WHERE dstatus='Yes' ORDER BY id DESC";
					$run = mysqli_query($con, $query);
					while ($row=mysqli_fetch_assoc($run)) {
						$oid = $row['id'];
						$ouid = $row['uid'];
						$opid = $row['pid'];
						$deliv = $row['delivery'];
						//getting product info
						$query3 = "SELECT * FROM products WHERE id='$opid'";
						$run3 = mysqli_query($con, $query3);
						$row3=mysqli_fetch_assoc($run3);
						$pname = $row3['pName'];

						$oquantity = $row['quantity'];
						$oplace = $row['oplace'];
						$omobile = $row['mobile'];
						$odstatus = $row['dstatus'];
						$odate = $row['odate'];
						$ddate = $row['ddate'];
						//getting user info
						$query1 = "SELECT * FROM user WHERE id='$ouid'";
						$run1 = mysqli_query($con, $query1);
						$row1=mysqli_fetch_assoc($run1);
						$ofname = $row1['firstName'];
						$olname = $row1['lastName'];
						$oumobile = $row1['mobile'];
						$ouemail = $row1['email'];

						//product info
						$query2 = "SELECT * FROM products WHERE id='$opid'";
						$run2 = mysqli_query($con, $query2);
						$row2=mysqli_fetch_assoc($run2);
						$opcate = $row2['category'];
						$opitem = $row2['item'];
						$oppicture = $row2['picture'];
						$oprice = $row2['price'];

					
					 ?>
					<th><?php echo $pname; ?></th>
					<th><?php echo $ofname; ?></th>
					<th><?php echo $olname; ?></th>
					<th><?php echo ''.$oquantity.' * '.$oprice.' = '.$oquantity*$oprice.''; ?></th>
					<th><?php echo $ddate; ?></th>
					<th><?php echo $deliv; ?></th>
					<th><?php echo $oplace; ?></th>

					
				</tr>
				<?php } ?>
			</table>
		</div>
	</body>
</html>
