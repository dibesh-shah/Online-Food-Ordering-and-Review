<?php 
	session_start();
	if(!isset($_SESSION['adminemail'],$_SESSION['role'])){
        header('location:login.php');
        die();
    }

	include('../connect.php');

?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="../style.css">
	<style type="text/css">
		span{
			padding: 5px;
		}

		h1{
			/*color: red;*/
		}
		h2{
			/*color: purple;*/
		}
	</style>
</head>
<body>
	<div class="sidebar text-center">
		<img src="../images/logo.png">
		<br>
		<h4 style="font-size: 17px;font-weight: 600;color: rgb(206, 240, 253);">ADMIN</h4>
		<br>
		<div class="innerside">
            <a href="dashboard.php">Dashboard</a>
            <a href="add-category.php">Add Category</a>
            <a href="manage-category.php">Manage Category</a>
            <a href="add-food.php">Add Food</a>
            <a href="manage-food.php">Manage Food</a>
            <a href="order-list.php">Order List</a>
            <a href="searchorder.php">Search Order</a>
            <a href="salesreport.php">Sales Report</a>
        </div>
        <div style="bottom: 10px;left: 14px; position: fixed; color: #B4B4B4;">
            <h6>Copyright@2022 Food Inc.</h6>
        </div>
		
	</div>
	<div class="restlist" >
		<div class="restheader">
			<img src="../images/logo.png" height="50px" width="60px" >
			<div class="logoutbtn"><a href="logout.php">Logout</a></div>
		</div>
		<br>
		<div class="restaurants">

			<div class="restaurants-list text-center">
				
				<h2>Category</h2>
				<?php 
					$q = "SELECT COUNT(*) as f FROM category ";
					$res = mysqli_query($con,$q);
					$row = mysqli_fetch_assoc($res);
						
					echo"<h5>".$row['f']."</h5>";
				?>
				
				<div class="dashstatus">
					<span >
						<?php 
							$q = "SELECT COUNT(*) as f FROM category WHERE featured='Yes' ";
							$res = mysqli_query($con,$q);
							$row = mysqli_fetch_assoc($res);
						
							echo"<i>Featured : ".$row['f']."</i>";
						?>
					</span>
					<br>
					<span >
						<?php 
							$q = "SELECT COUNT(*) as f FROM category WHERE active='Yes' ";
							$res = mysqli_query($con,$q);
							$row = mysqli_fetch_assoc($res);
						
							echo"<i>Active : ".$row['f']."</i>";
						?>
					</span>
				</div>

			</div>

			<div class="restaurants-list text-center">
				
				<h2>Food Items</h2>
				<?php 
					$q = "SELECT COUNT(*) as f FROM food ";
					$res = mysqli_query($con,$q);
					$row = mysqli_fetch_assoc($res);
						
					echo"<h5>".$row['f']."</h5>";
				?>
				<div class="dashstatus">
					<span >
						<?php 
							$q = "SELECT COUNT(*) as f FROM food WHERE featured='Yes' ";
							$res = mysqli_query($con,$q);
							$row = mysqli_fetch_assoc($res);
						
							echo"<i>Featured : ".$row['f']."</i>";
						?>
					</span>
					<br>
					<span >
						<?php 
							$q = "SELECT COUNT(*) as f FROM food WHERE active='Yes' ";
							$res = mysqli_query($con,$q);
							$row = mysqli_fetch_assoc($res);
						
							echo"<i>Active : ".$row['f']."</i>";
						?>
					</span>
				</div>

			</div>

			<div class="restaurants-list text-center">
				
				<h2>User</h2>
				<?php 
					$q = "SELECT COUNT(*) as f FROM userinfo ";
					$res = mysqli_query($con,$q);
					$row = mysqli_fetch_assoc($res);
					$c=$row['f']-1;
					echo"<h5>".$c."</h5>";
				?>

			</div>

			<div class="restaurants-list text-center">
				
				<h2>Review</h2>
				<?php 
					$date = date("Y"); 
					$q = "SELECT COUNT(*) as f FROM review WHERE `date` LIKE '$date%'";
					$res = mysqli_query($con,$q);
					$row = mysqli_fetch_assoc($res);
						
					echo"<h5>".$row['f']."</h5>";
				?>
				<div class="dashstatus">
					<span >
						<?php 
							$q = "SELECT COUNT(*) as f FROM review WHERE week(`date`)=week(CURDATE())";
							$res = mysqli_query($con,$q);
							$row = mysqli_fetch_assoc($res);
						
							echo"<i>This Week : ".$row['f']."</i>";
						?>
					</span>
					<br>
					<span >
						<?php 
							$q = "SELECT COUNT(*) as f FROM review WHERE month(`date`)=month(CURDATE())";
							$res = mysqli_query($con,$q);
							$row = mysqli_fetch_assoc($res);
						
							echo"<i>This Month : ".$row['f']."</i>";
						?>
					</span>
				</div>

			</div>

			<div class="restaurants-list text-center"  style="grid-column-start: 1;grid-column-end: 3;">
				
				<h2>Order</h2>
				<?php 
					$date = date("Y"); 
					$q = "SELECT SUM(quantity) as f FROM `order` WHERE `order-date` LIKE '$date%' and status<>'cart' and status<>'cancelled' ";
					$res = mysqli_query($con,$q);
					$row = mysqli_fetch_assoc($res);
						
					echo"<h5>".$row['f']."</h5>";
				?>
				<div class="dashstatus">
					<span >
						<?php 
							$date = date("Y-m-d"); 
							$q = "SELECT SUM(quantity) as f FROM `order` WHERE `order-date` LIKE '$date%' and status<>'cart' and status<>'cancelled'";
							$res = mysqli_query($con,$q);
							$row = mysqli_fetch_assoc($res);
						
							echo"<i>Today : ".$row['f']."</i>";
						?>
					</span>
					<br>
					<span >
						<?php 
							$q = "SELECT SUM(quantity) as f FROM `order` WHERE week(`order-date`)=week(CURDATE()) and status<>'cart' and status<>'cancelled'";
							$res = mysqli_query($con,$q);
							$row = mysqli_fetch_assoc($res);
						
							echo"<i>This Week : ".$row['f']."</i>";
						?>
					</span>
					<br>
					<span >
						<?php 
							$sdate = date("Y-m"); 
							$sdate = $sdate."-01";
							$ldate = date("Y-m-t");
							$q = "SELECT SUM(quantity) as f FROM `order` WHERE status<>'cart' and status<>'cancelled' and `order-date` BETWEEN '$sdate' and '$ldate'";
							$res = mysqli_query($con,$q);
							$row = mysqli_fetch_assoc($res);
						
							echo"<i>This Month : ".$row['f']."</i>";
						?>
					</span>
				</div>

			</div>

			<div class="restaurants-list text-center " style="grid-column-start: 3;grid-column-end: 5;">
				
				<h2>Revenue</h2>
				<?php 
					$date = date("Y"); 
					$q = "SELECT SUM(total) as f FROM `order` WHERE `order-date` LIKE '$date%' and status='delivered'";
					$res = mysqli_query($con,$q);
					$row = mysqli_fetch_assoc($res);
						
					echo"<h5>Rs ".number_format($row['f'])."</h5>";
				?>
				<div class="dashstatus">
					<span >
						<?php 
							$date = date("Y-m-d"); 
							$q = "SELECT SUM(total) as f FROM `order` WHERE `order-date` LIKE '$date%' and status='delivered'";
							$res = mysqli_query($con,$q);
							$row = mysqli_fetch_assoc($res);
						
							echo"<i>Today : Rs ".number_format($row['f'])."</i>";
						?>
					</span>
					<br>
					<span >
						<?php 
							$q = "SELECT SUM(total) as f FROM `order` WHERE week(`order-date`)=week(CURDATE()) and status='delivered'";
							$res = mysqli_query($con,$q);
							$row = mysqli_fetch_assoc($res);
						
							echo"<i>This Week : Rs ".number_format($row['f'])."</i>";
						?>
					</span>
					<br>
					<span >
						<?php 
							$sdate = date("Y-m"); 
							$sdate = $sdate."-01";
							$ldate = date("Y-m-t");
							$q = "SELECT SUM(total) as f FROM `order` WHERE status='delivered' and`order-date` BETWEEN '$sdate' and '$ldate'";
							$res = mysqli_query($con,$q);
							$row = mysqli_fetch_assoc($res);
						
							echo"<i>This Month : Rs ".number_format($row['f'])."</i>";
						?>
					</span>
				</div>

			</div>

			<div class="restaurants-list text-center"  style="grid-column-start: 1;grid-column-end: 3;">
				
				<h2>Most Ordered Food</h2>
				<?php 
					$date = date("Y"); 
					$q = "SELECT food, SUM(quantity) from `order`  WHERE `order-date` LIKE '$date%' and status<>'cart' and status<>'cancelled' GROUP BY food ORDER BY SUM(quantity) DESC LIMIT 1";
					$res = mysqli_query($con,$q);
					$row = mysqli_fetch_assoc($res);
						
					echo"<h1><i>".$row['food']."</i></h1>";
				?>
				<div class="dashstatus">
					
					<span >
						<?php
							$q = "SELECT food, SUM(quantity) from `order` WHERE week(`order-date`)=week(CURDATE()) and status<>'cart' and status<>'cancelled' GROUP BY food ORDER BY SUM(quantity) DESC LIMIT 1";
							$res = mysqli_query($con,$q);
							if(mysqli_num_rows($res)==1){
								$row = mysqli_fetch_assoc($res);
							
								echo"<i>This Week : ".$row['food']."</i>";
							}else{
								echo"<i>This Week : No Order</i>";
							}
						?>
					</span>
					<br>
					<span >
						<?php 
							$sdate = date("Y-m"); 
							$sdate = $sdate."-01";
							$ldate = date("Y-m-t");
							$q = "SELECT food, SUM(quantity) from `order` WHERE `order-date` BETWEEN '$sdate' and '$ldate' and status<>'cart' and status<>'cancelled' GROUP BY food ORDER BY SUM(quantity) DESC LIMIT 1";
							$res = mysqli_query($con,$q);
							if(mysqli_num_rows($res)==1){
								$row = mysqli_fetch_assoc($res);
							
								echo"<i>This Month : ".$row['food']."</i>";
							}else{
								echo"<i>This Month : No Order</i>";
							}
						?>
					</span>
				</div>

			</div>


			<div class="restaurants-list text-center"  style="grid-column-start: 3;grid-column-end: 5;">
				
				<h2>Most Reviewed Food</h2>
				<?php 
					$date = date("Y"); 
					$q = "SELECT food, COUNT(food) from review WHERE `date` LIKE '$date%' GROUP BY food ORDER BY COUNT(food) DESC";
					$res = mysqli_query($con,$q);
					$row = mysqli_fetch_assoc($res);
						
					echo"<h1><i>".$row['food']."</i></h1>";
				?>
				<div class="dashstatus">
					
					<span >
						<?php 
							$q = "SELECT food, COUNT(food) from review WHERE week(`date`)=week(CURDATE()) GROUP BY food ORDER BY COUNT(food) DESC LIMIT 1";
							$res = mysqli_query($con,$q);
							if(mysqli_num_rows($res)==1){
								$row = mysqli_fetch_assoc($res);
							
								echo"<i>This Week : ".$row['food']."</i>";
							}else{
								echo"<i>This Week : No Review</i>";
							}
						?>
					</span>
					<br>
					<span >
						<?php 
							
							$q = "SELECT food, COUNT(food) from review WHERE month(`date`)=month(CURDATE()) GROUP BY food ORDER BY COUNT(food) DESC LIMIT 1";
							$res = mysqli_query($con,$q);
							if(mysqli_num_rows($res)==1){
								$row = mysqli_fetch_assoc($res);
							
								echo"<i>This Month : ".$row['food']."</i>";
							}else{
								echo"<i>This Month : No Review</i>";
							}
						?>
					</span>
				</div>

			</div>
			

		</div>
	</div>
</body>
</html>