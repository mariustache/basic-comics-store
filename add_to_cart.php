<?php
	session_start();
	$link = mysqli_connect("localhost", "root");
	mysqli_select_db($link, "database");
	//prin variabila $_GET primim id-ul revistei de benzi desenate pe care vrem sa o adaugam in cos;
	$id_nr = mysqli_real_escape_string($link, $_GET['id_comic']);
	
	//cu ajutorul variabilei $_SESSION selectam emailul userului conectat;
	$email       = strval($_SESSION['user']);
	
	//selectam id-ului userului cu emailul specificat mai sus;
	$sql = "SELECT id_user FROM users WHERE email='$email';";
	$query = mysqli_query($link, $sql);
	$row = mysqli_fetch_array($query, MYSQLI_ASSOC);
	$id_user = strval($row['id_user']);
	
	//selectam maximul campului id_cart 
	$sql = "SELECT MAX(id_cart) AS id_cart FROM cart";
	$query = mysqli_query($link, $sql);
	$row = mysqli_fetch_array($query, MYSQLI_ASSOC);
	$id_cart = strval($row['id_cart']+1);
	
	//verificam daca exista produsul in cos; daca da, atunci incrementam cantitatea;
	$sql = "SELECT * FROM cart WHERE id_nr='$id_nr';";
	$query = mysqli_query($link, $sql);
	$nr_rows = mysqli_num_rows($query);
	
	if($nr_rows != 0)
	{
		//selectam cantitatea curenta din cos pentru produsul dat de id_nr;
		$sql = "SELECT cantitate FROM cart WHERE id_nr='$id_nr';";
		$query = mysqli_query($link, $sql);
		$row = mysqli_fetch_array($query, MYSQLI_ASSOC);
		$cantitate = strval($row['cantitate'] + 1);
		$sql = "UPDATE cart SET cantitate='$cantitate' WHERE id_nr='$id_nr'";
		mysqli_query($link, $sql);
	}
	else
	{
		//daca produsul nu exista in cos, il introducem
		$sql = "INSERT INTO cart (id_cart,id_user,id_nr,nume_nr,price,cantitate)
				VALUES ('$id_cart',(SELECT id_user FROM users WHERE email='$email'),
				'$id_nr',(SELECT nume_numar FROM numere WHERE id_nr='$id_nr'),
				(SELECT pret FROM numere WHERE id_nr='$id_nr'),'1');";
		mysqli_query($link, $sql);
	}
	
	header("location: products_home.php");
	
?>