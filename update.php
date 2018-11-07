<?php
	session_start();
	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		$link = mysqli_connect("localhost", "root") or die(mysqli_error());
		mysqli_select_db($link, "database") or die("Cannot connect to database!");
		$id = $_SESSION['id'];
		//campurile sunt salvate in $post_key, iar valorile in $post_value
		foreach($_POST as $post_key => $post_value)
		{
			//putem actualiza cate un singur element;
			//adica elementele care nu au valoare nula;
			if($post_value != NULL)
			{
				$str_val = strval($post_value);	
				if($post_key == "nume_bd")
				{
					$sql = "SELECT DISTINCT id_bd FROM banda_desenata WHERE nume_bd='$str_val';";
					$query = mysqli_query($link, $sql);
					$row = mysqli_fetch_array($query, MYSQLI_ASSOC);
					$new_id_db = $row['id_bd'];
					$update_sql = "UPDATE numere SET id_bd='$new_id_db' WHERE id_nr=$id;";
					mysqli_query($link, $update_sql);
				}
				else if($post_key == "nume_furnizor")
				{
					$sql = "SELECT DISTINCT id_furnizor FROM furnizor WHERE nume_furnizor='$str_val';";
					$query = mysqli_query($link, $sql);
					$row = mysqli_fetch_array($query, MYSQLI_ASSOC);
					$new_id_furnizor = $row['id_furnizor'];
					$update_sql = "UPDATE numere SET id_furnizor='$new_id_furnizor' WHERE id_nr=$id";
					mysqli_query($link, $update_sql);
				}
				else
				{
					
					$update_sql = "UPDATE numere SET $post_key='$str_val' WHERE id_nr=$id;";					
					if(!mysqli_query($link, $update_sql))
					{
						echo "Failed!";
					}
				}
			}
		}
	}
	header("location: banda_desenata.php");
?>