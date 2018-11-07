<!DOCTYPE html>
<html>
	<head>
		<link href="css/bootstrap.min.css" rel="stylesheet">
	</head>
	<?php
		session_start();
		if($_SESSION['user']){}
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
					<li class="active"><a href="comenzi.php">Comenzi</a></li>
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
	<br><br><br><br>
	</div>
		<script src="js/bootstrap.min.js"></script>
	</body>
</html>
<?php
	$link = mysqli_connect("localhost", "root") or die(mysqli_error());
	mysqli_select_db($link, "database") or die("Cannot connect to database!");
	$sql = "SELECT DISTINCT id_comanda,stare_comanda FROM comenzi";
	$query = mysqli_query($link, $sql);
	
	//afisam fiecare comanda + produsele ei sub forma de tabel
	while($row = mysqli_fetch_array($query, MYSQLI_ASSOC))
	{
		$id_comanda    = $row['id_comanda'];
		$stare_comanda = $row['stare_comanda'];
		//selectam produsele din comanda curenta
		$sql_table = "SELECT id_comanda,id_nr,cantitate FROM numere_comenzi WHERE id_comanda='$id_comanda'";
		$query_table = mysqli_query($link, $sql_table);
		
		Print "<div class='container'>
				<b>Comanda ID: $id_comanda</b><br>";
		Print "
				<table class='table'>
				 <tr>
					<th width='200'>Product</th>
					<th width='200'>Pret</th>
					<th width='200'>Cantitate</th>
				 </tr>";
		//cat timp sunt produse in comanda curenta;
		while($row_table = mysqli_fetch_array($query_table, MYSQLI_ASSOC))
		{
			$id_nr     = $row_table['id_nr'];
			$cantitate = $row_table['cantitate'];
			//selectam numele produsului si pretul
			$sql = "SELECT nume_numar,pret FROM numere WHERE id_nr='$id_nr'";
			$query_name = mysqli_query($link, $sql);
			$row_name   = mysqli_fetch_array($query_name, MYSQLI_ASSOC);
			$nume_numar = strval($row_name['nume_numar']);
			$pret       = $row_name['pret'];
			Print "<tr>
					<td width='200'>$nume_numar</td>
					<td>$pret\$</td>
					<td>$cantitate</td>
				   </tr>";
		}
		
		//selectam adresa de email a userului care a plasat comanda;
		$sql = "SELECT email FROM users 
		WHERE id_user=(SELECT id_user FROM comenzi WHERE id_comanda='$id_comanda')";
		$query_email = mysqli_query($link, $sql);
		$row_email = mysqli_fetch_array($query_email, MYSQLI_ASSOC);
		$email = strval($row_email['email']);
		
		//printam starea comenzii;
		Print "<tr>
				 <td>Stare comanda: $stare_comanda</td>
				 <td></td>
				 <td></td>
			   </tr>
				</table>";
		//printam un "meniu" cu diferite butoane: updatare comanda, anulare comanda si finalizare comanda;
		Print "<br>
			   <div class='row'>
				  <div class='col-md-4'>
					<b>Plasata de: $email.</b>
				  </div>
				  <div class='col-md-3'>
				  <form action='update_comanda.php' method='POST'>
					<b>Stare comanda:</b>
					<input class='form-control' type='text' name='stare_comanda' required='required'></input>
					<input type='hidden' name='id_comanda' value='$id_comanda'></input>
					<button type='submit' class='btn btn-default'>Update comanda</button>
				  </form>
				  </div>
				  <div class='col-md-3'>
					<br><br><br>
					<form action='sterge_comanda.php' method='POST'>
						<input type='hidden' name='id_comanda' value='$id_comanda'></input>
						<input type='hidden' name='stare_comanda' value='$stare_comanda'></input>
						<button type='submit' class='btn btn-default'>Anuleaza comanda</button>
					</form>
				  </div>
				  <div class='col-md-2'>
					<br><br><br>
					<form action='finalizeaza_comanda.php' method='POST'>
						<input type='hidden' name='id_comanda' value='$id_comanda'></input>
						<button type='submit' class='btn btn-default'>Finalizeaza comanda</button>
					</form>
				  </div>
			    </div>
			</div><br><br><br>";
				
	}
?>