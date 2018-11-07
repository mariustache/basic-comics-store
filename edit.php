<!DOCTYPE html>
<html>
	<head>
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<script src="js/jquery-3.1.1.min.js"></script>
		<?php
			session_start();
		?>
	</head>
	<body>
		<br></br>
		<div class='container'>
			<form action="update.php" method="POST">
				<div class="form-group">
					<div class="row">
						<div class="form-group col-xs-4">
							<b>Nume:</b>
							<input name="nume_numar" type="text" class="form-control" id="nume">
						</div>
					</div>
					<div class="row">
						<div class="form-group col-xs-4">
							<b>Data aparitiei:</b>
							<input name="data_aparitie" type="date" class="form-control" id="data_aparitie">
						</div>
					</div>
					<div class="row">
						<div class="form-group col-xs-4">
							<b>Numar:</b>
							<input name="issue_nr" type="number" class="form-control" id="issue_nr">
						</div>
					</div>
					<div class="row">
						<div class="form-group col-xs-4">
							<b>Banda desenata:</b>
							<input name="nume_bd" type="text" class="form-control" id="banda_desenata">
						</div>
					</div>
					<div class="row">
						<div class="form-group col-xs-4">
							<b>Furnizor:</b>
							<input name="nume_furnizor" type="text" class="form-control" id="furnizor">
						</div>
					</div>
					<div class="row">
						<div class="form-group col-xs-4">
							<b>Pret:</b>
							<input name="pret" type="number" class="form-control" id="pret">
						</div>
					</div>
					<div class="row">
						<div class="form-group col-xs-4">
							<b>Cantitate:</b>
							<input name="cantitate" type="number" class="form-control" id="cantitate">
						</div>
					</div>
					<button type="submit" class="btn btn-default">Salvare schimbari</button>
					<a href="banda_desenata.php" class="btn btn-default">Inapoi</a>
				</div>
			</form>
		</div>
	</body>
</html>

	
<?php
	$link = mysqli_connect("localhost", "root") or die(mysqli_error());
	mysqli_select_db($link, "database") or die("Cannot connect to database!");
	//id-ul produsului pe care vrem sa-l editam se afla in variabila $_SESSION['id']
	$_SESSION['id'] = mysqli_real_escape_string($link, $_GET['id_comic']);
	$id = $_SESSION['id'];
	$query = mysqli_query($link, 
	"SELECT id_nr,nume_numar,issue_nr,data_aparitie,nume_bd,nume_furnizor,pret,cantitate
		FROM numere,banda_desenata,furnizor 
		WHERE numere.id_bd=banda_desenata.id_bd 
		AND furnizor.id_furnizor=numere.id_furnizor AND numere.id_nr='$id'");
	$exists = mysqli_num_rows($query);
	if($exists > 0)
	{
		$row = mysqli_fetch_array($query, MYSQLI_ASSOC);
		Print "<div class='container'>
				<table class='table'>
					<tr>
						<th>Nume</th>
						<th>Data aparitie</th>
						<th>Numar</th>
						<th>Banda desenata</th>
						<th>Furnizor</th>
						<th>Pret</th>
						<th>Cantitate</th>
					</tr>";
		Print "<tr>";
					Print '<td>' . $row['nume_numar'] . '</td>';
					Print '<td>' . $row['data_aparitie'] . '</td>';
					Print '<td>' . $row['issue_nr'] . '</td>';
					Print '<td>' . $row['nume_bd'] . '</td>';
					Print '<td>' . $row['nume_furnizor'] . '</td>';
					Print '<td>' . $row['pret'] . '</td>';
					Print '<td>' . $row['cantitate'] . '</td>';
		Print "</tr>
			</table>
			</div>";
	}	
?>