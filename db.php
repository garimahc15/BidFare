<?php  
	require("mycredential.php");
	$conn = mysqli_connect('localhost', DBUSER, DBPASS);
	 if (!$conn)
    {
	 die('Could not connect: ' . mysqli_error($conn));
	}
	mysqli_select_db($conn, "bidfaredb");
?>