<?php include ( "inc/connect.inc.php" ); ?>
<?php 

if (isset($_REQUEST['poid'])) {
	
	$poid = mysqli_real_escape_string($con, $_REQUEST['poid']);
}else {
	header('location: index.php');
}
ob_start();
session_start();
if (!isset($_SESSION['user_login'])) {
	$user = "";
	header("location: login.php?ono=".$poid."");
}
else {
	$user = $_SESSION['user_login'];
	$result = mysqli_query($con, "SELECT * FROM user WHERE id='$user'");
		$get_user_ = mysqli_fetch_assoc($result);

			$uname_db = $get_user_['firstName'];
			$ulast_db=$get_user_['lastName'];
			// $u_db = $get_user_[''];

			$umob_db = $get_user_['mobile'];
			$uadd_db = $get_user_['address'];
}


$getposts = mysqli_query($con, "SELECT * FROM products WHERE id ='$poid'") or die(mysqlI_error($con));
					if (mysqli_num_rows($getposts)) {
						$row = mysqli_fetch_assoc($getposts);
						$id = $row['id'];
						$name = $row['name'];
						$price = $row['price'];
						$picture = $row['picture'];
						$item = $row['item'];
					}	

//order

if (isset($_POST['order'])) {
//declere veriable
$mbl = $_POST['mobile'];
$addr = $_POST['address'];
$quan = $_POST['Quantity'];
$del = $_POST['Delivery'];
//triming name
	try {
		if(empty($_POST['mobile'])) {
			throw new Exception('Mobile can not be empty');
			
		}
		if(empty($_POST['address'])) {
			throw new Exception('Address can not be empty');
			
		}
		if(empty($_POST['Quantity'])) {
			throw new Exception('Quantity can not be empty');
			
		}
		if(empty($_POST['Delivery'])) {
			throw new Exception('Type of Delivery can not be empty');
			
		}

		
		// Check if  already exists
		
		
						$d = date("Y-m-d"); //Year - Month - Day
						
						// send 
						$msg = "
					
						Your Order suc

						
						";
						//if (@mail($u_db,"eBuyBD Product Order",$msg, "From:eBuyBD <no-reply@ebuybd.xyz>")) {
							
						if(mysqli_query($con, "INSERT INTO orders (uid,pid,quantity,oplace,mobile,odate,delivery) VALUES ('$user','$poid',$quan,'$_POST[address]','$_POST[mobile]','$d','$del')")){

							//success message
							

							
						$success_message = '
						<div class="signupform_content">
						<h2><font face="bookman"></font></h2>
						<script>
						alert("We will call you for confirmation very soon");
						</script>
						</div>
						';
						

						

							
						}
						//}

	}
	catch(Exception $e) {
		$error_message = $e->getMessage();
	}
}


?>

<!DOCTYPE html>
<html>
<head>
	<title>Order</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<link rel="icon" href="image/icon.png" type="image/x-icon">
</head>
<body>
	<div class="homepageheader" style="position: relative;">
			<?php
				if ($user!="") {
					echo '<div class="signupButton loginButton">
					<a class="uiloginbutton signupButton loginButton" style="margin-right: 40px;" href="logout.php">
						<div style="text-decoration: none; color: #fff;">Log Out</div>
					</a>
					<a class="uiloginbutton signupButton loginButton" href="profile.php?uid='.$user.'">
						<div style="text-decoration: none; color: #fff;">Hi '.$uname_db.'</div>
					</a>
				</div>';
				}
				else {
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
		<div >
			<form id="newsearch" method="get" action="search.php" >
				<input type="text" class="srctextinput" name="keywords" size="21" maxlength="120"  placeholder="Search Here..."><input type="submit" value="Search" class="srcbutton" >
			</form>
		</div>
	</div>
	<div class="categoryHeaders" style="padding-bottom: 28px; margin-bottom: 30px">
		<table>
			<tr>
				<th><a href="products/Cans.php" >Cans</a></th>
				<th><a href="products/Snacks.php" >Snacks</a></th>
				<th><a href="products/Sweets.php" >Sweets</a></th>
				<th><a href="products/Drinks.php" >Drinks</a></th>
				<th><a href="products/Condiments.php" >Condiments</a></th>
				<th><a href="products/Hygiene.php">Hygiene</a></th>
				<th><a href="products/Shampoo.php" >Shampoo</a></th>
				<th><a href="products/Soap.php" >Soap</a></th>
			</tr>
		</table>
	</div>
	<div >
		<div class="container signupform_content ">
			<div>
				<div style="float: right; width: 47%">
				<?php 
					if(isset($success_message)) {
						echo $success_message;
						echo '<div>';
						echo '<div class="paymentDeliverHeaderContainer">';
						echo '<p class="paymentDeliverHeader"> Payment - Delivery </p>';
						echo '</div>';

						$user = $_SESSION['user_login'];
						$result = mysqli_query($con, "SELECT * FROM user WHERE id='$user'");
						$get_user_ = mysqli_fetch_assoc($result);
						$uname_db = $get_user_['firstName'];
						$ulast_db=$get_user_['lastName'];
						// $u_db = $get_user_[''];
						$umob_db = $get_user_['mobile'];
						$uadd_db = $get_user_['address'];

						echo '<div class="paymentDetailsContainer">';
						echo '<div class="paymentOrderDetailsPair">';
						echo '<h3 class="paymentDetailsField"> First Name </h3>';
						echo '<span class="paymentDetailsValue">' . $uname_db . '</span>';
						echo '</div>';
						
						echo '<div class="paymentOrderDetailsPair">';
						echo '<h3 class="paymentDetailsField"> Last Name </h3>';
						echo '<span class="paymentDetailsValue">' . $ulast_db . '</span>';
						echo '</div>';
						
						echo '<div class="paymentOrderDetailsPair">';
						echo '<h3 class="paymentDetailsField"> Contact Number </h3>';
						echo '<span class="paymentDetailsValue">' . $umob_db . '</span>';
						echo '</div>';
						
						echo '<div class="paymentOrderDetailsPair">';
						echo '<h3 class="paymentDetailsField"> Address </h3>';
						echo '<span class="paymentDetailsValue">' . $uadd_db . '</span>';
						echo '</div>';
						
						$del = $_POST['Delivery'];
						echo '<div class="paymentOrderDetailsPair">';
						echo '<h3 class="paymentDetailsField">Types of Delivery</h3>';
						echo '<span class="paymentDetailsValue">' . $del . '</span>';
						echo '</div>';
						
						$del = $_POST['Quantity'];
						echo '<div class="paymentOrderDetailsPair">';
						echo '<h3 class="paymentDetailsField">Quantity</h3>';
						echo '<span class="paymentDetailsValue">' . $quan . '</span>';
						echo '</div>';
						
						echo '<div class="paymentOrderDetailsPair">';
						echo '<h3 class="paymentDetailsFieldTotal"> Total </h3>';
						echo '<span class="paymentDetailsValueTotal">'  . ($quan * $price) . ' $</span>';
						echo '</div>';
		
						echo '</div>';	
						echo '</div>';	
			
					}
					else {
						echo '
							<form action="" method="POST" class="registration">
								<div class="cartForm">
									<h3 class="cashOnDeliveryText">Accepting CashOnDelivery Only</h3>
									<div>
										<td>
											<input name="fullname" placeholder="First Name" 
											required="required" class=" inputFieldsOrder" 
											type="text" size="30" value="'.$uname_db.'">
										</td>
									</div>

									<div>
										<td>
											<input name="lastname" placeholder="Last Name" 
											required="required" class=" inputFieldsOrder" 
											type="text" size="30" value="'.$ulast_db.'">
										</td>
									</div>

									<div>
										<td>
											<input name="mobile" placeholder="Mobile Number" required="required" class=" inputFieldsOrder" type="text" size="30" value="'.$umob_db.'">
										</td>
									</div>

									<div>
										<td>
											<input name="address" id="password-1" required="required"  
											placeholder="Address" class=" inputFieldsOrder " 
											type="text" size="30" value="'.$uadd_db.'">
										</td>
									</div>

									<div>
										<div class="mydict" style="padding-bottom=6px;">
											<div>
												<label>
													<input type="radio" name="Delivery" checked="checked">
													<span>Standard Delivery</span>
												</label>
												<label>
													<input type="radio" name="Delivery">
													<span>Express Delivery</span>
												</label>
											</div>
										</div>
									</div>

									<div>
										<td>
										<input name="Quantity" required="required" type="number" min="1" class=" inputFieldsOrder" placeholder="Quantity">
										</td>
									</div>

									<div>
										<input name="order" class="uisignupbutton signupbutton" type="submit" value="Confirm Order" style="width: 63%;">
									</div>

									<div class="signup_error_msg"> '; ?>
										<?php if (isset($error_message)) {echo $error_message;}?>
										<?php echo '
									</div>

								</div>
							</form>
						';
					}
				 ?>
					</h3>
				</div>

			</div>
		</div>
		
		<div style="width: 27%;float: left; margin-left: 260px;">
			<?php
				echo '
					<ul style="float: left;">
						<li style="float: left; padding: 0px 25px 25px 25px;">
							<div class="home-prodlist-img">
								<img src="image/products/'.$item.'/'.$picture.'" class="order-img">
								<div class="itemDescription"> 
									<span style="font-size: 15px;">'.$name.'</span> - '.$price.'$
								</div>	
							</div>
						</li>
					</ul>
				';
			?>
		</div>
	</div>
</body>
</html>
