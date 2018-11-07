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
		<div class="container">
			<form action="add_comic.php" method="POST">
				<div class="form-group">
					<div class="row">
						<div class="form-group col-xs-4">
							<b>Nume:</b>
							<input name="nume_numar" type="text" class="form-control" id="nume" required="required">
						</div>
					</div>
					<div class="row">
						<div class="form-group col-xs-4">
							<b>Data aparitiei:</b>
							<input name="data_aparitie" type="date" class="form-control" id="data_aparitie" required="required">
						</div>
					</div>
					<div class="row">
						<div class="form-group col-xs-4">
							<b>Numar:</b>
							<input name="issue_nr" type="number" class="form-control" id="issue_nr" required="required">
						</div>
					</div>
					<div class="row">
						<div class="form-group col-xs-4">
							<b>Banda desenata:</b>
							<input name="nume_bd" type="text" class="form-control" id="banda_desenata" required="required">
						</div>
					</div>
					<div class="row">
						<div class="form-group col-xs-4">
							<b>Furnizor:</b>
							<input name="nume_furnizor" type="text" class="form-control" id="furnizor" required="required">
						</div>
					</div>
					<div class="row">
						<div class="form-group col-xs-4">
							<b>Pret:</b>
							<input name="pret" type="number" class="form-control" id="pret" required="required">
						</div>
					</div>
					<div class="row">
						<div class="form-group col-xs-4">
							<b>Cantitate:</b>
							<input name="cantitate" type="number" class="form-control" id="cantitate" required="required">
						</div>
					</div>
					<button type="submit" class="btn btn-default">Adauga produs</button>
					<a href="banda_desenata.php" class="btn btn-default">Inapoi</a>
				</div>
			</form>
		</div>
	</body>
</html>



<?php 
	$link = mysqli_connect("localhost", "root") or die(mysqli_error());
	mysqli_select_db($link, "database") or die("Cannot connnect to database!");
	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		$nume_nr   = mysqli_real_escape_string($link, $_POST['nume_numar']);
		$data      = mysqli_real_escape_string($link, $_POST['data_aparitie']);
		$nr        = mysqli_real_escape_string($link, $_POST['issue_nr']);
		$nume_bd   = mysqli_real_escape_string($link, $_POST['nume_bd']);
		$nume_fr   = mysqli_real_escape_string($link, $_POST['nume_furnizor']);
		$pret      = mysqli_real_escape_string($link, $_POST['pret']);
		$cantitate = mysqli_real_escape_string($link, $_POST['cantitate']);
		
		//selectam toti furnizorii ca sa verificam daca cel introdus exista;
		$furnizori_query = mysqli_query($link, "SELECT nume_furnizor FROM furnizor");
		$exists_furnizor = 0;
		while($row = mysqli_fetch_array($furnizori_query, MYSQLI_ASSOC))
		{
			//daca exista, atunci selectam id-ul acestuia
			if($nume_fr == $row['nume_furnizor'])
			{
				$exists_furnizor = 1;
				$str_val = strval($nume_fr);
				$id_fr_query = mysqli_query($link, "SELECT id_furnizor FROM furnizor 
				                                    WHERE nume_furnizor='$str_val'");
				$row = mysqli_fetch_array($id_fr_query, MYSQLI_ASSOC);
				$id_fr = $row['id_furnizor'];									
				break;
			}
		}
		//daca furnizorul nu exista, atunci trebuie introdus in baza de date
		if($exists_furnizor == 0)												
		{
			//selectam maximul id_furnizor pentru a seta id-ul furnizorul introdus
			$id_max_query = mysqli_query($link, "SELECT MAX(id_furnizor) AS id_furnizor FROM furnizor");
			$row = mysqli_fetch_array($id_max_query, MYSQLI_ASSOC);
			$id_max = $row['id_furnizor'];
			$id_max = $id_max + 1;
			$id_fr = $id_max;
			$nume_furnizor = strval($nume_fr);
			mysqli_query($link, "INSERT INTO furnizor (id_furnizor,nume_furnizor) 
			                     VALUES ('$id_max', '$nume_furnizor');");
		}
		//selectam benzile desenate pentru a verifica daca banda desenata(categoria) introdusa exista deja; 
		//daca nu exista, o introducem in baza de date;
		$banda_desenata_query = mysqli_query($link, "SELECT nume_bd FROM banda_desenata");
		$exists_bd = 0;
		while($row = mysqli_fetch_array($banda_desenata_query, MYSQLI_ASSOC))
		{
			if($nume_bd == $row['nume_bd'])
			{
				$exists_bd = 1;
				$str_val = strval($nume_bd);
				$id_bd_query = mysqli_query($link, "SELECT id_bd FROM banda_desenata
				                                    WHERE nume_bd='$str_val';");
				$row = mysqli_fetch_array($id_bd_query, MYSQLI_ASSOC);
				$id_bd = $row['id_bd'];
				break;
			}
		}
		//daca nu exista, introducem banda desenata;
		if($exists_bd == 0)
		{
			$id_max_query = mysqli_query($link, "SELECT MAX(id_bd) AS id_bd FROM banda_desenata;");
			$row = mysqli_fetch_array($id_max_query, MYSQLI_ASSOC);
			$id_max = $row['id_bd'];
			$id_max = $id_max + 1;
			$id_bd = $id_max;
			$nume_bd = strval($nume_bd);
			mysqli_query($link, "INSERT INTO banda_desenata (id_bd, nume_bd, gen, nr_issues)
			                     VALUES ('$id_bd','$nume_bd','Superhero','1')");
		}
		
		//selectam maximul id_nr pentru a-l incrementa si a obtine id-ului produsului pe care-l introducem;
		$id_nr_max_query = mysqli_query($link, "SELECT MAX(id_nr) AS id_nr FROM numere;");
		$row = mysqli_fetch_array($id_nr_max_query, MYSQLI_ASSOC);
		$id_nr_max = $row['id_nr'];
		$id_nr = $id_nr_max + 1;
		
		$nume_nr   = strval($nume_nr);
		$data      = strval($data);
		$nr        = strval($nr);
		$pret      = strval($pret);
		$cantitate = strval($cantitate);
		
		mysqli_query($link, "INSERT INTO numere (id_nr, id_bd, id_furnizor, nume_numar, issue_nr, 
		data_aparitie, pret, cantitate) VALUES  ('$id_nr', '$id_bd', '$id_fr', '$nume_nr', '$nr', 
		'$data', '$pret', '$cantitate');");
		
		//obtinem si locatia imaginii + numele acesteia corespunzator imaginii;
		$imag_location = strtolower($nume_nr);
		$number = substr($imag_location,strlen($imag_location)-1,1);
		$token = strtok($imag_location, " ");
		$imag_location = "";
		while($token != false)
		{
			$imag_location = $imag_location . $token . '_';
			$token = strtok(" ");
		}
		$number = strval($number);
		$imag_location = substr($imag_location, 0, strlen($imag_location)-3);
		$imag_location = 'imag\\' . $imag_location . "$number.jpg";
		$imag_location = addslashes($imag_location);
		mysqli_query($link, "INSERT INTO imagini (id_imag, id_nr, imag_location)
							 VALUES ('$id_nr', '$id_nr', '$imag_location');");
		
		header("location: banda_desenata.php");
	}
?>