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
				<input class = "mytext foo" id = "mytext2" type = "text" name = "document_code">
				&nbsp&nbsp&nbsp&nbspDocument Name:&nbsp&nbsp
				<input class = "mytext foo" id = "mytext2" type = "text" name = "document_name">
				&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
				<button class = "button" id = "button2" name = "add-doc"> ADD </button>
			</form>

			<text id = "warning_msg1" class = "text" style = "margin-left: 130px; float:left">
			</text>
			<text id = "warning_msg2" class = "text" style = "margin-right: 330px; float: right">
			</text>

			<div align = "center">
				<fieldset id = "fs" style = "width: 95%">
					<form method = "POST" type = "submit" align = "center" action = "add_doc_info.php">
					<?php
						$query= $con->query("SELECT * FROM doc_code_list ORDER BY doc_code");
						echo "<table id = 'table' border = '1'><tr id = 'tr-td'><th>Doc Code ID</th><th>Document Code</th><th>Document Name</th></tr>";
						$i=0;
						while($row = $query->fetch_assoc())
						{
							$i=$i+1;
							echo "<tr id = '".$row["doc_code_id"]."' onclick='doSomething(this)'><td id = 'tr-td'>".$row["doc_code_id"]."</td><td id = 'tr-td'>".$row["doc_code"]."</td><td id = 'tr-td'>".$row["doc_name"]."</td><tr>";
						}
						echo"</table>";
					?>
					<tr><td></td><td></td></tr>
					<input type="text" name="doc_info_row_count" id="row_count_field" value="1" style="display:none">
					</form>
				</fieldset>
			</div>
		</article>
		
		
		<script type='text/javascript'>	
			var background= document.getElementById("table");
			var row_count;
			//var doc_code_id;
			row_count = 0;
			function doSomething(row){
				var doc_code_id = row.getAttribute("id");
				location.href="view_doc_code.php?id="+ doc_code_id;
				var addInfoRow = background.insertRow(0);
				var cell = addInfoRow.insertCell(0);
				background.setAttribute("style", "width:550px");
				cell.innerHTML = "<input type='button' id='adddocbutton' name='add_doc_info' value='Add Document Information' onclick='add_doc_info_function()' class='button +Button'>";
				cell.innerHTML = cell.innerHTML+"<text>  </text><input type='submit' id='submit' name='submit' value='Save' class='button +Button' style='width:150px'>";
				cell.setAttribute("colspan", "2");
				cell.setAttribute("align", "center");
			}
		</script>
	</body>
</html>
