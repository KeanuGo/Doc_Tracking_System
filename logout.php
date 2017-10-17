<?php
if(isset($_POST['log-out']))
{
	session_start();
	$_SESSION['logined'] = False;
	
	header("Location: homepage.html");
	
	session_destroy();
    die();
}
?>