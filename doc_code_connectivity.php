<?php

define('DB_HOST', 'localhost');
define('DB_NAME', 'document_tracking_system');
define('DB_USER','root');
define('DB_PASSWORD','Jethshanroyce1204');

$con=new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
if ($con->connect_errno) {
    echo "Failed to connect to MySQL: (" . $con->connect_errno . ") " . $con->connect_error;
}

function NewDocCode()
{
	global $con;
	$code = $_POST['document_code'];
	$name = $_POST['document_name'];
	$query = "INSERT INTO doc_code_list (doc_code, doc_name) VALUES ('$code', '$name')";
	$data = mysqli_query($con,$query);
	if($data)
	{
		header("Location:doc_code.php");
	}
}

function Add()
{
	if(!empty($_POST['document_code']) AND !empty($_POST['document_name']))   //checking the 'user' name which is from Sign-Up.html, is it empty or have some text
	{
		global $con;
		$query = $con->query("SELECT doc_code FROM doc_code_list WHERE doc_code = '$_POST[document_code]'");
		if($query){
			if(!$row = $query->fetch_assoc())
			{
				NewDocCode();
			}
			else
			{
				echo "Document Code already exists.";
				header("Location: doc_code.php");
			}
		}
		else
		{
			NewDocCode();
		}
	}
}
if(isset($_POST['add-doc']))
{
	Add();
}
?>
