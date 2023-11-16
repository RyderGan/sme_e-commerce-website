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
	<title>Hygiene</title>
	<link rel="stylesheet" type="text/css" href="../css/style.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
	<?php include ( "../inc/mainheader.inc.php" ); ?>
	<div class="categoryHeaders">
		<table>
			<tr>
				<th><a href="NoodlesCanned.php" >Cans</a></th>
				<th><a href="Snacks.php" class="selectedItem">Snacks</a></th>
				<th><a href="Sweets.php" >Sweets</a></th>
				<th><a href="Drinks.php" >Drinks</a></th>
				<th><a href="Seasonings.php" >Condiments</a></th>
				<th><a href="Hygene.php" class="selectedItem">Hygene</a></th>
				<th><a href="Shampoo.php" >Shampoo</a></th>
				<th><a href="Soap&Detergent.php" >Soap</a></th>
			</tr>
		</table>
	</div>
	<div class="categoryList">
		<div>
		<?php 
			$getposts = mysqli_query($con, "SELECT * FROM products WHERE item ='hygiene'  ORDER BY id DESC LIMIT 10") or die(mysqlI_error($con));
					if (mysqli_num_rows($getposts)) {
					echo '<ul id="recs">';
					while ($row = mysqli_fetch_assoc($getposts)) {
						$id = $row['id'];
						$pName = $row['pName'];
						$price = $row['price'];
						$description = $row['description'];
						$picture = $row['picture'];
						
						echo '
							<ul style="float: left;">
								<li style="float: left; padding: 0px 25px 25px 25px;">
									<div class="home-prodlist-img"><a href="view_product.php?pid='.$id.'">
										<img src="../image/product/hygiene/'.$picture.'" class="category-img">
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
		?>
			
		</div>
	</div>
</body>
</html>
