<!-- start of header -->

<header class="site-header">
	<nav class="navbar navbar-expand-lg navbar-custom navbar-static-top" id="mainNav" style="background-color: #11233c; padding: 0;">
	<div class="container-fluid">
	  <a class="navbar-brand js-scroll-trigger" href="index.php">
		<h2></h2>
	   <img class="img-responsive" src="images/esd_icon.png" >
	   <img class="img-responsive" src="images/esd_icon_words.png" >
	  </a>
	  
	  <button class="navbar-toggler custom-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation" >
		<span class="navbar-toggler-icon"></span>
	  </button>
	  <div class="collapse navbar-collapse justify-content-end" id="navbarResponsive">
		<ul class="navbar-nav ml-auto">
		  <li class="nav-item active">
			<a class="nav-link" href="index.php"><h6>Home</h6> <span class="sr-only">(current)</span></a>
		  </li>
		  <li class="nav-item">
			<a class="nav-link" href="about.php"><h6>About Us</h6></a>
		  </li>
		  <?php
			  if (isset($_SESSION["email"])) {
				$email = $_SESSION["email"];
				  echo " <li class='nav-item'>
				  <a class='nav-link' href='create_itinerary.php'><h6>Create Itinerary</h6></a>
				  </li>
				  <li class='nav-item'>
				  <a class='nav-link' href='account.php'><h6>Account</h6></a>
				  </li>
				  <li class='nav-item'>
				  <a class='nav-link' href='checkout.html?email=$email'><h6>Cart</h6></a>
				  </li>";
			  }
		  ?>
			<?php
			//TO REMOVE LATER
			$_SESSION["role"] = "user";
			  if ($_SESSION["role"] == "admin") {
				  echo " <li class='nav-item'>
				  <a class='nav-link' href='approve.php'><h6>Approvals</h6></a>
				  </li>";
			  }
		  ?>
		  <li class='nav-item'>
		  <?php
			  if (!isset($_SESSION["email"])) {
				  echo "<a class='nav-link' href='login.php'><h6>Login</h6></a>";
			  }
			  else {
				  echo "<a class='nav-link' href='objects/ProcessLogout.php'><h6>Signout</h6></a>";
			  }
		  ?>
		  </li>
		</ul>
	  </div>
	</div>
  </nav>
</header>
<!-- end of header -->