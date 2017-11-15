<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'document_tracking_system');
define('DB_USER','root');
define('DB_PASSWORD','');
$con=new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
if ($con->connect_errno) {
    echo "Failed to connect to MySQL: (" . $con->connect_errno . ") " . $con->connect_error;
} 
session_start();
if(!isset($_SESSION['logined']) || $_SESSION['logined'] === FALSE || $_SESSION['who']==='admin'){
	header("Location: homepage.html");
	die();
}
?>
<?php

/*$db=mysql_select_db(DB_NAME,$con) or die("Failed to connect to MySQL: " . mysql_error());
$ID = $_POST['user'];
$Password = $_POST['pass'];
*/
function updateDocument(){
	global $con;
	$id = $_POST['id'];
	$ref_no = $_POST['ref_no'];
	
	
	$query = "UPDATE doc SET reference_no= '$ref_no' WHERE ID=$id";
	$data = mysqli_query($con,$query);
	
	$external = false;
	if(!empty($_POST['in_or_od'])){
		$external = true;
		$sender_recipient = $_POST['sender_recipient'];
		$date_received_transmitted = $_POST['date_received_transmitted'];
		$remarks_particulars = $_POST['remarks_particulars'];
		$updated_by = $_SESSION['username'];
		if($_POST['in_or_od'] == 'Incoming'){
			echo 'Incoming Doc';
			$data3_1 = mysqli_query($con, "update doc set if_incoming='Y' where ID=$id");
			$data3_2 = mysqli_query($con, "update doc set if_od='N' where ID=$id");
			$query3= "insert into doc_log values ($id, 'IN', '$remarks_particulars', '$date_received_transmitted', '$sender_recipient', '$updated_by', (select now()))";
		}else if($_POST['in_or_od'] == 'Outgoing'){
			echo 'Outgoing Doc';
			$data3_1 = mysqli_query($con, "update doc set if_incoming='N' where ID=$id");
			$data3_3 = mysqli_query($con, "update doc set if_od='Y' where ID=$id");
			$query3= "insert into doc_log values ($id, 'OUT', '$remarks_particulars', '$date_received_transmitted', '$sender_recipient', '$updated_by', (select now()))";
		}else if($_POST['in_or_od'] == 'not_in_or_od'){
			
		}
		$data3 = mysqli_query($con, $query3);
		if(!$data3 || !$data3_1){
			$external = false;
		}
		#echo "EXTERNAL";
	}
	
	if($data && $external){
		echo "Document successfully added to the database<br>";
	}else{
		echo "Document unsuccessfully added<br>";
		if(!$data){
			echo "Wrong input in reference date<br>";
		}
		if(!$external){
			echo "Wrong input in Incoming Document Form<br>";
		}
	}
	
	//header("Refresh: 5; URL=user_menu.html");
}
if(isset($_POST['submit'])){
	updateDocument();
}
?>

