<?php 
	session_start();
	$link = mysqli_connect("localhost", "root") or die(mysqli_error());
	mysqli_select_db($link, "database") or die("Cannot connect to database!");
	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		$metoda_plata   = mysqli_real_escape_string($link, $_POST['mp']);
		$metoda_livrare = mysqli_real_escape_string($link, $_POST['ml']);
		//obtinem email-ul utilizatorului;
		$email          = strval($_SESSION['user']);
		
		//selectam valoarea maxima din campul id_comanda si il incrementam pentru a stabili id-ul comenzii curente;
		$sql   = "SELECT MAX(id_comanda) AS id_comanda FROM comenzi;";
		$query = mysqli_query($link, $sql);
		$row   = mysqli_fetch_array($query, MYSQLI_ASSOC);
		$id_comanda = strval($row['id_comanda'] + 1);
		$current_date = date("Y-m-d");
		$sql_comanda = "INSERT INTO comenzi (id_comanda,id_user,id_mp,id_ml,data_comanda,pret,stare_comanda)
		                VALUES ('$id_comanda',
						(SELECT id_user FROM users WHERE email='$email'),
						(SELECT id_mp FROM metoda_plata WHERE tip_mp='$metoda_plata'),
						(SELECT id_ml FROM metoda_livrare WHERE tip_ml='$metoda_livrare'),
						'$current_date',
						(SELECT SUM(price*cantitate) FROM cart WHERE id_user=(SELECT id_user FROM users WHERE email='$email')),
						'Plasata')";
		mysqli_query($link, $sql_comanda);
		
		
		$sql = "SELECT MAX(id_nr_comenzi) AS id_nr_comenzi FROM numere_comenzi";
		$query = mysqli_query($link, $sql);
		$row = mysqli_fetch_array($query, MYSQLI_ASSOC);
		$id_nr_comenzi = $row['id_nr_comenzi'] + 1;
		//selectam toate produsele din cos si cantitatea lor;
		$sql = "SELECT id_nr,cantitate FROM cart WHERE id_user=(SELECT id_user FROM users 
		WHERE email='$email')";
		$query = mysqli_query($link, $sql);
		while($row = mysqli_fetch_array($query, MYSQLI_ASSOC))
		{
			$id_nr = strval($row['id_nr']);
			//obtinem cantitatea in stoc pentru numarul dat de id_nr;
			$sql_quantity = "SELECT cantitate FROM numere WHERE id_nr='$id_nr'";
			$query_quantity = mysqli_query($link, $sql_quantity);
			$row_quantity = mysqli_fetch_array($query_quantity, MYSQLI_ASSOC);
			$quantity_in_stock = $row_quantity['cantitate'];
			$remaining_quantity = $quantity_in_stock - $row['cantitate'];
			//cantitatea in stoc a produsului care va ramane dupa efectuarea comenzii;
			$remaining_quantity = strval($remaining_quantity);
			
			//inseram in tabela numere_comenzi;
			$cantitate = strval($row['cantitate']);
			$sql_insert = "INSERT INTO numere_comenzi (id_nr_comenzi,id_comanda,id_nr,cantitate)
			VALUES ($id_nr_comenzi,$id_comanda,$id_nr,$cantitate)";
			mysqli_query($link, $sql_insert);
			$id_nr_comenzi = $id_nr_comenzi + 1;
			
			//actualizare cantitate in tabela numere;
			$update = "UPDATE numere SET cantitate='$remaining_quantity' WHERE id_nr='$id_nr'";
			mysqli_query($link, $update);
		}
		
		//stergem cosul in momentul in care comanda a fost efectuata;
		$sql_delete_cart = "DELETE FROM cart WHERE id_user=(SELECT id_user FROM users 
		WHERE email='$email')";
		
		mysqli_query($link, $sql_delete_cart);
	}
	
	header("location: home.php");
?>