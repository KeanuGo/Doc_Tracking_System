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
	$fullname = mysqli_real_escape_string($con, $_POST['name']);
	$userName = mysqli_real_escape_string($con,$_POST['user']);
	$email = mysqli_real_escape_string($con,$_POST['email']);
	$password =  mysqli_real_escape_string($con,$_POST['pass']);
	$query = "INSERT INTO users (fullname,username,email,password) VALUES ('$fullname','$userName','$email','$password')";
	$data = mysqli_query($con,$query);
	if($data)
	{
	echo "YOUR REGISTRATION IS COMPLETED...";
	}
}

function SignUp()
{
	if(!empty($_POST['user']))   //checking the 'user' name which is from Sign-Up.html, is it empty or have some text
	{
		global $con;
		$query = $con->query("SELECT * FROM users WHERE username = '$_POST[user]' AND password = '$_POST[pass]'");
		if($query){
			if(!$row = $query->fetch_assoc())
			{
				if(strlen($_POST['pass'])>=7)
				{
					if($_POST['pass'] == $_POST['cpass'])
					{
						newuser();
					}
					else
					{
						echo "PASSWORD DOES NOT MATCH";
					}
				}
				else
				{
					echo "PASSWORD MUST CONTAIN AT LEAST 7 CHARACTERS...";
				}
			}
			else
			{
				echo "SORRY...YOU ARE ALREADY REGISTERED USER...";
			}
		}
		else
		{
			newuser();
		}
	}
}
if(isset($_POST['submit']))
{
	SignUp();
}
?>
