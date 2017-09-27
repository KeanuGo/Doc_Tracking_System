<?php 
    session_start();
    if((!isset($_SESSION['logined']) || $_SESSION['logined'] === FALSE)||$_SESSION['who']=='admin'){
        header("Location: homepage.html");
        die();
    }
	define('DB_HOST', 'localhost');
	define('DB_NAME', 'dts');
	define('DB_USER','root');
	define('DB_PASSWORD','Jethshanroyce1204');

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
					<?php
						$query= $con->query("SELECT * FROM doc_code_list ORDER BY doc_code");
						echo "<table id = 'table' border = '1'><tr id = 'tr-td'><th>Doc Code ID</th><th>Document Code</th><th>Document Name</th></tr>";
						$i=0;
						while($row = $query->fetch_assoc())
						{
							$i=$i+1;
							echo "<tr id = 'tr-td'><td id = 'tr-td'>".$i."</td><td id = 'tr-td'>".$row["doc_code"]."</td><td id = 'tr-td'>".$row["doc_name"]."</td><tr>";
						}
						echo"</table>";
					?>	
				</fieldset>
			</div>
		</article>
	</body>
</html>
