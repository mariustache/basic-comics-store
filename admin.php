<!DOCTYPE html>
<html>
	<head>
		<link href="css/bootstrap.min.css" rel="stylesheet">
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
				<!--Meniul principal -->
				<div class="col-md-10">
					<div class="navbar-header">
						<a class="navbar-brand" href="admin.php">Administrare site</a>
					</div>
					<ul class="nav navbar-nav">
						<li><a href="users.php">Utilizatori</a></li>
						<li><a href="comenzi.php">Comenzi</a></li>
						<li><a href="banda_desenata.php">Benzi desenate</a></li>
					</ul>
				</div>
				<div class="col-md-2">
					<div class="navbar-header pull-right">
						<ul class="nav navbar-nav pull-right">
							<li class="pull-right"><a class="nav navbar-nav" href="logout.php">
							<span class="glyphicon glyphicon-log-out"></span> Log out</a></li>
						</ul>
					</div>
				</div>
			</div>
		</nav>
		</div>
		<br><br><br><br>
		<div class="container">
			<div class="row">
				<form action="admin.php" method="POST">
					<input name="update" type="submit" class="btn btn-default" value="Actualizeaza benzi desenate"/>
				</form>
			</div>
		</div>
		<br>
		<div class="container">
			<div class="row">
				<form action="admin.php" method="POST">
					<input name="afisare" type="submit" class="btn btn-default" value="Afisare detalii"/>
				</form>
			</div>
		</div>
	
	
		<script src="js/bootstrap.min.js"></script>
	</body>
</html>
<?php
	$link = mysqli_connect("localhost", "root") or die(mysqli_error());
	mysqli_select_db($link, "database") or die("Cannot connect to database!");
	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		$chei = array_keys($_POST);
		//daca am apasat pe butonul update, atunci actualizam baza de date;
		if($chei[0] == 'update')
		{
			$update = "UPDATE banda_desenata SET nr_issues=(SELECT COUNT(id_nr) 
			FROM numere WHERE banda_desenata.id_bd=numere.id_bd GROUP BY banda_desenata.id_bd)";
			mysqli_query($link, $update);
			Print "<script>alert('Baza de date a fost actualizata!')</script>";
		}
		//daca am apasat butonul de afisare, afisam detaliile despre utilizatori, comenzi, benzi desenate;
		else
		{
			Print "<br><br>
					<div class='container'>
						<h3>Detalii:</h3>
						<br>";
			//calculam numarul total de utilizatori existenti, numarul de comenzi, 
			//numarul de utilizatori care au efectuat comenzi, numarul de produse in stoc,
			//numarul de furnizori;
			$sql = "SELECT COUNT(comenzi.id_comanda) AS nr_comenzi, COUNT(users.id_user) AS nr_util_com, 
				   (SELECT COUNT(id_user) FROM users) AS nr_utilizatori,
				   (SELECT SUM(cantitate) FROM numere) AS nr_numere,
				   (SELECT COUNT(id_furnizor) FROM furnizor) AS nr_furnizori FROM users 
					JOIN comenzi ON users.id_user=comenzi.id_user";
			$query = mysqli_query($link, $sql);
			$row = mysqli_fetch_array($query, MYSQLI_ASSOC);
			$nr_comenzi     = strval($row['nr_comenzi']);
			$nr_util_com    = strval($row['nr_util_com']);
			$nr_utilizatori = strval($row['nr_utilizatori']);
			$nr_produse     = strval($row['nr_numere']);
			$nr_furnizori   = strval($row['nr_furnizori']);
			Print "
						<h4>Numar utilizatori existenti: $nr_utilizatori</h4>
						<br>
						<h4>Numar comenzi: $nr_comenzi</h4>
						<br>
						<h4>Numar utilizatori care au efectuat comenzi: $nr_util_com</h4>
						<br>
						<h4>Numar produse existente in stoc: $nr_produse</h4>
						<br>
						<h4>Numar furnizori: $nr_furnizori</h4>";
			Print "</div>";
		}
	}
?>