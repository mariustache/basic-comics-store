<!DOCTYPE html>
<html>
  <head>
    <title>Magazin benzi desenate</title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<?php
		session_start();
		if($_SESSION['user']){
			$nume = $_SESSION['nume'];
			$prenume = $_SESSION['prenume'];
		}
		else
		{
			header("location:products.php");
		}
		$user = $_SESSION['user'];
	?>
  </head>
  <body>
	<div class="row">
	<nav class ="navbar navbar-inverse navbar-fixed-top">
		<div class="container-fluid">
			<!--Main menu -->
			<div class="col-md-4">
				<div class="navbar-header">
					<a class="navbar-brand">Benzi Desenate</a>
				</div>
				<ul class="nav navbar-nav">
					<li><a href="home.php">
					<span class="glyphicon glyphicon-home"></span> Acasa</a></li>
					<li class="active"><a href="products_home.php">Produse</a></li>
					<li><a href="cart.php">
					<span class="glyphicon glyphicon-shopping-cart"></span> Cos</a></li>
				</ul>
			</div>
			
			<!--Log in/Sign up-->
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
	</nav>
	</div>
	<br></br>
	<br></br>
	<!--Search form-->
	<form class="navbar-form navbar-left" action="products_home.php" method="POST">
		<div class="input-group">
			<input name="product" type="text" class="form-control" placeholder="Cauta banda desenata" required="required">
			<div class="input-group-btn">
				<button type="submit" class="btn btn-default">
					<i class="glyphicon glyphicon-search"></i>
				</button>
			</div>
		</div>
	</form>
	<br></br><br></br><br></br><br></br>
	<!--Add to cart script-->
	<script>
		//transmite ca parametru al metodei GET id-ului numarului;
		function add_to_cart(id)
		{
			alert("Product succesfully added to cart.");
			window.location.assign("add_to_cart.php?id_comic=" + id);
		}
	</script>
	<script src="js/bootstrap.min.js"></script>
  </body>
</html>
<?php
	$link = mysqli_connect("localhost", "root") or die(mysqli_error());
	mysqli_select_db($link, "database") or die("Cannot connect to database!");
	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		$product_searched = mysqli_real_escape_string($link, $_POST['product']);
		$sql = "SELECT nume_numar,imag_location,pret,cantitate FROM numere JOIN imagini ON numere.id_nr=imagini.id_nr
				JOIN banda_desenata ON numere.id_bd=banda_desenata.id_bd WHERE banda_desenata.nume_bd REGEXP '^$product_searched.*'
				ORDER BY nume_numar";
		$query = mysqli_query($link, $sql);
		$count = 0;
		Print '<center>';
		while($row = mysqli_fetch_array($query, MYSQLI_ASSOC))
		{
			$str_val = strval($row['nume_numar']);
			$sql = "SELECT id_nr FROM numere WHERE nume_numar='$str_val';";  //get the id of the current comic
			$id_query = mysqli_query($link, $sql);
			$row_id   = mysqli_fetch_array($id_query, MYSQLI_ASSOC);
			$location = strval($row['imag_location']);
			$name     = strval($row['nume_numar']);
			$pret      = strval($row['pret']);
			$cantitate = strval($row['cantitate']);
			if($count == 0)
			{
				Print "<div class='row'>";
			}
			Print "<div class='col-md-4'>
						<b>$name</b>
						<br></br>
						<img src='$location' class='thumbnail' width='200' height='300'/>";
					//daca butonul de adaugare in cos e apasat, atunci in cosul utilizatorului se va adauga produsul dat de id_nr;
					Print "<a href='#' onclick='add_to_cart(".$row_id['id_nr'].")' class='btn btn-default'>Adauga in cos</a>
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
	else	
	{
		//selectam numele produsului, locatia imaginii, pretul si cantitatea acestuia pentru a le afisa;
		$sql = "SELECT nume_numar,imag_location,pret,cantitate FROM numere JOIN imagini ON numere.id_nr=imagini.id_nr ORDER BY nume_numar";
		$query = mysqli_query($link, $sql);
		$count = 0;
		Print '<center>';
		while($row = mysqli_fetch_array($query, MYSQLI_ASSOC))
		{
			$str_val = strval($row['nume_numar']);
			$sql = "SELECT id_nr FROM numere WHERE nume_numar='$str_val';";
			$id_query = mysqli_query($link, $sql);
			$row_id   = mysqli_fetch_array($id_query, MYSQLI_ASSOC);
			$location = strval($row['imag_location']);
			$name     = strval($row['nume_numar']);
			$pret      = strval($row['pret']);
			$cantitate = strval($row['cantitate']);
			if($count == 0)
			{
				Print "<div class='row'>";
			}
			Print "<div class='col-md-4'>
						<b>$name</b>
						<br></br>
						<img src='$location' class='thumbnail' width='200' height='300'/>";
					Print "<a href='#' onclick='add_to_cart(".$row_id['id_nr'].")' class='btn btn-default'>Adauga in cos</a>
						<br></br>
						<b>Pret:$pret\$</b>";
			if($cantitate > 0)
			{
				Print "<br></br>
				       <b>In stoc</b></div>";
			}
			else
			{
				Print "<br></br>
				       <b>Out of stock</b></div>";
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