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
	<link rel="icon" href="image/icon.png" type="image/x-icon">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<body>
	<div class="homepageheader" style="position: relative;">
		<div class="signupButton loginButton">
			<div class="uiloginbutton signupButton loginButton" style="margin-right: 40px;">
				<?php 
					if ($user!="") {
						echo '<a style="text-decoration: none; color: #fff;" href="logout.php">Log Out</a>';
					}
					else {
						echo '<a style="text-decoration: none; color: #fff;" href="signup.php">Sign Up</a>';
					}
				 ?>
			</div>
			<div class="uiloginbutton signupButton loginButton">
				<?php 
					if ($user!="") {
						echo '<a style="text-decoration: none; color: #fff;" href="profile.php?uid='.$user.'">Hi '.$uname_db.'</a>';
					}
					else {
						echo '<a style="text-decoration: none; color: #fff;" href="login.php">Log In</a>';
					}
				 ?>
			</div>
		</div>
		<div style="float: left; margin: 5px 0px 0px 23px;">
			<a href="index.php">
				<img class="icon" src="image/icon.png">
			</a>
		</div>
		<form id="newsearch" method="get" action="search.php" >
			<?php 
				echo '<input type="text" class="srctextinput" name="keywords" 
				size="21" maxlength="120"  placeholder="Search Here..." 
				value="'.$search_value.'">
				<input type="submit" value="Search" class="srcbutton" >';
				?>
		</form>
	</div>
	<div class="categoryHeaders">
		<table>
			<tr>
				<th><a href="products/Cans.php" >Cans</a></th>
				<th><a href="products/Snacks.php" >Snacks</a></th>
				<th><a href="products/Sweets.php" >Sweets</a></th>
				<th><a href="products/Drinks.php" >Drinks</a></th>
				<th><a href="products/Condiments.php" >Condiments</a></th>
				<th><a href="products/Hygiene.php" >Hygiene</a></th>
				<th><a href="products/Shampoo.php" >Shampoo</a></th>
				<th><a href="products/Soap.php" >Soap</a></th>
			</tr>
		</table>
	</div>
	<?php 
		if (isset($_GET['keywords']) && $_GET['keywords'] != ""){
			$search_value = trim($_GET['keywords']);
			$getposts = mysqli_query($con, "SELECT * FROM products WHERE name like '%$search_value%'  ORDER BY id DESC") or die(mysqlI_error($con));
				if ( $total = mysqli_num_rows($getposts)) {
				echo '<ul id="recs">';
				echo '<div class="searchNumber"> '.$total.' Product(s) Found</div>';
					while ($row = mysqli_fetch_assoc($getposts)) {
						$id = $row['id'];
						$name = $row['name'];
						$price = $row['price'];
						$picture = $row['picture'];
						$item = $row['item'];
						
						echo '
						<div class="categoryList">
							<ul style="float: left;">
								<li style="float: left; padding: 0px 25px 25px 25px;">
									<div class="home-prodlist-img"><a href="products/view_product.php?pid='.$id.'">
										<img src="image/products/'.$item.'/'.$picture.'" class="category-img">
										</a>
										<div class="itemDescription"> 
											<span style="font-size: 15px;">'.$name.'</span> - '.$price.'$
										</div>
									</div>
								</li>
							</ul>
						</div>
						';

					}
				}
				else {
					echo  '<div class="searchNumber"> Nothing Found! </div>';
				}
		}else {
			echo "Input Someting";
		}
	?>
</body>
</html>
