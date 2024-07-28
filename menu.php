<?php
include ('connect.php');
session_start();

?>
<?php
function formatCurrency($number)
{
	return '<span class="format-currrency">Rs. </span>' . number_format($number, 2);
}

?>

<!DOCTYPE html>
<html>

<head>
	<title></title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
		integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
		crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link rel="stylesheet" type="text/css" href="style.css">


</head>

<body>
	<div class="addcart" id="addcart">
		<div class="addcartitem" id="addcartitem">
			<button id="close">x</button>
			<p class="cart_title"> </p>
			<br>
			<p class="cart_price" style="font-size: 25px;opacity: 0.8;"></p>
			<br>
			<hr>
			<br>
			<span>Special Instructions</span>
			<br>
			<textarea placeholder="Add notes." id="instruct"></textarea>
			<br>
			<div id="quantity">
				<button id="decrease"> - </button>
				<input type="number" name="" disabled id="food-quantity">
				<button id="increase"> + </button>

				<button id="submit">
					<p>Add to Bag
						<span id="total" style="padding-left: 80px;">

						</span>
					</p>
				</button>
			</div>
		</div>
	</div>
	<section class="header">
		<nav style="height: 7vh ; box-shadow: none;">
			<a href="index.php"><img src="images/logo.png"></a>
			<div class="nav-links">
				<ul>
					<li><a href="index.php">HOME</a> </li>
					<li><a href="menu.php">MENU</a> </li>
					<?php
					if (!isset($_SESSION['email'], $_SESSION['username'])) {
						echo "<li><a href='login.php'>LOGIN</a> </li>
							<li><a href='register.php' >REGISTER</a> </li>";
					} else {
						echo "<li><a href='cart.php'>BAG</a> </li>";
						echo "<li><a href='account.php'>MY ACCOUNT</a> </li>";
						echo "<li><a href='logout.php'>LOGOUT</a> </li>";
					}
					?>
				</ul>

			</div>
		</nav>

	</section>

	<section class="menubody">
		<div class="menubox">
			<img src="images/banner1.jpg">
			<div class="search">
				<input type="text" name="search" id="search" placeholder="Search Menu Items">
				<input type="button" name="searchbtn" value="Search" id="searchbtn">

			</div>


		</div>


		<div class="menulist">
			<div id="menu-header">
				<span id="span1">Categories</span>
				<span id="span2">Food Items</span>
				<span id="span3">Review</span>
			</div>
			<div class="category-list">
				<div>

					<?php

					$q = "SELECT cid,title FROM category WHERE active='Yes'";
					$res = mysqli_query($con, $q);

					if (mysqli_num_rows($res) > 0) {

						while ($row = mysqli_fetch_assoc($res)) {
							echo "<button class='categorybtn'>" . $row['title'] . "</button>";
						}
					} else {
						echo "No category found.";
					}

					?>
				</div>
			</div>

			<div class="food-list">

				<?php

				if (isset($_POST['searchqbtn'])) {

					$search = mysqli_real_escape_string($con, $_POST['searchq']);

					echo "<br><p style='margin-left: 17px;'>Search Result for  \" " . $search . " \" </p>";
					$q = "SELECT fid,title,description,price,image_name FROM food WHERE active='Yes' AND title LIKE '%$search%' OR description LIKE '%$search%' ";

				} elseif (isset($_GET['category'])) {

					$c = $_GET['category'];

					$q = "SELECT fid,title,description,price,image_name FROM food WHERE active='Yes' AND category_id='$c' ORDER BY title";
				} else {

					$q = "SELECT fid,title,description,price,image_name FROM food WHERE active='Yes' ORDER BY title ";
				}
				$res = mysqli_query($con, $q);

				if (mysqli_num_rows($res) > 0) {

					while ($row = mysqli_fetch_assoc($res)) {
						echo "<div class='food-items'>
									<h6 class='title'>" . $row['title'] . "</h6>
									<div class='divimage'>
										<img src='food/" . $row['image_name'] . "'>
									</div>
									<div class='divdesc'>" . $row['description'] . "</div>
									<div class='divprice'>
										<span class='price'> " . formatCurrency($row['price']) . "</span>&nbsp;&nbsp;
										<div class='actions'>
											<a  class='cart'><i class='fa-solid fa-cart-shopping cart-icon'></i></a>
											<button class='reviewbtn'><i class='fa-solid fa-comment-dots review-icon'></i></button>
										</div>
									</div>
									
									<br>
								</div>";
					}
				} else {
					echo "<p style='margin-left: 17px;'>No food found.</p>";
				}

				?>


			</div>

			<br>
			<div class="reviewbox">


			</div>


		</div>

		<form>
			<input type="hidden" name="foodtitle" value="" id="foodtitle">
			<input type="hidden" name="instruction" value="" id="instruction">
			<input type="hidden" name="quant" value="" id="quant">
			<input type="hidden" name="pric" value="" id="pric">
			<input type="hidden" name="totalamount" value="" id="totalamount">
		</form>

	</section>
	<br>
	<br>
	<br>

	<div id="cartmsg">

	</div>
	<div style="clear: both;"></div>
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
			Copyright © 2021 Yummy Food Inc. All Rights Reserved.

		</div>
	</div>

</body>
<script src="js/jquery-3.6.0.min.js"></script>


<script>
	$(document).ready(function () {
		$('#close').click(function () {
			$('.addcart').fadeOut();
			$('.addcartitem').slideUp('fast');
			$('#quantity').find('#food-quantity').val(1);
			$('#instruction').val('');
			$('#instruct').val('');

		});

		$(document).on("click", ".cart", function () {

			var email = "<?php echo isset($_SESSION['email']); ?>";
			var username = "<?php echo isset($_SESSION['username']); ?>";

			if (email == "" && username == "") {

				window.location = "login.php";

			} else {
				$('.addcart').show();
				$('.addcartitem').show();

				$count = 1;

				var a = $(this).closest('.food-items').find('.price').text().trim();
				var b = $(this).closest('.food-items').find('.title').text().trim();

				var p = a.replace('Rs. ', '');

				$('.addcartitem').find('.cart_title').html(b);
				$('#foodtitle').val(b);
				$('.addcartitem').find('.cart_price').html(a);
				$('#quantity').find('#total').html(a);
				$('#quantity').find('#food-quantity').val(1);

				$('#quant').val(1);
				$('#totalamount').val(p);
				$('#pric').val(p);

			}

		});

		$('#decrease').click(function () {


			var a = $(this).parent().parent().find('.cart_price').html();
			var p = a.substr(3, 5);

			var $c = $(this).parent().find('#food-quantity');

			var amount = Number($c.val());

			if (amount > 1) {
				var g = $c.val(amount - $count);
				var h = p * (amount - $count);

				var $d = $(this).parent().find('#total');

				$d.html('Rs ' + h);

				$('#quant').val($c.val());

				$('#totalamount').val('Rs ' + h);

			}

		});

		$('#increase').click(function () {

			var a = $(this).parent().parent().find('.cart_price').html();
			var p = a.substr(3, 5);

			var $c = $(this).parent().find('#food-quantity');

			var amount = Number($c.val());

			var g = $c.val(amount + $count);

			var h = p * (amount + $count);

			var $d = $(this).parent().find('#total');

			$d.html('Rs ' + h);

			$('#quant').val($c.val());

			$('#totalamount').val('Rs ' + h);



		});


		$('#instruct').keyup(function () {

			$('#instruction').val($('#instruct').val());
		});



		$('#submit').click(function () {
			var foodtitle = $('#foodtitle').val();
			var instruction = $('#instruction').val();
			var quant = $('#quant').val();
			var pric = $('#pric').val();
			var totalamount = $('#totalamount').val();

			$('.addcart').fadeOut();
			$('.addcartitem').fadeOut('fast');
			$('#instruction').val('');
			$('#instruct').val('');

			$.ajax({
				type: 'POST',
				url: 'add-cart.php',
				data: {
					foodtitle: foodtitle,
					instruction: instruction,
					quant: quant,
					pric: pric,
					totalamount: totalamount
				},
				cache: false,

				success: function (data) {

					$('#cartmsg').text(data);
					$('#cartmsg').show('fast');
					$('#cartmsg').delay(2000);
					$('#cartmsg').hide(500);

				},

				error: function (xhr, status, error) {
					console.error(xhr);
				}
			});


		});


		$(".categorybtn").click(function () {
			$(".categorybtn").css("font-weight", "normal");
			var a = $(this).html();
			$(this).css("font-weight", "bold");

			$(".reviewbox").hide();

			$.ajax({
				type: 'POST',
				url: 'get-food.php',
				data: {
					food: a
				},
				cache: false,

				success: function (data) {

					$('.food-list').html(data);

				},

				error: function (xhr, status, error) {
					console.error(xhr);
				}
			});
		});


		$("#searchbtn").click(function () {
			$(".reviewbox").hide();
			var a = $("#search").val();
			if (a == "") {

			} else {

				$.ajax({
					type: 'POST',
					url: 'search.php',
					data: {
						searchquery: a
					},
					cache: false,

					success: function (data) {

						$('.food-list').html(data);

					},

					error: function (xhr, status, error) {
						console.error(xhr);
					}
				});
			}
		});


		$(document).on("click", ".reviewbtn", function () {

			<?php

			if (isset($_SESSION['email']))
				echo "var email ='" . $_SESSION['email'] . "';";
			else
				echo "var email ='email';";
			?>


			$(".reviewbox").show();
			var b = $(this).closest('.food-items').find('.title').text().trim();

			$.ajax({
				type: 'POST',
				url: 'get-review.php',
				data: {
					food: b,
					email: email
				},
				cache: false,

				success: function (data) {

					$(".reviewbox").html(data);

				},

				error: function (xhr, status, error) {
					console.error(xhr);
				}
			});


		});

		<?php
		if (isset($_SESSION['email']))
			echo "
						$(document).on('click','.sendreview',function(){

							var a = $('.reviewtext').val();
							a=a.replace(/(\\r\\n|\\n|\\r|<|>|;|\"|{|})/gm, '');
							var regex = /^[a-zA-Z0-9\s,.'\-:&@]{2,}$/;
							var userid = " . $_SESSION['userid'] . ";

							var food = $(this).parent().parent().find('.reviewtitle').html();

							if(regex.test(a)===false){
								
							}else{
								
								$.ajax({
								type:'POST',
								url:'send-review.php',
								data:{
									review:a,
									userid:userid,
									food:food
								},
								cache:false,
								
								success: function (data) {

									$('.review label').hide();
				        			$('.review').append(data);
				        			$('.reviewtext').val('');

				    			},
								
								 error: function(xhr, status, error) {
				                    console.error(xhr);
				                }
								});
							}

						});

						";
		?>


	});


</script>


<script>
	if (window.history.replaceState) {
		window.history.replaceState(null, null, window.location.href);
	}
</script>




</html>