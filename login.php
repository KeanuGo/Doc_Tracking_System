<?php
if(isset($_POST['submit']))
{
	session_start();
	$_SESSION['logined'] = True;
}

?>