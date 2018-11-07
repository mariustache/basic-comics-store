<!DOCTYPE html>
<html>
	<head>
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<script src="js/jquery-3.1.1.min.js"></script>
	</head>
	<?php
		session_start();
		$user = $_SESSION['user'];
	?>
	<body>
	<div class="row">
	<nav class ="navbar navbar-inverse navbar-fixed-top">
		<div class="container-fluid">
			<!--Meniul principal -->
			<div class="col-md-10">
				<div class="navbar-header">
					<a class="navbar-brand" href="admin.php">Administrare site</a>
				</div>
				<ul class="nav navbar-nav">
					<li><a href="users.php">Utilizatori</a></li>
					<li><a href="comenzi.php">Comenzi</a></li>
					<li class="active"><a href="banda_desenata.php">Benzi desenate</a></li>
				</ul>
			</div>
			<div class="col-md-2">
				<div class="navbar-header pull-right">
					<ul class="nav navbar-nav pull-right">
						<li class="pull-right"><a class="nav navbar-nav" href="logout.php">
						<span class="glyphicon glyphicon-log-out"></span> Log out</a></li>
					</ul>
				</div>
			</div>
		</div>
	</nav>
	</div>
	
	<br></br>
	<br></br>
	<!--Adauga un nou produs-->
	<div class="row container">
		<form class="navbar-form" action="add_comic.php">
			<button type="submit" class="btn btn-default">
			<span class="glyphicon glyphicon-plus"></span> Adauga produs</button>
		</form>
	</div>
	<br></br>
	<!--Afiseaza produse(numerele din benzi desenate) si datele lor-->
	<div class="row container">
		<form class="navbar-form" action="banda_desenata.php" method="POST">
				<div class="input-group">
					<input type="text" class="form-control" placeholder="Cauta banda desenata" name="comic" required="required">
					<div class="input-group-btn">
						<button type="submit" class="btn btn-default">
							<i class="glyphicon glyphicon-search"></i>
						</button>
					</div>
				</div>
		</form>
	</div>
	<br></br>
	
	<script>
		//paseaza ca parametru al metodei GET id-ul numarului pe care dorim sa-l editam;
		function edit_comic(id)
		{
			window.location.assign("edit.php?id_comic=" + id);
		}
		//paseaza ca parametru al metodei GET id-ul numarului pe care dorim sa-l stergem;
		function delete_comic(id)
		{
			var r=confirm("Are you sure you want to delete this record?");
			if(r == true)
			{
				window.location.assign("delete.php?id_comic=" + id);
			}
		}
	</script>
	<script src="js/bootstrap.min.js"></script>
	</body>
</html>

<?php
	$link = mysqli_connect("localhost", "root");
	mysqli_select_db($link, "database") or die("Cannot connect to database!");
	//daca s-a executat modul de cautare al unei benzi desenate, se vor afisa doar produsele care apartin acelei benzi desenate;
	//altfel, se afiseaza toate produsele existente in baza de date;
	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		
		$comic_searched = mysqli_real_escape_string($link, $_POST['comic']);
		
		//selectam toate datele despre un produs
		$query = mysqli_query($link, 
		"SELECT id_nr,nume_numar,issue_nr,data_aparitie,nume_bd,nume_furnizor,pret,cantitate 
		FROM numere JOIN banda_desenata ON numere.id_bd=banda_desenata.id_bd 
		JOIN furnizor ON furnizor.id_furnizor=numere.id_furnizor 
		WHERE banda_desenata.nume_bd REGEXP '^$comic_searched.*' ORDER BY id_nr");
		$exists = mysqli_num_rows($query);
		if($exists > 0)
		{
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
							<th></th>
							<th></th>
						</tr>";
			while($row = mysqli_fetch_array($query, MYSQLI_ASSOC))
			{
				
					Print "<tr>";
					Print '<td>' . $row['nume_numar'] . '</td>';
					Print '<td>' . $row['data_aparitie'] . '</td>';
					Print '<td>' . $row['issue_nr'] . '</td>';
					Print '<td>' . $row['nume_bd'] . '</td>';
					Print '<td>' . $row['nume_furnizor'] . '</td>';
					Print '<td>' . $row['pret'] . '</td>';
					Print '<td>' . $row['cantitate'] . '</td>';
					Print '<td>
								<a href="#" onclick="edit_comic('.$row['id_nr'].')" class="btn btn-default">
								<span class="glyphicon glyphicon-edit"></span> Editeaza</a>
						   </td>';
					Print '<td>
								<a href="#" onclick="delete_comic('.$row['id_nr'].')" class="btn btn-default">
								<span class="glyphicon glyphicon-trash"></span> Sterge</a>
						   </td>';
				Print "</tr>";
			}
			
			Print "</table>
			</div>
			<br></br>";
		}
		else
		{
			Print "<div class='row'>
						<div class='col-md-1'></div>
						<div class='col-md-11'>
							<p class='nav nav-tab'>No comics with name $comic_searched found.</p>
						</div>
				   </div>";
		}
	}
	else
	{
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
						<th></th>
						<th></th>
					</tr>";
			$query = mysqli_query($link, 
			"SELECT id_nr,nume_numar,issue_nr,data_aparitie,nume_bd,nume_furnizor,pret,cantitate 
			FROM numere,banda_desenata,furnizor 
			WHERE numere.id_bd=banda_desenata.id_bd 
			AND furnizor.id_furnizor=numere.id_furnizor ORDER BY id_nr");
			while($row = mysqli_fetch_array($query, MYSQLI_ASSOC))
			{
				Print "<tr>";
					Print '<td>' . $row['nume_numar'] . '</td>';
					Print '<td>' . $row['data_aparitie'] . '</td>';
					Print '<td>' . $row['issue_nr'] . '</td>';
					Print '<td>' . $row['nume_bd'] . '</td>';
					Print '<td>' . $row['nume_furnizor'] . '</td>';
					Print '<td>' . $row['pret'] . '</td>';
					Print '<td>' . $row['cantitate'] . '</td>';
					Print '<td>
								<a href="#" onclick="edit_comic('.$row['id_nr'].')" class="btn btn-default">
								<span class="glyphicon glyphicon-edit"></span> Editeaza</a>
						   </td>';
					Print '<td>
								<a href="#" onclick="delete_comic('.$row['id_nr'].')" class="btn btn-default">
								<span class="glyphicon glyphicon-trash"></span> Sterge</a>
						   </td>';
				Print "</tr>";
			}
		Print "</table></div><br></br>";
	}

?>