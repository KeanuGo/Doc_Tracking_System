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
	<fieldset id="fs"><legend id="legend"> &nbsp Document Form &nbsp </legend>
		<form type="submit" action="doc_type.php" method="POST" onsubmit="return checkInputs(this.submited)" id="myForm" enctype="multipart/form-data">
		<table id="additional_doc_info_table">
		<thead>
		<th>Information Type</th><th>Information Value</th>
		</thead>
		<tr>
		<td><input type="text" name="attributeNo0" id="attributeNo0" placeholder = "Attribute0" class="mytext foo" size="80"></td>
		<td><input type="text" name="valueNo0" id="valueNo0" placeholder="Value0" class="mytext foo" size="80"></td>
		<td><input type="button" name="remove0" id="remove0" value="X" onclick="remove_doc_info(this)" class ="button xButton"></td>
		</tr>
		<tr><td></td><td></td></tr>
		<tr>
		<td colspan="2" align="center"><input type="button" id="button2" name="add_doc_info" value="Add Document Information" onclick="add_doc_info_function()" class="button"></td>
		</tr>
		</table>
		<input type="text" name="doc_info_row_count" id="row_count_field" value="1" style="display:none">
		<input type="text" name="id" id="row_id" style="display:none">
		
		<script type='text/javascript'>
			var doc_info_table = document.getElementById("additional_doc_info_table");
			var row_count;
			row_count = 1;
			/*function below adds 2 new textfield for info type and info value*/
			function add_doc_info_function(){
				var new_row = doc_info_table.insertRow(row_count+1);
				var cell1 = new_row.insertCell(0);
				var cell2 = new_row.insertCell(1);
				var cell3 = new_row.insertCell(2);
				//var cell4 = new_row.insertCell(0);
				cell1.innerHTML = "<input type='text' name='attributeNo" + String(row_count) + "' id='attributeNo" + String(row_count) + "' placeholder='Attribute"+ String(row_count) + "' class='mytext foo' size='80'>";
				cell2.innerHTML = "<input type='text' name='valueNo" + String(row_count) + "' id='valueNo" + String(row_count) + "' placeholder = 'Value" + String(row_count) + "' class='mytext foo' size='80'>";
				cell3.innerHTML = "<input type='button' name='remove" + String(row_count) + "' id='remove" + String(row_count) + "' value='X' onclick='remove_doc_info(this)' class ='button xButton'>";
				//cell4.innerHTML = "Row " + String(row_count);
				row_count++;
				var row_count_field = document.getElementById("row_count_field");
				row_count_field.setAttribute("value", row_count);
			}
			
			/*function below removes the text fields in the row the x button is clicked*/
			function remove_doc_info(input){
				var name = input.getAttribute("name");
				//window.alert("Trying to find '" + name + "'" + String(row_count));
				for(var i = 0; i < row_count; i++){
					var row = document.getElementById("remove"+String(i));
					//window.alert("Iterate" + String(i) + ". Comparing: " + name + ", " + row.getAttribute("name"));
					if(!(name.localeCompare(row.getAttribute("name")))){
						//window.alert("Removing row " + i + ", Row count = " + row_count);
						for(var j = i; j < row_count-1; j++){
							var attribType = document.getElementById("attributeNo" + String(j+1));
							attribType.setAttribute("name", "attributeNo" + String(j));
							attribType.setAttribute("id", "attributeNo" + String(j));
							attribType.setAttribute("placeholder", "Attribute" + String(j));
							var attribVal = document.getElementById("valueNo" + String(j+1));
							attribVal.setAttribute("name", "valueNo" + String(j));
							attribVal.setAttribute("id", "valueNo" + String(j));
							attribVal.setAttribute("placeholder", "Value" + String(j));
							var removeButton = document.getElementById("remove" + String(j+1));
							removeButton.setAttribute("name", "remove" + String(j));
							removeButton.setAttribute("id", "remove" + String(j));
						}
						doc_info_table.deleteRow(i+1);
						row_count--;
						var row_count_field = document.getElementById("row_count_field");
						row_count_field.setAttribute("value", row_count);
						//window.alert("Removed row " + i + ", New row count = " + row_count);
						break;
					}
				}
			}
		</script>
		<?php
			$var= $_POST['doc_type'];
			$query_doc_type = "select doc_attrib from doc_code_list where doc_code='$var'";
			$doc_type_id = mysqli_query($con, $query_doc_type);
			$doc_type_id = $doc_type_id->fetch_assoc();
			$doc_type_id = json_decode($doc_type_id['doc_attrib'], true);
			$size=sizeof($doc_type_id);
			$i=1;
			if($size!=0)
			{
				echo 
				"<script type='text/javascript'>
					document.getElementById('attributeNo0').setAttribute('value', '$doc_type_id[0]');
					document.getElementById('attributeNo0').setAttribute('readonly', true);
				</script>";
			}
			for($i = 1;  $i < $size; $i++){
			echo
			"<script type='text/javascript'>
				add_doc_info_function();
				document.getElementById('attributeNo'+$i).setAttribute('value', '$doc_type_id[$i]');
				document.getElementById('attributeNo'+$i).setAttribute('readonly', true);
			</script>";
			}
				
		?>
		<br>
		<table>
		<td><input id="button2" type="submit" name="submit" value="Add Info" class="button" onclick="this.form.submited=this.value"></td>
		<td><input id="button2" type="submit" formaction="user_menu.html" name="cancel" value="Back" class="button" onclick="this.form.submited=this.value"></td>
		</table>
		</form>
		<script type='text/javascript'>
			/*checks the empty fields*/
			function checkInputs(button_clicked){
					for(var i = 0; i <row_count; i++){
						if((!document.getElementById("attributeNo" + String(i)).value=="" && document.getElementById("valueNo" + String(i)).value=="") || (document.getElementById("attributeNo" + String(i)).value=="" && !document.getElementById("valueNo" + String(i)).value=="")){
							message += "Additional information number " + (i+1) + " has an empty field\n";
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

/*$db=mysql_select_db(DB_NAME,$con) or die("Failed to connect to MySQL: " . mysql_error());
$ID = $_POST['user'];
$Password = $_POST['pass'];
*/
function addDocument(){
	global $con;
	$ref_date = $_POST['ref_date'];
	$ref_no = $_POST['ref_no'];
	$doc_type = $_POST['doc_type'];
	$query_doc_type = "select doc_code_id from doc_code_list where doc_code='$doc_type'";
	$doc_type_id = mysqli_query($con, $query_doc_type);
	$doc_type_id->data_seek(0);
	$doc_type_id = $doc_type_id->fetch_assoc();
	$doc_type_id = $doc_type_id['doc_code_id'];
	$img_data = "NULL";
	$img_name = "NULL";
	if(count($_FILES) > 0){
		if(is_uploaded_file($_FILES['attach_file']['tmp_name'])){
			$img_data = addslashes(file_get_contents($_FILES['attach_file']['tmp_name']));
			$img_name = $_FILES['attach_file']['name'];
			$img_data = "'".$img_data."'";
			$img_name = "'".$img_name."'";
		}
	}
	
	$query = "INSERT INTO doc(ID, reference_date, reference_no, attach_name, attach_image) VALUES (0,'$ref_date', '$ref_no', $img_name, $img_data)";
	$data = mysqli_query($con,$query);
	$last_id = $con->insert_id;
	
	echo
			"<script type='text/javascript'>
				document.getElementById('row_id').setAttribute('value', $last_id);
			</script>";
	
	$query2 = "insert into doc_info(ID, doc_code_id) values($last_id, $doc_type_id)";
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
			$query3= "insert into doc_log values ($last_id, 'IN', '$remarks_particulars', '$date_received_transmitted', '$sender_recipient', '$updated_by', (select now()))";
		}else if($_POST['in_or_od'] == 'Outgoing'){
			echo 'Outgoing Doc';
			$data3_1 = mysqli_query($con, "update doc set if_incoming='N' where ID=$last_id");
			$data3_3 = mysqli_query($con, "update doc set if_od='Y' where ID=$last_id");
			$query3= "insert into doc_log values ($last_id, 'OUT', '$remarks_particulars', '$date_received_transmitted', '$sender_recipient', '$updated_by', (select now()))";
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
	
	//header("Refresh: 5; URL=user_menu.html");
}
if(isset($_POST['submit'])){
	addDocument();
}
?>

