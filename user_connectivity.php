<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'dts');
define('DB_USER','root');
define('DB_PASSWORD','Jethshanroyce1204');

$con=new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
if ($con->connect_errno) {
    echo "Failed to connect to MySQL: (" . $con->connect_errno . ") " . $con->connect_error;
}

function SignIn()
{
	session_start();   //starting the session for user profile page
	if(!empty($_POST['user']))   //checking the 'user' name which is from Sign-In.html, is it empty or have some text
	{
		global $con;
		$hash = sha1($_POST['pass']);
		$query = $con->query("SELECT *  FROM users WHERE username = '$_POST[user]' AND password = '$hash'");
		$row = $query->fetch_assoc();
		if(!empty($row['username']) AND !empty($row['password']))
		{
			session_regenerate_id();
			$_SESSION['who'] = 'users';
			$_SESSION['username'] = $row['username'];
			$_SESSION['password'] = $row['password'];
			$_SESSION['logined']= True;
			header("Location:user_menu.html");

		}
		else
		{
			echo "SORRY... YOU ENTERED WRONG ID AND PASSWORD... PLEASE RETRY...";
			header("Refresh: 2; URL=homepage.html");
		}
	}else{
		header("Location:homepage.html");
	}
}
if(isset($_POST['employee']))
{
	SignIn();
}

?>
