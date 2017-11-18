<?php
	session_start();
    if((!isset($_SESSION['logined']) || $_SESSION['logined'] === FALSE)||$_SESSION['who']=='admin'){
        header("Location: user_login.html");
        die();
    }
	define('DB_HOST', 'localhost');
	define('DB_NAME', 'document_tracking_system');
	define('DB_USER','root');
	define('DB_PASSWORD','Jethshanroyce1204');
	
	$con=new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
	if ($con->connect_errno) {
		echo "Failed to connect to MySQL: (" . $con->connect_errno . ") " . $con->connect_error;
	}
?>
<?php
	$querydoc = "SELECT * FROM doc where ID=".$_GET['ID'];
	$query_doc = mysqli_query($con, $querydoc);
	$query_doc->data_seek(0);
	$query_doc = $query_doc->fetch_assoc();
	if(isset($query_doc['attach_image'])){
	echo '<img src="data:image/jpeg;base64,'. base64_encode($query_doc['attach_image']) .'"/>';
	}else{
		echo "<text style = 'font-family: calibri light; font-size: 20px'>No document image attached.</text>";
	}
?>
