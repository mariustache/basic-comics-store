<!DOCTYPE html>
<html>
	<head>
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<style>
			#imagine {
				position: absolute;
				top: 0;
				right: 0;
			}
		</style>
	</head>
	<body>
		<div class="container">
			<form action="signup.php" method="POST">
				<div class="row">
					<div class="form-group col-xs-4">
						<label for="email">Email address:</label>
						<input name="email" type="email" class="form-control" id="email" required="required">
					</div>
				</div>
				<div class="row">
					<div class="form-group col-xs-4">
						<label for="pwd">Password:</label>
						<input name="password" type="password" class="form-control" id="pwd" required="required">
					</div>
				</div>
				<div class="row">
					<div class="form-group col-xs-4">
						<b>Nume:</b>
						<input name="nume" type="text" class="form-control" id="nume" required="required">
					</div>
				</div>
				<div class="row">
					<div class="form-group col-xs-4">
						<b>Prenume:</b>
						<input name="prenume" type="text" class="form-control" id="prenume" required="required">
					</div>
				</div>
				<div class="row">
					<div class="form-group col-xs-4">
						<b>Nr. telefon:</b>
						<input name="nr_telefon" type="text" class="form-control" id="nr_telefon" required="required">
					</div>
				</div>
				<div class="row">
					<div class="form-group col-xs-4">
						<b>Address:</b>
						<input name="address" type="text" class="form-control" id="address" required="required">
					</div>
				</div>
				<button type="submit" class="btn btn-default">Register</button>
			</form>
			
			<form action="index.php">
				<button type="submit" class="btn btn-default">Back</button>
			</form>
		</div>
		<div>
			<img src="imag/spiderman.jpg" id="imagine" />
		</div>
		<script src="js/bootstrap.min.js"></script>
	</body>
</html>

<?php
	
	if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		$link = mysqli_connect("localhost", "root") or die(mysqli_error());
		$bool = true;
		
		$email      = mysqli_real_escape_string($link, $_POST['email']);
		$password   = mysqli_real_escape_string($link, $_POST['password']);
		$nume       = mysqli_real_escape_string($link, $_POST['nume']);
		$prenume    = mysqli_real_escape_string($link, $_POST['prenume']);
		$nr_telefon = mysqli_real_escape_string($link, $_POST['nr_telefon']);
		$address    = mysqli_real_escape_string($link, $_POST['address']);
		
		mysqli_select_db($link, "database") or die(mysqli_error($link));
		$query = mysqli_query($link, "SELECT * FROM users");
		while($row = mysqli_fetch_array($query, MYSQLI_ASSOC))
		{
			$table_users = $row['email'];
			if($email == $table_users)
			{
				$bool = false;
				Print '<script>alert("Email address has ben taken!");</script>';
				Print '<script>window.location.assign("signup.php");</script>';
			}
			$id_user = $row['id_user'];
		}
		
		if($bool)
		{
			$id_user = $id_user + 1;
			mysqli_query($link, "INSERT INTO users (id_user,email,password,nume,prenume,nr_telefon,address)
								 VALUES ('$id_user','$email','$password','$nume','$prenume','$nr_telefon','$address')");
			Print '<script>alert("Successfully registered!");</script>';
			Print '<script>window.location.assign("signup.php");</script>';
		}
	}


?>