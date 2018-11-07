<!DOCTYPE html>
<html>
  <head>
    <title>Magazin benzi desenate</title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
	<div class="row">
	<nav class ="navbar navbar-inverse navbar-fixed-top">
		<div class="container-fluid">
			<!--Meniul principal -->
			<div class="col-md-4">
				<div class="navbar-header">
					<a class="navbar-brand">Benzi Desenate</a>
				</div>
				<ul class="nav navbar-nav">
					<li><a href="index.php">
					<span class="glyphicon glyphicon-home"></span> Acasa</a></li>
					<li class="active"><a href="products.php">Produse</a></li>
				</ul>
			</div>
			
			<!--Log in/Sign up-->
			<div class="col-md-4"></div>
			<div class="col-md-4">
				<ul class="nav navbar-nav pull-right">
					<li class="pull-right">
						<a href="signup.php" class="nav navbar-nav">
						<span class="glyphicon glyphicon-user"></span> Sign up</a>
					</li>
					<li class="pull-right"><a class="nav navbar-nav" href="login.php" >
					<span class="glyphicon glyphicon-log-in"></span> Log in</a></li>
				</ul>
			</div>
		</div>
	</nav>
	</div><br></br><br></br>
	<!--Search form-->
	<form class="navbar-form navbar-left" action="products.php" method="POST">
		<div class="input-group">
			<input name="search" type="text" class="form-control" placeholder="Cauta produs">
			<div class="input-group-btn">
				<button type="submit" class="btn btn-default">
					<i class="glyphicon glyphicon-search"></i>
				</button>
			</div>
		</div>
	</form>
	<br></br><br></br><br></br><br></br>
	<script src="js/bootstrap.min.js"></script>
  </body>
</html>
<?php
	$link = mysqli_connect("localhost", "root") or die(mysqli_error());
	mysqli_select_db($link, "database") or die("Cannot connect to database!");
	//daca am cautat un produs, afisam doar acele produse corespunzatoare;
	//altfel, afisam toate produsele;
	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		$product_searched = mysqli_real_escape_string($link, $_POST['search']);
		$sql = "SELECT nume_numar,imag_location,pret,cantitate FROM numere JOIN imagini ON numere.id_nr=imagini.id_nr
				JOIN banda_desenata ON numere.id_bd=banda_desenata.id_bd WHERE banda_desenata.nume_bd REGEXP '^$product_searched.*'
				ORDER BY nume_numar";
		$query = mysqli_query($link, $sql);
		$count = 0;
		Print '<center>';
		while($row = mysqli_fetch_array($query, MYSQLI_ASSOC))
		{
			$location = strval($row['imag_location']);
			$name     = strval($row['nume_numar']);
			$pret      = strval($row['pret']);
			$cantitate = strval($row['cantitate']);
			if($count == 0)
			{
				Print "<div class='row'>";
			}
			Print "<div class='col-md-4'>
						<img src='$location' class='thumbnail' width='200' height='300'/>
						<b>$name</b>
						<br></br>
						<b>Price:$pret\$</b>";
			if($cantitate > 0)
			{
				Print "<br></br>
				       <b>In stock</b></div>";
			}
			$count = $count + 1;
			if($count == 3)
			{
				Print "</div><br></br><br></br>";
				$count = 0;
			}
		}
		Print '</center>';
	}
	else	
	{
		$sql = "SELECT nume_numar,imag_location,pret,cantitate 
		FROM numere JOIN imagini ON numere.id_nr=imagini.id_nr ORDER BY nume_numar";
		$query = mysqli_query($link, $sql);
		$count = 0;
		Print '<center>';
		while($row = mysqli_fetch_array($query, MYSQLI_ASSOC))
		{
			$location  = strval($row['imag_location']);
			$name      = strval($row['nume_numar']);
			$pret      = strval($row['pret']);
			$cantitate = strval($row['cantitate']);
			if($count == 0)
			{
				Print "<div class='row'>";
			}
			Print "<div class='col-md-4'>
						<img src='$location' class='thumbnail' width='200' height='300'/>
						<b>$name</b>
						<br></br>
						<b>Pret:$pret\$</b>";
			if($cantitate > 0)
			{
				Print "<br></br>
				       <b>In stoc</b></div>";
			}
			$count = $count + 1;
			if($count == 3)
			{
				Print "</div><br></br><br></br>";
				$count = 0;
			}
		}
		Print '</center>';
	}

?>