<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'document_tracking_system');
define('DB_USER','root');
define('DB_PASSWORD','');
$con=new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
if ($con->connect_errno) {
    echo "Failed to connect to MySQL: (" . $con->connect_errno . ") " . $con->connect_error;
}
/*$db=mysql_select_db(DB_NAME,$con) or die("Failed to connect to MySQL: " . mysql_error());
$ID = $_POST['user'];
$Password = $_POST['pass'];
*/
function SignIn()
{
	session_start();   //starting the session for user profile page
	if(!empty($_POST['user']))   //checking the 'user' name which is from Sign-In.html, is it empty or have some text
	{
		global $con;
		$query = $con->query("SELECT *  FROM users where username = '$_POST[user]' AND password = '$_POST[pass]'");
		$row = $query->fetch_assoc();
		$query1 = $con->query("UPDATE users set active='online' where username = '$_POST[user]' AND password = '$_POST[pass]'");
	
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
			echo "SORRY... YOU ENTERD WRONG ID AND PASSWORD... PLEASE RETRY...";
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
