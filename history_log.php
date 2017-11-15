<?php
	session_start();
    if((!isset($_SESSION['logined']) || $_SESSION['logined'] === FALSE)||$_SESSION['who']=='admin'){
        header("Location: user_login.html");
        die();
    }
	define('DB_HOST', 'localhost');
	define('DB_NAME', 'document_tracking_system');
	define('DB_USER','root');
	define('DB_PASSWORD','');
	
	$con=new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
	if ($con->connect_errno) {
		echo "Failed to connect to MySQL: (" . $con->connect_errno . ") " . $con->connect_error;
	}
?>
<html>
<head>
<link rel = "icon" href = "images/homepage.ico">
<title>Incoming Documents Log</title>
<link rel = "stylesheet" type = "text/css" href = "homepage-style.css">

</head>
<body id="background">
	<article id = "article">
		<div align="center">
		<fieldset id = "fs" style = "width: 95%">
		<table id="table" style="background-color:white" border="1">
			<?php
				$querydoc = "SELECT * FROM doc where ID=".$_GET['ID'];
				$query_doc = mysqli_query($con, $querydoc);
				$query_doc->data_seek(0);
				$query_doc = $query_doc->fetch_assoc();
				#header("Content-type: image/jpeg");
				echo '<tr><td>Document ID</td><td>'.$query_doc['ID'].'</td></tr>';
				echo '<tr><td>Reference Date</td><td>'.$query_doc['reference_date'].'</td></tr>';
				echo '<tr><td>Reference Number</td><td>'.$query_doc['reference_no'].'</td></tr>';
				$querydoc_info = "SELECT * FROM doc_info where ID=".$_GET['ID'];
				$query_doc_info = mysqli_query($con, $querydoc_info);
				$query_doc_info->data_seek(0);
				$query_doc_info = $query_doc_info->fetch_assoc();
				$query_doc_type = "select * from doc_code_list where doc_code_id=".$query_doc_info['doc_code_id'];
				$doc_type = mysqli_query($con, $query_doc_type);
				$doc_type->data_seek(0);
				$doc_type = $doc_type->fetch_assoc();
				echo '<tr><td>Document Type</td><td>'.$doc_type['doc_name'].'</td></tr>';
				echo '<tr><td></td><td></td></tr>';
				echo '<tr><td></td><td></td></tr>';
				echo '<tr><td></td><td></td></tr>';
				echo '<tr><td></td><td></td></tr>';
				echo '<tr><td></td><td></td></tr>';
				echo '<tr><td></td><td></td></tr>';
				$id= $_GET['ID'];
				$querydoc_log = "SELECT * FROM doc_log where doc_ID=$id ORDER BY time_stamp DESC";
				$query_doc_log = mysqli_query($con, $querydoc_log);
				for($row_no = 0; ($query_doc_log->num_rows) > $row_no; $row_no++){
				$query_doc_log->data_seek($row_no);
				$query_doc = $query_doc_log->fetch_assoc();
				echo '<tr><td>Status</td><td>'.$query_doc['status'].'</td></tr>';
				if($query_doc['status']=='IN'){
					echo '<tr><td>Particulars</td><td>'.$query_doc['remarks_particulars'].'</td></tr>';
					echo '<tr><td>Date Received</td><td>'.$query_doc['dateReceived_Transmitted'].'</td></tr>';
					echo '<tr><td>Sender</td><td>'.$query_doc['sender_recipient'].'</td></tr>';
					echo '<tr><td>Updated By</td><td>'.$query_doc['updated_by'].'</td></tr>';
					echo '<tr><td>TimeStamp</td><td>'.$query_doc['time_stamp'].'</td></tr>';
				}else if($query_doc['status']=='OUT'){
					echo '<tr><td>Remarks</td><td>'.$query_doc['remarks_particulars'].'</td></tr>';
					echo '<tr><td>Date Transmitted</td><td>'.$query_doc['dateReceived_Transmitted'].'</td></tr>';
					echo '<tr><td>Receiver</td><td>'.$query_doc['sender_recipient'].'</td></tr>';
					echo '<tr><td>Updated By</td><td>'.$query_doc['updated_by'].'</td></tr>';
					echo '<tr><td>TimeStamp</td><td>'.$query_doc['time_stamp'].'</td></tr>';
				}
				echo '<tr><td></td><td></td></tr>';
				echo '<tr><td></td><td></td></tr>';
				echo '<tr><td></td><td></td></tr>';
				}
				
				#echo '<tr><td>'.$additional_doc_info.'</td></tr>';
				
			?>
		</table>
		</form>
		</fieldset>
	</div>
	</article>
</body>
</html>