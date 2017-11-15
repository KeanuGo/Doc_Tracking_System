 <?php
	session_start();
    if((!isset($_SESSION['logined']) || $_SESSION['logined'] === FALSE)||$_SESSION['who']=='admin'){
        header("Location: homepage.html");
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
<!DOCTYPE HTML>
<html>
	<head>
		<link rel = "icon" href = "images/homepage.ico">
		<title> ADD DOCUMENT </title>
		<link rel = "stylesheet" type = "text/css" href = "homepage-style.css">
		<style>
			.xButton{
				width: 30px;
				height: 30px;
				font-size: 15px;
			}
			.top {
			  border-top: thin solid;
			  border-color: black;
			}
			.bottom {
			  border-bottom: thin solid;
			  border-color: black;
			}
			.left {
			  border-left: thin solid;
			  border-color: black;
			}
			.right {
			  border-right: thin solid;
			  border-color: black;
			}
		</style>
	</head>
<body id="background">
	<div align="center">
	<fieldset id="fs"><legend id="legend"> &nbsp Update Document Form &nbsp </legend>
		<p id = "status"></p>
		<form type="submit" action="update_document.php" method="POST" onsubmit="return checkInputs(this.submited)" id="myForm" enctype="multipart/form-data">
		<table border="0"  cellspacing="0">
		<tr>
		<td>Reference number</td><td> <input type="text" name="ref_no" id="rn" class="mytext foo" size="80"></td>
		</tr>
		<tr>
		<td>Incoming/Outgoing?</td><td>Incoming<input type="radio" name="in_or_od" value="Incoming" onclick="handleClick(this)" id="external_yes">Outgoing<input type="radio" name="in_or_od" value="Outgoing" onclick="handleClick(this)" id="external_no">N/A<input type="radio" name="in_or_od" value="not_in_or_od" onclick="handleClick(this)" id="external_none"></td>
		</tr>
		<tbody id="external_doc_form">
		<tr>
		<td colspan="2" align="center" class="left top right" id="IO_form_title">Incoming Document Form</td>
		</tr>
		<tr>
		<td class="left" id="sr_label">Sender</td><td class="right"> <input type="text" name="sender_recipient" id="sr" class="mytext foo" size="80"></td>
		</tr>
		<tr>
		<td class="left" id="drt_label">Date Received</td><td class="right"> <input type="date" name="date_received_transmitted" id="rt" class="mytext foo" size="80"></td>
		</tr>
		<tr>
		<td class="left bottom" id="pr_label">Particulars</td><td class="right bottom"> <input type="text" name="remarks_particulars" id="rp" class="mytext foo" size="80"></td>
		</tr>
		</tbody>
		<script type='text/javascript'>
			/*code for toggle hide or show incoming documents form shows if "Yes" is specified in "External?" hides it otherwise*/
			var external_div = document.getElementById('external_doc_form');
			external_div.style.display='none';
			function handleClick(myRadio){
				external_div.style.display='table-row-group';
				if(myRadio.value == "Incoming"){
					document.getElementById("IO_form_title").innerHTML = "Incoming Document Form";
					document.getElementById("sr_label").innerHTML = "Sender";
					document.getElementById("drt_label").innerHTML = "Date Received";
					document.getElementById("pr_label").innerHTML = "Particulars";
				}else if(myRadio.value == "Outgoing"){
					document.getElementById("IO_form_title").innerHTML = "Outgoing Document Form";
					document.getElementById("sr_label").innerHTML = "Recipient";
					document.getElementById("drt_label").innerHTML = "Date Transmitted";
					document.getElementById("pr_label").innerHTML = "Remarks";
				}else if(myRadio.value == "not_in_or_od"){
					external_div.style.display='none';
				}
			}
		</script>
		<br>
		<table>
		<input type="text" name="id" id="row_id" style="display:none">
		<td><input id="button2" type="submit" name="submit" value="Update Document" class="button" onclick="this.form.submited=this.value"></td>
		<td><input id="button2" type="submit" formaction="user_menu.html" name="cancel" value="Back" class="button" onclick="this.form.submited=this.value"></td>
		</table>
		</form>
		<script type='text/javascript'>
			/*checks the empty fields*/
			function checkInputs(button_clicked){
				if(button_clicked == "Back"){
					document.getElementById("myForm").reset();
					return true;
				}else{
					var if_valid = true;
					var message = "";
					
					if(document.getElementById("external_yes").checked || document.getElementById("external_no").checked){
						if(document.getElementsByName("sender_recipient")[0].value==""){
							if(document.getElementById("external_yes").checked){
								message += "Sender cannot be empty\n";
							}else if(document.getElementById("external_no").checked){
								message += "Recipient cannot be empty\n";
							}
							if_valid = false;
						}
						if(document.getElementsByName("date_received_transmitted")[0].value==""){
							if(document.getElementById("external_yes").checked){
								message += "Date Received cannot be empty\n";
							}else if(document.getElementById("external_no").checked){
								message += "Date Transmitted cannot be empty\n";
							}
							if_valid = false;
						}
						if(document.getElementsByName("remarks_particulars")[0].value==""){
							if(document.getElementById("external_yes").checked){
								message += "Particulars cannot be empty\n";
							}else if(document.getElementById("external_no").checked){
								message += "Remarks cannot be empty\n";
							}
							if_valid = false;
						}
					}
					if(!if_valid){
						window.alert(message);
					}
					return if_valid;
				}
			}
		</script>
	</fieldset>
	</div>
</body>
</html>
<?php
	$id= $_GET['ID'];
	$query= "SELECT * FROM doc where ID=$id";
	$query_d=mysqli_query($con, $query);
	$query_d->data_seek(0);
	$query_d= $query_d->fetch_assoc();
	$querydoc_log = "SELECT * FROM doc_log where doc_ID=$id ORDER BY time_stamp DESC LIMIT 1";
	$query_doc_log = mysqli_query($con, $querydoc_log);
	$query_doc_log->data_seek(0);
	$query_doc_log = $query_doc_log->fetch_assoc();
	$rn=$query_d['reference_no'];
	$sr=$query_doc_log['sender_recipient'];
	$rt=$query_doc_log['dateReceived_Transmitted'];
	$rp=$query_doc_log['remarks_particulars'];
	echo 
	"<script type='text/javascript'>
		document.getElementById('row_id').setAttribute('value', '$id');
		document.getElementById('rn').setAttribute('value', '$rn');
		document.getElementById('sr').setAttribute('value', '$sr');
		document.getElementById('rt').setAttribute('value', '$rt');
		document.getElementById('rp').setAttribute('value', '$rp');
	</script>";
	
?>
