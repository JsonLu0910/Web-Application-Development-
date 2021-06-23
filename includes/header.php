<html>
	<?php 
		if($_SESSION['gender'] == 'female')
		{
			$womanish = '
				<style type="text/css">
					.nav ul{ background-color: rgb(255, 248, 254); }
					.nav ul li a { color:black;}
					.nav ul li a:hover { background-color:rgb(255, 236, 252); }
					.dropcontent a { background-color : rgb(255, 248, 254); color:black; box-shadow: 4px 3px rgb(255, 236, 252);}
					.dropcontent a:hover { background-color:rgb(255, 236, 252); }
					.sidebar { background-color: rgb(255, 248, 254); }
					.sidebar a { background-color: rgb(255, 248, 254); color:black;}
					.sidebar a:hover { background-color:rgb(255, 236, 252); }
					.openbtn { background-color : rgb(255, 248, 254); color:black; border:none;}
					.openbtn:hover { background-color:rgb(255, 236, 252); }
					h3.heading { background-color: rgb(255, 248, 254); color:black; box-shadow: 4px 3px rgb(255, 236, 252);}
					.btn-cart{ background-color:pink; color:black;}
				</style>
			';
			echo $womanish;
		}
	?>
	<header class="header">
		<div class="header-username">
			<?php
				if($_SESSION['loggedIn'] == 1)
				{
					echo "<p>Welcome, " .$_SESSION['username']. " | <a href='logout.php' style='text-decoration:none'>logout</a></p>";
				}
				else if($_SESSION['loggedIn'] == 0)
				{
					echo "<p><a href='index.php' style='text-decoration:none'>login</a></p>";
				}
			?>
		</div>
		<br/>
		<div class='headerTop'>               
			<a href="maindashboard.php"><img src="image/logos.png" alt="LOGO" height="75px" width="300px"></a>
			<div class='widget'>
			<input type="text" id="search" placeholder="Search..">
			<input type="image" src="image/search-icon.jpg" alt="Submit" width="36px" height="36px" onclick="search(); return false;">
			<input type="image" src="image/cart-icon.png" alt="Submit" width="36px" height="36px" style="margin-left: 10px;" onclick="goToCart()">
			</div>
		</div>
		<script>
			function goToCart()
			{
				window.location = "cart.php";
			}
		</script>
	</header>
</html>