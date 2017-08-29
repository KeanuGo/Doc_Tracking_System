<?php
if(isset($_POST['submit']))
{
	session_start();
	$_SESSION['logined'] = False;
	header("Location: user_login.html");
	session_destroy();
    die();
}
?>