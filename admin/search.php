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
					<th><a href="index.php" >Home</a></th>
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
		<div>
			<table class="rightsidemenu">
				<tr style="font-weight: bold;" colspan="10" bgcolor="#4DB849">
					<th>Id</th>
					<th>P Name</th>
					<th>Description</th>
					<th>Price</th>
					<th>Available</th>
					<th>Category</th>
					<th>Type</th>
					<th>Item</th>
					<th>P Code</th>
					<th>Edit</th>
				</tr>
				<tr>
					<?php include ( "../inc/connect.inc.php");
					$search_value = trim($_GET['keywords']);
					$query = "SELECT * FROM products WHERE pName like '%$search_value%'  ORDER BY id DESC";
					$run = mysqli_query($con, $query);
					if ( $total = mysqli_num_rows($run)) {
					while ($row=mysqli_fetch_assoc($run)) {
						$id = $row['id'];
						$pName = substr($row['pName'], 0,50);
						$descri = $row['description'];
						$price = $row['price'];
						$piece=$row['piece'];
						$available = $row['available'];
						$category = $row['category'];
						$type = $row['type'];
						$item = $row['item'];
						$pCode = $row['pCode'];
						$picture = $row['picture'];
					
					 ?>
					<th><?php echo $id; ?></th>
					<th><?php echo $pName; ?></th>
					<th><?php echo $descri; ?></th>
					<th><?php echo $price; ?></th>
					<th><?php echo $piece;?></th>
					<th><?php echo $available; ?></th>
					<th><?php echo $category; ?></th>
					<th><?php echo $type; ?></th>
					<th><?php echo $item; ?></th>
					<th><?php echo $pCode; ?></th>
					<th><?php echo '<div class="home-prodlist-img"><a href="editproduct.php?epid='.$id.'">
									<img src="../image/product/'.$item.'/'.$picture.'" class="category-img" style="height: 75px; width: 75px;">
									</a>
								</div>' ?></th>
				</tr>
				<?php }
					}
				 ?>
			</table>
		</div>
	</body>
</html>
