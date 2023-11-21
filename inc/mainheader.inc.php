<div class="homepageheader" style="position: relative;">
			<div class="signinButton loginButton">
				<div class="uiloginbutton signinButton loginButton" style="margin-right: 40px;">
					<?php 
						if ($user!="") {
							echo '<a style="text-decoration: none; color: #fff;" href="../logout.php">Log Out</a>';
						}
						else {
							echo '<a style="text-decoration: none; color: #fff;" href="../signin.php">Sign Up</a>';
						}
					 ?>
					
				</div>
				<div class="uiloginbutton signinButton loginButton" >
					<?php 
						if ($user!="") {
							echo '<a style="text-decoration: none; color: #fff;" href="../profile.php?uid='.$user.'">Hi '.$uname_db.'</a>';
						}
						else {
							echo '<a style="text-decoration: none; color: #fff;" href="../login.php">Log In</a>';
						}
					 ?>
				</div>
			</div>
			<div style="float: left; margin: 5px 0px 0px 23px;">
				<a href="../index.php">
					<img class="icon" src="../image/icon.png">
				</a>
			</div>
			<div >
				<form id="newsearch" method="get" action="../search.php" style="margin-top: 7px;">
					<input type="text" class="srctextinput" name="keywords" 
					size="21" maxlength="120"  placeholder="Search Here...">
					<input type="submit" value="Search" class="srcbutton" >
				</form>
			</div>
		</div>
