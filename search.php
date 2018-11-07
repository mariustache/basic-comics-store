<?php
	session_start();
	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		$link = mysqli_connect("localhost", "root");
		$user_searched = mysqli_real_escape_string($link, $_POST['user']);
		
		mysqli_select_db($link, "database") or die("Cannot connect to database!");
		$query = mysqli_query($link, "SELECT * FROM users WHERE nume='$user_searched'");
		$exists = mysqli_num_rows($query);
		if($exists > 0){}
		else
		{
			Print "<div class='row'>
						<p>No users with name $user_searched found.</p>
				   </div>";
		}
	}
	

?>