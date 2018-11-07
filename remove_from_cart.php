<?php
	session_start();
	$link = mysqli_connect("localhost", "root") or die(mysqli_error());
	mysqli_select_db($link, "database") or die("Cannot connect to database!");
	
	//id-ul numarului este primit ca parametru prin metoda GET;
	$id_nr = mysqli_real_escape_string($link, $_GET['id_comic']);
	$id_nr = strval($id_nr);
	$email = strval($_SESSION['user']);
	
	//selectam id-ul userului cu mailul specificat prin variabila globala $_SESSION['user'];
	$sql = "SELECT id_user FROM users WHERE email='$email';";
	$query = mysqli_query($link, $sql);
	$row = mysqli_fetch_array($query, MYSQLI_ASSOC);
	$id_user = strval($row['id_user']);
	
	//selectam cantitatea produsului dat de id_nr;
	$sql = "SELECT cantitate FROM cart WHERE id_user=(SELECT id_user FROM users WHERE email=
	(SELECT email FROM users where id_user='$id_user')) AND id_nr='$id_nr';";
	$query = mysqli_query($link, $sql);
	$row = mysqli_fetch_array($query, MYSQLI_ASSOC);
	
	//daca produsul pe care vrem sa-l stergem are cantitatea mai mare ca 1, atunci cu fiecare apasare
	//a butonului 'remove' decrementam cantitatea din cos a produsului respectiv;
	if($row['cantitate'] > 1)
	{
		$cantitate = strval($row['cantitate']-1);
		$sql = "UPDATE cart SET cantitate='$cantitate' WHERE id_user='$id_user' AND id_nr='$id_nr';";
		mysqli_query($link, $sql);
	}
	else
	{
	//altfel, stergem linia din tabela cart care corespunde userului si numarului respectiv;
		$sql = "DELETE FROM cart WHERE id_user='$id_user' AND id_nr='$id_nr';";
		mysqli_query($link, $sql);
	}
	header("location: cart.php");
?>