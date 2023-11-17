<?php 

include("../inc/connect.inc.php");
ob_start();
session_start();
if (!isset($_SESSION['user_login'])) {
	$user = "";
} else {
	$user = $_SESSION['user_login'];
	$result = mysqli_query($con, "SELECT * FROM user WHERE id='$user'");
	$get_user_email = mysqli_fetch_assoc($result);
	$uname_db = $get_user_email['firstName'];
}
if (isset($_REQUEST['pid'])) {

	$pid = mysqli_real_escape_string($con, $_REQUEST['pid']);
} else {
	header('location: index.php');
}


$getposts = mysqli_query($con, "SELECT * FROM products WHERE id ='$pid'") or die(mysqlI_error($con));
if (mysqli_num_rows($getposts)) {
	$row = mysqli_fetch_assoc($getposts);
	$id = $row['id'];
	$pName = $row['pName'];
	$price = $row['price'];
	$piece = $row['piece'];
	$description = $row['description'];
	$picture = $row['picture'];
	$item = $row['item'];
	$available = $row['available'];
}


if (isset($_POST['addcart'])) {
	$getposts = mysqli_query($con, "SELECT * FROM cart WHERE pid ='$pid' AND uid='$user'") or die(mysqlI_error($con));
	if ($row = mysqli_fetch_assoc($getposts)) {
		// Product is already in the cart, so update the quantity
		$newQuantity = $row['quantity'] + 1;
		mysqli_query($con, "UPDATE cart SET quantity = '$newQuantity' WHERE pid ='$pid' AND uid='$user'");
		header('location: ../mycart.php?uid=' . $user);
	} else {
		if (mysqli_query($con, "INSERT INTO cart (uid,pid,quantity) VALUES ('$user','$pid', 1)")) {
			header('location: ../mycart.php?uid=' . $user . '');
		} else {
			header('location: index.php');
		}
	}
}
?>

<!DOCTYPE html>
<html>

<head>
	<title>Product</title>
	<link rel="stylesheet" type="text/css" href="../css/style.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
	<?php include("../inc/mainheader.inc.php"); ?>
	<div class="categoryHeaders">
		<table>
			<tr>
				<th><a href="NoodlesCanned.php" >Cans</a></th>
				<th><a href="Snacks.php" >Snacks</a></th>
				<th><a href="Sweets.php" >Sweets</a></th>
				<th><a href="Drinks.php" >Drinks</a></th>
				<th><a href="Seasonings.php" >Condiments</a></th>
				<th><a href="Hygene.php">Hygene</a></th>
				<th><a href="Shampoo.php" >Shampoo</a></th>
				<th><a href="Soap&Detergent.php" >Soap</a></th>
			</tr>
		</table>
	</div>

	<div>
		<?php
		echo '
				<div style="float: left;">
					<div>
						<img src="../image/product/' . $item . '/' . $picture . '" class="productImg">
					</div>
				</div>
				<div class="productInfo">
					<p class="productHdr">' . $pName . '</p>
					<p class="productPrice">Price ' . $price . '$</p>
					<p class="productPiece">' . $piece . ' Pieces</p>
					<p class="productDescription">Description: ' . $description . '$</p>
					<div class="productButtonsContainer">
						<form id="" method="post" action="">
							<input type="submit" name="addcart" value="Add to cart" class="productButtons" >
						</form>
						<form id="" method="post" action="../orderform.php?poid=' . $pid . '">
							<input type="submit" value="Order Now" class="productButtons" >
						</form>
					</div>
				</div>
			';
		?>

	</div>
</body>

</html>
