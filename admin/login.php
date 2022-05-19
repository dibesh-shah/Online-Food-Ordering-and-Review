<?php 
	session_start();
	if(isset($_SESSION['adminemail'],$_SESSION['role'])){
		header('location:dashboard.php');
	}

?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="../style.css">
</head>
<body >



</div> 
<br>
<div class="text-center">
	<a href="index.php"><img src="../images/logo.png" height="80px" width="90px"></a>
	<br>
	<br>
	<h2>Sign in to Admin Panel</h2>
	<br>
		<?php
		if (isset($_GET['success'])) {
              $res=$_GET['success'];
					
				if ($res == "invalid") {
				   echo "<div class='create-acc' style='color: green; background-color:red; margin-bottom:15px; padding:1% 1.5%;'>Invalid Credentials.</div>";
				}			
			}
	?>

	<div class="login">
		<form action="" method="post">
			<h5>Email</h5>
			<input type="text" name="email"  required>
			<br><br>
			<h5>Password</h5>
			<input type="password" name="password" required>
			<br><br>
			<h5>Code</h5>
			<input type="password" name="code" required>
			<br><br>
			<input type="submit" name="submit" value="Sign in">
		</form>
	</div>
	<br>
	<br>
	<div class="loginfooter">
		<a href="">Terms</a>
		<a href="">Privacy</a>
		<a href="">Sitemap</a>
		<a href="">Contact</a>
	</div>
</div>


</body>
</html>

<?php
	
if(isset($_POST['submit']))	{
	include('../connect.php');

	$email=mysqli_real_escape_string($con,$_POST['email']);

	$password=md5($_POST['password']);

	$code=mysqli_real_escape_string($con,$_POST['code']);


		$q="SELECT firstname,email ,password FROM `userinfo` WHERE firstname='$code' AND email='$email' AND password='$password'";

		$res=mysqli_query($con,$q);

		if ($res) {

			if (mysqli_num_rows($res) == 1) {

				$row=mysqli_fetch_assoc($res);

				$_SESSION['adminemail']=$row['email'];

				$_SESSION['role']= "admin";

				header('location:dashboard.php');

			}else{

				header('location:login.php?success=invalid');

				die();
			}
		}

}

		
		
?>