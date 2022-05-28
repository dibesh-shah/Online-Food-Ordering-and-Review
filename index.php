<?php
	include('connect.php');
	session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<section class="header">
		<nav>
			<a href="index.php"><img src="images/logo.png"></a>
			<div class="nav-links">
				<ul>
					<li><a href="">HOME</a> </li>
					<li><a href="menu.php">MENU</a> </li>
					<?php 
						if (!isset($_SESSION['email'])) {
							echo"<li><a href='login.php'>LOGIN</a> </li>
							<li><a href='register.php' >REGISTER</a> </li>";
						}else{
							echo"<li><a href='cart.php'>BAG</a> </li>";
							echo"<li><a href='account.php'>MY ACCOUNT</a> </li>";
							echo"<li><a href='logout.php'>LOGOUT</a> </li>";
						}
					?>
				</ul>
				
			</div> 
		</nav>
		

	</section>
	<section class="body" >

		

		<div class="main-body">
			<div class="homediv"><h5>Life is too short to<br/> eat bad food.</h5> 
				<p>
					Foods and drinks available for delivery at your doorsteps.
				</p>
				<br>
				<br>
				<div class="search">
					<form action="menu.php" method="POST">
						<input type="text" name="searchq" placeholder="Search Menu Items">
						<input type="submit" name="searchqbtn" value="Search">
					</form>
				</div>
				<br>

			</div>

			<div class="rimage " ><img src="images/image1.png"  id="image"></div>

		</div>
		</section>
		<br>
		<br>
		<br>

		<div class="featured">
			<br><br>
			<h2>Featured Category</h2>
			<br>
			<?php

			$q = "SELECT cid,image_name FROM category WHERE featured='Yes' LIMIT 8";

			$res = mysqli_query($con,$q);

			while($row=mysqli_fetch_assoc($res)){
				echo"<div class='imagehover'><a href='menu.php?category=".$row['cid']."'><img src='category/".$row['image_name']."'></a></div>";
			}

			?>	
			
		</div>

		<div class="featuredfood ">
			<br>
			<h2>Featured Food</h2>

			<?php

			$q = "SELECT fid,title,description,image_name,price FROM food WHERE featured='Yes' LIMIT 8";

			$res = mysqli_query($con,$q);

			while($row = mysqli_fetch_assoc($res)){

				$description = substr($row['description'],0,70) . "...";

				echo"<div class='ffood'>
					<img src='food/".$row['image_name']."'>
					<p class='title'>".$row['title']."</p>
					<span>".$description."</span>
					<p class='price'>Rs ".$row['price']."</p>

					<button class='addbagbtn'>Add to Bag</button>
					</div>
				";
			}

			?>

			
			
			<br>
			<a href="menu.php"><button id="seemenu">See Menu</button><a>

		</div>


		
		
	<!-- <div class="aboutus">
		<div class="desc">
			<img src="images/banner.jpg">
			<br>
			<h3>Wide variety of Foods</h3>
			<p>We make sure you will not run out of food choices as foods list is updated regularly. And there is always something special that you may have never heard of.</p>
		</div>
		<div class="desc">
			<img src="images/banner1.jpg">
			<br>
			<h3>Unbiased Reviews and Opinions</h3>
			<p>The food reviews are free from Bias as they are provided by people like you. People can express the taste of foods to others in the web using the platform.</p>
		</div>
		<div class="desc">
			<img src="images/banner.jpg">
			<br>
			<h3>Find the Perfect choice</h3>
			<p>Based on the reviews and ratings one can find their perfect choice of foods for their hunger. Also one can help others by reviewing the foods.</p>
		</div>
	</div> -->



	<br>
	<div id="cartmsg" style="background-color: green;">
		
	</div>
	<div style="clear: both;"></div><br>

	<div class="footer">
		<br>
		<div class="wrap text-center">
			
			<a href="">Sitemap</a>|
			<a href="">Privacy Policy</a>|
			<a href="">Terms of Use</a>|
			<a href="">Terms and Conditions</a>

			<br><br>
			<a href=""> <img src="images/facebook.png"></a>
			<a href=""> <img src="images/instagram.png"></a>
			<a href=""> <img src="images/twitter.png"></a>
			<a href=""> <img src="images/github.png"></a>
			<a href=""> <img src="images/google.png"></a>

			

			<br><br>
			Copyright © 2021  Yummy Food Inc.  All Rights Reserved.
			
		</div>
	</div>
	



</body>

<script src="js/jquery-3.6.0.min.js"></script>

<script>

	$(document).ready(function(){

		$('.addbagbtn').click(function(){

			var email = "<?php echo isset($_SESSION['email']); ?>";
			var username = "<?php echo isset($_SESSION['username']); ?>";
					
			if(email=="" && username==""){

				window.location="login.php";
				
			}else{
				var title = $(this).parent().find('.title').html();
				var price = $(this).parent().find('.price').html();

				$.ajax({
					type:'POST',
					url:'add-cart.php',
					data:{
						foodtitle:title,
						price:price,
						page:"index"
					},
					cache:false,
					success: function (data) {

	        			$('#cartmsg').text(data);
	        			$('#cartmsg').show('fast');
	        			$('#cartmsg').delay(2000);
	        			$('#cartmsg').hide(500);

	    			},
					
					 error: function(xhr, status, error) {
	                    console.error(xhr);
	                }
				});
			}


		});
	});


</script>


</html>