<!DOCTYPE html>
<html>
	<head>
		<link href="css/bootstrap.min.css" rel="stylesheet">
	</head>
	<?php
		session_start();
		$user = $_SESSION['user'];
	?>
	<body>
	<div class="row">
	<nav class ="navbar navbar-inverse navbar-fixed-top">
		<div class="container-fluid">
			<!--Meniul principal-->
			<div class="col-md-10">
				<div class="navbar-header">
					<a class="navbar-brand" href="admin.php">Administrare site</a>
				</div>
				<ul class="nav navbar-nav">
					<li class="active"><a href="users.php">Utilizatori</a></li>
					<li><a href="comenzi.php">Comenzi</a></li>
					<li><a href="banda_desenata.php">Benzi desenate</a></li>
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
	<!--Afisare utilizatori si datele lor-->
	<br></br>
	<br></br>
	<div class="row container">
		<form class="navbar-form" action="users.php" method="POST">
				<div class="input-group">
					<input type="text" class="form-control" placeholder="Cauta utilizator" name="user" required="required">
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
		//apeleaza scriptul delete.php care sterge utilizatorul cu user-ul dat de id_user ca parametru
		//al metodei GET;
		function delete_user(id)
		{
			var r=confirm("Are you sure you want to delete this record?");
			if(r == true)
			{
				window.location.assign("delete.php?id_user=" + id);
			}
		}
	</script>
	<script src="js/bootstrap.min.js"></script>
	</body>
</html>

<?php
	$link = mysqli_connect("localhost", "root");
	mysqli_select_db($link, "database") or die("Cannot connect to database!");
	//daca un utilizator a fost cautat, afisam datele acestuia;
	//daca nu a fost efectuata nicio cautare, se afiseaza toti utilizatorii + datele lor;
	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		
		$user_searched = mysqli_real_escape_string($link, $_POST['user']);
		
		$query = mysqli_query($link, "SELECT * FROM users WHERE nume REGEXP '^$user_searched.*'");
		$exists = mysqli_num_rows($query);
		if($exists > 0)
		{
			Print "<div class='container'>
						<table class='table'>
							<tr>
								<th>#</th>
								<th>Nume</th>
								<th>Prenume</th>
								<th>Email</th>
								<th>Nr. telefon</th>
								<th>Adresa</th>
								<th></th>
							</tr>";
			while($row = mysqli_fetch_array($query, MYSQLI_ASSOC))
			{
				
					Print "<tr>";
					Print '<td>' . $row['id_user'] . '</td>';
					Print '<td>' . $row['nume'] . '</td>';
					Print '<td>' . $row['prenume'] . '</td>';
					Print '<td>' . $row['email'] . '</td>';
					Print '<td>' . $row['nr_telefon'] . '</td>';
					Print '<td>' . $row['address'] . '</td>';
					Print '<td>
								<a href="#" onclick="delete_user('.$row['id_user'].')" class="btn btn-default">
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
							<p class='nav nav-tab'>No users with name $user_searched found.</p>
						</div>
				   </div>";
		}
	}
	else
	{
		Print "<div class='container'>
					<table class='table'>
					<tr>
						<th>#</th>
						<th>Nume</th>
						<th>Prenume</th>
						<th>Email</th>
						<th>Nr. telefon</th>
						<th>Adresa</th>
						<th></th>
					</tr>";
			$query = mysqli_query($link, "SELECT * FROM users");
			while($row = mysqli_fetch_array($query, MYSQLI_ASSOC))
			{
				Print "<tr>";
					Print '<td>' . $row['id_user'] . '</td>';
					Print '<td>' . $row['nume'] . '</td>';
					Print '<td>' . $row['prenume'] . '</td>';
					Print '<td>' . $row['email'] . '</td>';
					Print '<td>' . $row['nr_telefon'] . '</td>';
					Print '<td>' . $row['address'] . '</td>';
					Print '<td>
								<a href="#" onclick="delete_user('.$row['id_user'].')" class="btn btn-default">
								<span class="glyphicon glyphicon-trash"></span> Sterge</a>
						   </td>';
				Print "</tr>";
			}
		Print "</table>
			</div>
		<br></br>";
	}

?>