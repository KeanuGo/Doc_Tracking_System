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
	$last_id = $_POST['id'];
	$row_count = (int)$_POST['doc_info_row_count'];
	
	/*$s1 = "Hello";
	$s1 = $s1 . " World";
	echo $s1;*/
	/*$No = 3-3;
	$attributeNo = "attributeNo$No";
	echo $_POST[$attributeNo];
	echo $_POST['valueNo0'];*/
	$doc_info = array();
	#echo $row_count;
	for($i = 0; $i < $row_count; $i++){
		$attribute_name = 'attributeNo' . $i;
		$value_name = 'valueNo' . $i;
		if(!empty($_POST[$attribute_name])&& !empty($_POST[$value_name])){
			$doc_info[$_POST[$attribute_name]] = $_POST[$value_name];
		}
	}
	$json_doc_info = json_encode($doc_info);
	$json_doc_info = "'" . $json_doc_info . "'";
	echo $json_doc_info;
	
	$query2 = "update doc_info set doc_info=$json_doc_info where ID=$last_id";
	$data2 = mysqli_query($con, $query2);
	#echo "last id is :" . $last_id;
	$external = false;
	
	if($data2){
		echo "Additional Information successfully added to the database<br>";
	}else{
		echo "Additional Information unsuccessfully added<br>";
		if(!$data2){
			echo "Wrong input in document type and\or Additional information<br>";
		}
	}
	
	//header("Refresh: 5; URL=user_menu.html");
}
if(isset($_POST['submit'])){
	addDocument();
}
?>
