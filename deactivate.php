<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'document_tracking_system');
define('DB_USER','root');
define('DB_PASSWORD','Jethshanroyce1204');
$con=new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
if ($con->connect_errno) {
    echo "Failed to connect to MySQL: (" . $con->connect_errno . ") " . $con->connect_error;
}

$query = "update users set activated='N' where userID=".$_GET['ID'];
$query2 = $con->query($query);
if(!$query2){
	echo 'Failed to deactivate the account';
}else{
	echo 'Account has been deactivated';
}

header("Refresh: 2, URL=view_users.html");
?>