<?php include ( "../inc/connect.inc.php" ); ?>
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
?>

<!DOCTYPE html>
<html>
<head>
	<title>Cans</title>
	<link rel="stylesheet" type="text/css" href="../css/style.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<link rel="icon" href="../image/icon.png" type="image/x-icon">
</head>
<body>
	<?php include ( "../inc/mainheader.inc.php" ); ?>
	<div class="categoryHeaders">
		<table>
			<tr>
				<th><a href="Cans.php" class="selectedItem">Cans</a></th>
				<th><a href="Snacks.php" >Snacks</a></th>
				<th><a href="Sweets.php" >Sweets</a></th>
				<th><a href="Drinks.php" >Drinks</a></th>
				<th><a href="Condiments.php" >Condiments</a></th>
				<th><a href="Hygiene.php" >Hygiene</a></th>
				<th><a href="Shampoo.php" >Shampoo</a></th>
				<th><a href="Soap.php" >Soap</a></th>
			</tr>
		</table>
	</div>
	<div class="categoryList">
		<div>
		<?php 
			$getposts = mysqli_query($con, "SELECT * FROM products WHERE item ='cans'  ORDER BY id DESC LIMIT 10") or die(mysqlI_error($con));
				if (mysqli_num_rows($getposts)) {
					echo '<ul id="recs">';
					while ($row = mysqli_fetch_assoc($getposts)) {
						$id = $row['id'];
						$name = $row['name'];
						$price = $row['price'];
						$picture = $row['picture'];
						echo '
							<ul style="float: left;">
								<li style="float: left; padding: 0px 25px 25px 25px;">
									<div class="home-prodlist-img">
										<a href="view_product.php?pid='.$id.'">
											<img src="../image/products/cans/'.$picture.'" class="category-img">
										</a>
										<div class="itemDescription"> 
											<span style="font-size: 15px;">'.$name.'</span> - '.$price.'$
										</div>	
									</div>
									
								</li>
							</ul>
						';
					}
				} else {
					echo '<div class="searchNumber">Nothing found!</div>';
				}
		?>
		</div>
	</div>
</body>
</html>
