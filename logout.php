<?php
if(isset($_POST['log-out']))
{
	session_start();
	define('DB_HOST', 'localhost');
	define('DB_NAME', 'document_tracking_system');
	define('DB_USER','root');
	define('DB_PASSWORD','');
	$con=new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
	if ($con->connect_errno) {
		echo "Failed to connect to MySQL: (" . $con->connect_errno . ") " . $con->connect_error;
	}
	$updated_by = $_SESSION['username'];
	$data3_2 = mysqli_query($con, "update users set active='offline' where username= '$updated_by'");
	
	
	$_SESSION['logined'] = False;
	
	header("Location: homepage.html");
	
	session_destroy();
    die();
}
?>
