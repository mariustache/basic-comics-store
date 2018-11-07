<!DOCTYPE html>
<html>
	<head>
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<script src="js/jquery-3.1.1.min.js"></script>
	</head>
	<?php
		session_start();
		if($_SESSION['user']){
			$nume = $_SESSION['nume'];
			$prenume = $_SESSION['prenume'];
		}
		else 
		{
			header("location:index.php");
		}
		$user = $_SESSION['user'];
	?>
	<body>
	<div class="row">
	<nav class ="navbar navbar-inverse navbar-fixed-top">
		<div class="container-fluid">
			<!--Meniul principal-->
			<div class="col-md-4">
				<div class="navbar-header">
					<a class="navbar-brand">Benzi Desenate</a>
				</div>
				<ul class="nav navbar-nav">
					<li class="active"><a href="home.php">
					<span class="glyphicon glyphicon-home"></span> Acasa</a></li>
					<li><a href="products_home.php">Produse</a></li>
					<li><a href="cart.php">
					<span class="glyphicon glyphicon-shopping-cart"></span> Cos</a></li>
				</ul>
			</div>
			<div class="col-md-4"></div>
			<div class="col-md-4">
				<div class="navbar-header pull-right">
					<a class="navbar-brand">
						<?php Print "Bun venit, $nume " . "$prenume!" ?>
					</a>
				</div>
				<ul class="nav navbar-nav pull-right">
					<li class="pull-right"><a class="nav navbar-nav" href="logout.php" >
					<span class="glyphicon glyphicon-log-out"></span> Log out</a></li>
				</ul>
			</div>
		</div>
	</div>
	<br><br>
	<!--Afisare de tip carusel-->
	<div id="myCarousel" class="carousel slide" data-ride="carousel">
		  <!-- Indicatori -->
		  <ol class="carousel-indicators">
			<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
			<li data-target="#myCarousel" data-slide-to="1"></li>
			<li data-target="#myCarousel" data-slide-to="2"></li>
		  </ol>

		  <!-- Wrapper for slides -->
		  <center>
			<div class="carousel-inner" role="listbox">
				<div class="item active">
				  <img src="imag\dc_comics.jpg">
				</div>

				<div class="item">
				  <img src="imag\marvel_comics.jpg">
				</div>

				<div class="item">
				  <img src="imag\comics.jpg">
				</div>
			</div>

			  <!-- Butoanele stanga/dreapta -->
			  <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
				<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
				<span class="sr-only">Previous</span>
			  </a>
			  <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
				<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
				<span class="sr-only">Next</span>
			  </a>  
		</center>
	</div>
		<script src="js/bootstrap.min.js"></script>
	</body>
</html>