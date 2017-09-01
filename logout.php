<?php
if(isset($_POST['submit']))
	{
	session_start();
	$_SESSION['logined'] = False;
	if($_SESSION['who'] == 'admin'){
		header("Location: admin_login.html");
	}else{
		header("Location: user_login.html");
	}
	session_destroy();
	die();
}
?>
