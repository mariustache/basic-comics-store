<!DOCTYPE html>
<html>
	<head>
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/login.css" rel="stylesheet">
	</head>
	<body>
	
		<div class="container">
			<form action="checklogin.php" method="POST">
				<div class="row">
					<div class="form-group col-xs-4">
						<label for="email">Adresa email:</label>
						<input name="email" type="email" class="form-control" id="email" required='required'>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-xs-4">
						<label for="pwd">Parola:</label>
						<input name="password" type="password" class="form-control" id="pwd" required='required'>
					</div>
				</div>
				<button type="submit" class="btn btn-default">Log in</button>
			</form>
			<form action="index.php">
				<button type="submit" class="btn btn-default">Inapoi</button>
			</form>
		</div>
		<div class="pull-right" id="imagine">
			<img src="imag/wolverine.jpg"/>
		</div>
		<script src="js/bootstrap.min.js"></script>
	</body>
</html>

<?php
	


?>