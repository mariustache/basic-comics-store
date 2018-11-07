<?php 
	session_start();
	$link = mysqli_connect("localhost", "root") or die(mysqli_error());
	mysqli_select_db($link, "database") or die("Cannot connect to database!");
	
	$stare_comanda = mysqli_real_escape_string($link, $_POST['stare_comanda']);
	$stare_comanda = strval($stare_comanda);
	$id_comanda    = mysqli_real_escape_string($link, $_POST['id_comanda']);
	
	//verifica daca a fost finalizata comanda; daca da, nu mai updatam cantitatea produselor, deoarece acestea au fost deja vandute si nu mai sunt in stoc;
	if(strcmp($stare_comanda,"Finalizata"))
	{
		//daca nu a fost finalizata comanda, dar anulata, atunci inseamna ca trebuie sa reactualizam stocul;
		//updatam cantitatea produselor;
		$get_products = "SELECT id_nr,cantitate FROM numere_comenzi WHERE id_comanda='$id_comanda'";
		$query = mysqli_query($link, $get_products);
		//pentru fiecare produs din comanda curenta
		while($row = mysqli_fetch_array($query, MYSQLI_ASSOC))
		{
			$cantitate = strval($row['cantitate']);
			$id_nr     = strval($row['id_nr']);
			$update = "UPDATE numere SET cantitate=cantitate+'$cantitate' WHERE id_nr='$id_nr'";
			mysqli_query($link, $update);
		}
	}
	//stergem comanda din tabela comenzi;
	$delete = "DELETE FROM comenzi WHERE id_comanda='$id_comanda'";
	mysqli_query($link, $delete);
	header("location: comenzi.php");
?>