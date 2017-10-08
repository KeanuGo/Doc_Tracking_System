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
<!DOCTYPE HTML>
<html>
<head>
<link rel = "icon" href = "images/homepage.ico">
<title>Document Code List</title>
<link rel = "stylesheet" type = "text/css" href = "homepage-style.css">
<script src = "validate.js"></script>
</head>
	<body id="background">
		<nav>
			<div align = "center">
				<h2>USER MENU</h2>
				<img src = "images/leyeco_logo.png" id = "logo"><br><br>
				<form method = "POST" action = "incoming_documents.html">
					<button class = "button" id = "button3" formaction = "add_document.html" style = "margin-top: 10px"> Add Document </button>
					<button class = "button" id = "button3" style = "margin-top: 10px"> Incoming Documents </button>
					<button class = "button" id = "button3" formaction = "outgoing_documents.html" style = "margin-top: 10px"> Outgoing Documents </button>
					<button class = "button" id = "button3" formaction = "doc_code.php" style = "margin-top: 10px"> Document Code List </button>
					<button class = "button" id = "button3" formaction = "logout.php" name="log-out" style = "margin-top: 30px"> Log-Out </button>
				</form>
			</div>
		</nav>
		<article id = "article">
			<form method = "POST" type = "submit" align = "center" action = "doc_code_connectivity.php" onsubmit = "return ValidateAddDocCode()">
				Document Code:&nbsp&nbsp
				<input class = "mytext foo" id = "mytext2" type = "text" name = "document_code" readOnly>
				&nbsp&nbsp&nbsp&nbspDocument Name:&nbsp&nbsp
				<input class = "mytext foo" id = "mytext3" type = "text" name = "document_name" readOnly>
				&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
			</form>

			<text id = "warning_msg1" class = "text" style = "margin-left: 130px; float:left">
			</text>
			<text id = "warning_msg2" class = "text" style = "margin-right: 330px; float: right">
			</text>

			<div align = "center">
				<fieldset id = "fs" style = "width: 95%">
					<form method = "POST" type = "submit" align = "center" action = "add_attrib.php">
					<table id = "table" border = "1">
						
					</table>
					<tr><td></td><td></td></tr>
					<input type="text" name="doc_info_row_count" id="row_count_field" value="1" style="display:none">
					<input type="text" name="doc_id" id="doc_id_field" value="0" style="display:none">
					</form>
				</fieldset>
			</div>
		</article>
		<script type='text/javascript'>	
			var background= document.getElementById("table");
			var row_count=0;
			var addInfoRow = background.insertRow(0);
			var cell = addInfoRow.insertCell(0);
			background.setAttribute("style", "width:550px");
			cell.innerHTML = "<input type='button' id='adddocbutton' name='add_doc_info' value='Add Document Information' onclick='add_doc_info_function()' class='button +Button'>";
			cell.innerHTML = cell.innerHTML+"<text>  </text><input type='submit' id='submit' name='submit' value='Save' class='button +Button' style='width:150px'>";
			cell.setAttribute("colspan", "2");
			cell.setAttribute("align", "center");
			document.getElementById('mytext2').setAttribute('placeholder', 'CDCR');
			document.getElementById('mytext3').setAttribute('placeholder', 'Cashiers Daily Collection Report');
			document.getElementById('doc_id_field').setAttribute('value', 1);
			function add_doc_info_function(){
				var new_row = background.insertRow(row_count);
				var cell1 = new_row.insertCell(0);
				var cell2 = new_row.insertCell(1);
				var cell3 = new_row.insertCell(2);
				//var cell4 = new_row.insertCell(0);
				cell1.innerHTML = "<input type='text' name='attributeNo" + String(row_count) + "' id='attributeNo" + String(row_count) + "' placeholder='Attribute"+ String(row_count) + "' class='mytext foo' size='80' style='width:500px'>";
				//cell2.innerHTML = "<input type='button' name='add_doc_info" + String(row_count) + "' id='button2" + String(row_count) + "' value='+' onclick='add_doc_info_function()' class ='button +Button'>";
				cell3.innerHTML = "<input type='button' name='remove" + String(row_count) + "' id='remove" + String(row_count) + "' value='X' onclick='remove_doc_info(this)' class ='button xButton' style='width:30px'>";
				//cell4.innerHTML = "Row " + String(row_count);
				row_count++;
				var row_count_field = document.getElementById("row_count_field");
				row_count_field.setAttribute("value", row_count);
				document.getElementById("adddocbutton").setAttribute("colspan", "2");
				document.getElementById("adddocbutton").setAttribute("align", "center");
			}
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
							/*var addButton = document.getElementById("button2" + String(j+1));
							addButton.setAttribute("name", "button2" + String(j));
							addButton.setAttribute("id", "button2" + String(j));*/
							var removeButton = document.getElementById("remove" + String(j+1));
							removeButton.setAttribute("name", "remove" + String(j));
							removeButton.setAttribute("id", "remove" + String(j));
						}
						background.deleteRow(i);
						row_count--;
						var row_count_field = document.getElementById("row_count_field");
						row_count_field.setAttribute("value", row_count);
						//window.alert("Removed row " + i + ", New row count = " + row_count);
						break;
					}
				}
			}
		</script>
	</body>
</html>
<?php
	$id= $_GET['id'];
	
	$query = $con->query("SELECT doc_code,doc_name FROM doc_code_list WHERE doc_code_id = '$id'");
	$row = mysqli_fetch_row($query);
	if($id!=1){
	echo 
	"<script type='text/javascript'>
		document.getElementById('mytext2').setAttribute('placeholder', '$row[0]');
		document.getElementById('mytext3').setAttribute('placeholder', '$row[1]');
		document.getElementById('doc_id_field').setAttribute('value', '$id');
	</script>";
	}
?>