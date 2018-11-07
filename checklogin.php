<?php
	session_start();	
	$link = mysqli_connect("localhost", "root") or die(mysqli_error());
	mysqli_select_db($link, "database") or die("Cannot acces database!");
	
	//emailul si parola sunt salvate in variabila $_POST;
	$email      = mysqli_real_escape_string($link, $_POST['email']);
	$password   = mysqli_real_escape_string($link, $_POST['password']);
	
	//selectam datele utilizatorului curent;
	$query = mysqli_query($link, "SELECT * FROM users WHERE email='$email'");
	$exists = mysqli_num_rows($query);
	$table_users = "";
	$table_password = "";
	//daca exista utilizatorul
	if($exists > 0)
	{
		
		while($row = mysqli_fetch_array($query, MYSQLI_ASSOC))
		{
			$table_users = $row['email'];
			$table_password = $row['password'];
			
			if(($email == $table_users) && ($password == $table_password))
			{
				$query = mysqli_query($link, "SELECT nume,prenume FROM users WHERE email='$email'");
				$row = mysqli_fetch_array($query, MYSQLI_ASSOC);
				$_SESSION['user'] = $email;
				$_SESSION['nume'] = $row['nume'];
				$_SESSION['prenume'] = $row['prenume'];
				//daca adresa de email e cea a adminului, atunci redirectioneaza catre paginile de administrare
				if($email == 'admin@admin')
				{
					header("location: admin.php");
				}//altfel redirectioneaza catre paginile de vizualizare pentru utilizatori;
				else
				{
					header("location: home.php");
				}
			}
			else
			{
				Print '<script>alert("Incorrect password!");</script>';
				Print '<script>window.location.assign("login.php");</script>';
			}
		}
	}
	else //daca nu exista utilizatorul cu adresa de email introdusa, atunci afiseaza un mesaj de atentionare;
	{
		Print '<script>alert("Incorrect email!");</script>';
		Print '<script>window.location.assign("login.php");</script>';
	}

?>