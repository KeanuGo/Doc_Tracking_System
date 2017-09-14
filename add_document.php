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
/*$db=mysql_select_db(DB_NAME,$con) or die("Failed to connect to MySQL: " . mysql_error());

$ID = $_POST['user'];
$Password = $_POST['pass'];
*/
function addDocument(){
	global $con;
	$ref_date = $_POST['ref_date'];
	$doc_type = $_POST['doc_type'];
	$doc_type_id = mysqli_query($con, "select doc_code_id from doc_code_list where doc_name='$doc_type'");
	$doc_type_id->data_seek(0);
	$doc_type_id = $doc_type_id->fetch_assoc();
	$doc_type_id = $doc_type_id['doc_code_id'];
	$row_count = (int)$_POST['doc_info_row_count'];
	
	/*$s1 = "Hello";
	$s1 = $s1 . " World";
	echo $s1;*/
	/*$No = 3-3;
	$attributeNo = "attributeNo$No";
	echo $_POST[$attributeNo];
	echo $_POST['valueNo0'];*/
	$doc_info = new \stdClass();
	#echo $row_count;
	for($i = 0; $i < $row_count; $i++){
		$attribute_name = 'attributeNo' . $i;
		$value_name = 'valueNo' . $i;
		if(!empty($_POST[$attribute_name])&& !empty($_POST[$value_name])){
			$doc_info->$_POST[$attribute_name] = $_POST[$value_name];
		}
	}
	$json_doc_info = json_encode($doc_info);
	$json_doc_info = "'" . $json_doc_info . "'";
	#echo $json_doc_info;
	
	$query = "INSERT INTO doc(ID, reference_date) VALUES (0,'$ref_date')";
	$data = mysqli_query($con,$query);
	$last_id = $con->insert_id;
	
	$query2 = "insert into doc_info values($last_id, $doc_type_id, $json_doc_info)";
	$data2 = mysqli_query($con, $query2);
	#echo "last id is :" . $last_id;
	$external = false;
	if(!empty($_POST['in_or_od'])){
		$external = true;
		$sender_recipient = $_POST['sender_recipient'];
		$date_received_transmitted = $_POST['date_received_transmitted'];
		$remarks_particulars = $_POST['remarks_particulars'];
		$updated_by = $_SESSION['username'];
		if($_POST['in_or_od'] == 'Incoming'){
			echo 'Incoming Doc';
			$data3_1 = mysqli_query($con, "update doc set if_incoming='Y' where ID=$last_id");
			$data3_2 = mysqli_query($con, "update doc set if_od='N' where ID=$last_id");
			$query3= "insert into doc_log values ($last_id, 'IN', '$remarks_particulars', '$date_received_transmitted', '$sender_recipient', '$updated_by', CURDATE(), CURTIME())";
		}else if($_POST['in_or_od'] == 'Outgoing'){
			echo 'Outgoing Doc';
			$data3_1 = mysqli_query($con, "update doc set if_incoming='N' where ID=$last_id");
			$data3_3 = mysqli_query($con, "update doc set if_od='Y' where ID=$last_id");
			$query3= "insert into doc_log values ($last_id, 'OUT', '$remarks_particulars', '$date_received_transmitted', '$sender_recipient', '$updated_by', CURDATE(), CURTIME())";
		}else if($_POST['in_or_od'] == 'not_in_or_od'){
			
		}
		$data3 = mysqli_query($con, $query3);
		if(!$data3 || !$data3_1 || !$data3_2){
			$external = false;
		}
		#echo "EXTERNAL";
	}
	
	if($data && $data2 && $external){
		echo "Document successfully added to the database<br>";
	}else{
		echo "Document unsuccessfully added<br>";
		if(!$data){
			echo "Wrong input in reference date<br>";
		}
		if(!$data2){
			echo "Wrong input in document type and\or Additional information<br>";
		}
		if(!$external){
			echo "Wrong input in Incoming Document Form<br>";
		}
	}
	
	header("Refresh: 5; URL=user_menu.html");
}

if(isset($_POST['submit'])){
	addDocument();
}

?>
