<?php

define('DB_HOST', 'localhost');
define('DB_NAME', 'document_tracking_system');
define('DB_USER','root');
define('DB_PASSWORD','');

$con=new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
if ($con->connect_errno) {
    echo "Failed to connect to MySQL: (" . $con->connect_errno . ") " . $con->connect_error;
}

function NewUser()
{
	global $con;
	$fullname = $_POST['name'];
	$userName = $_POST['user'];
	$email = $_POST['email'];
	$password =  sha1($_POST['pass']);
	$query = "INSERT INTO users (fullname,username,email,password) VALUES ('$fullname','$userName','$email','$password')";
	$data = mysqli_query($con,$query);
	if($data)
	{
	echo "YOUR REGISTRATION IS COMPLETED...";
	header("Refresh: 2; URL=admin_menu.html");
	}
}

function SignUp()
{	
	global $con;
	$hash = sha1($_POST['pass']);
	$query = $con->query("SELECT * FROM users WHERE username = '$_POST[user]' AND password = '$hash'");

	if($query and $row = $query->fetch_assoc()) {
		echo "SORRY...YOU ARE ALREADY REGISTERED USER...";
		header("Refresh: 2; URL=admin_menu.html");
	} else {
		newuser();
	}
}

if(isset($_POST['submit']))
{
	SignUp();
}
?>
