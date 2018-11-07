<!DOCTYPE html>
<html>
  <head>
    <title>Magazin benzi desenate</title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<style>
		#imagine{
			position: absolute;
			bottom: 0;
			right: 0;
			z-index: -1;
		}
	</style>
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
					<li><a href="products_home.php">Produse</a></li>
					<li class="active"><a href="cart.php">
					<span class="glyphicon glyphicon-shopping-cart"></span> Cos</a></li>
				</ul>
			</div>
			<div class="col-md-4"></div>
			<!--Mesaj de intampinare + buton de logout-->
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
	<br></br><br></br><br></br>
	<div class="container">
		<table class="table">
			<tr>
				<th>Comicbook name</th>
				<th>Price</th>
				<th>Cantitate</th>
				<th></th>
			</tr>
	<script>
		//apeleaza un script php care sterge din cos produsul specificat prin id_comic;
		function remove_from_cart(id)
		{
			window.location.assign("remove_from_cart.php?id_comic=" + id);
		}
	</script>
	<script src="js/bootstrap.min.js"></script>
  </body>
</html>
<?php
	$link = mysqli_connect("localhost", "root");
	mysqli_select_db($link, "database");
	if($_SERVER['REQUEST_METHOD'] == "GET")
	{
		$email = strval($user);
		//subcererea generaza id-ului utilizatorului cu adresa de email specificata de $email;
		//verificam daca exista produse in cosul utilizatorului curent;
		$sql = "SELECT COUNT(id_user) AS nr FROM cart 
		WHERE id_user=(SELECT id_user FROM users WHERE email='$email');";
		$query = mysqli_query($link, $sql);
		$row = mysqli_fetch_array($query, MYSQLI_ASSOC);
		$nr = $row['nr'];
		//daca nu exista niciun produs in cos, atunci afiseaza mesajul corespunzator;
		if($row['nr'] == 0)
		{
			Print "<tr>
					<td>There are no products in the cart.</td>
					<td></td>
					<td></td>
				   </tr>";
		}
		//selectam produsele care se afla in cosul utilizatorului specificat prin id_user;
		$sql = "SELECT id_nr,nume_nr,price,cantitate FROM cart 
		WHERE id_user=(SELECT id_user FROM users WHERE email='$email');";
		$query = mysqli_query($link, $sql);
		
		//afisam toate produsele din cos;
		while($row = mysqli_fetch_array($query, MYSQLI_ASSOC))
		{
			Print "<tr>
					 <td>" . $row['nume_nr'] . "</td>
					 <td>" . $row['price'] . "\$</td>
					 <td>" . $row['cantitate']. "</td>
					 <td>
						<a href='#' onclick='remove_from_cart(".$row['id_nr'].")' class='btn btn-default pull-right'>
						<span class='glyphicon glyphicon-trash'></span> Sterge</a>
				     </td>
				   </tr>";
		}
		if($nr != 0)
		{
			$suma_sql  = "SELECT SUM(price) AS suma FROM cart 
						  WHERE id_user=(SELECT id_user FROM users WHERE email='$email')";
			$suma_query = mysqli_query($link, $suma_sql);
			$row = mysqli_fetch_array($suma_query, MYSQLI_ASSOC);
			$suma = strval($row['suma']);
			Print "<tr>
					 <td>Suma totala:</td>
					 <td>$suma\$</td>
					 <td></td>
					 <td></td>
				   </tr>";
		}
		Print "</table>
			</div>
		<br><br><br>";
		if($nr > 0)
		{
			Print "
			<div class='container'>
				<form action='plasare_comanda.php' method='POST'>
					<b>Alege metoda de plata:</b><br>
					<div class='radio'>
						<label><input name='mp' type='radio' value='Cash'/>Cash</label>
					</div>
					<br>
					<div class='radio'>
						<label><input name='mp' type='radio' value='Card'/>Card</label>
					</div>
					<br><br>
					<b>Alege metoda de livrare:</b><br>
					<div class='radio'>
						<label><input name='ml' type='radio' value='Ridicare de la sediu'/>Ridicare de la sediu</label>
					</div>
					<br>
					<div class='radio'>
						<label><input name='ml' type='radio' value='Curier'/>Curier</label>
					</div>
					<br><br>
					<button type='submit' class='btn btn-default'>Plasare comanda</button>
				</form>
			</div>";
		}
		Print "<img src='imag\deadpool.png' id='imagine'/>";
	}
?>