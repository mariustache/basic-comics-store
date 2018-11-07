<?php 
	session_start();
	$link = mysqli_connect("localhost", "root") or die(mysqli_error());
	mysqli_select_db($link, "database") or die("Cannot connect to database!");
	
	$stare_comanda = mysqli_real_escape_string($link, $_POST['stare_comanda']);
	$stare_comanda = strval($stare_comanda);
	$id_comanda    = mysqli_real_escape_string($link, $_POST['id_comanda']);
	
	//updatam statusul comenzii in functie de inputul primit
	$update = "UPDATE comenzi SET stare_comanda='$stare_comanda' WHERE id_comanda='$id_comanda'";
	mysqli_query($link, $update);
	
	header("location: comenzi.php");
?>