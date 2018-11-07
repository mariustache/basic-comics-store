<?php
	session_start();
	if($_SESSION['user']){}
	else
	{
		header("location:index.php");
	}
	if($_SERVER['REQUEST_METHOD'] == "GET")
	{
		$link = mysqli_connect("localhost", "root") or die(mysqli_error());
		mysqli_select_db($link, "database") or die("Cannot connect to database!");
		//daca s-a trimis ca parametru id_user, se sterge utilizatorul corespunzator;
		if(!empty($_GET['id_user']))
		{
			$id = $_GET['id_user'];
			$str = "DELETE FROM users WHERE id_user=$id";
			$location = "location: users.php";
		}
		//daca s-a trimis ca parametru id_comic, se sterge numarul corespunzator;
		else if(!empty($_GET['id_comic']))
		{
			$id = $_GET['id_comic'];
			$str = "DELETE FROM numere WHERE id_nr=$id";
			$location = "location: banda_desenata.php";
		}
		mysqli_query($link, $str);
		header($location);
	}
?>