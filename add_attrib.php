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
function addAttribute(){
	global $con;
	$id= $_POST['doc_id'];
	$row_count = (int)$_POST['doc_info_row_count'];
	$doc_info = array();
	
	
	for($i = 0; $i < $row_count; $i++){
		$attribute_name = 'attributeNo' . $i;
		if(!empty($_POST[$attribute_name])){
			$doc_info[$i]= $_POST["$attribute_name"];
		}
	}
	
	$json_doc_info = json_encode($doc_info);
	$json_doc_info = "'" . $json_doc_info . "'";
	#echo $json_doc_info;
	
	$query2 = "update doc_code_list set doc_attrib=$json_doc_info where doc_code_id=$id";
	$data2 = mysqli_query($con, $query2);
	
	if($data2){
		echo "Attribute successfully added to the database<br>";
	}else{
		echo "Attribute unsuccessfully added<br>";
		if(!$data2){
			echo "Wrong input in document type and\or Additional information<br>";
		}
	}
	
	//header("Refresh: 5; URL=user_menu.html");
}
if(isset($_POST['submit'])){
	addAttribute();
}
?>