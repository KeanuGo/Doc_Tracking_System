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
<title>Sign-In</title>
</head>
<body id="body-color">
	<fieldset style="width:30%"><legend>Document Code List</legend>
		<form method="POST" action="add_doc_code.html">
		<input id="button" type="submit" name="submit" value="Add Document Code">
		</form>
		<?php
			$query= $con->query("SELECT * FROM doc_code_list ORDER BY doc_code");
			echo "<div><table border= '1'><tr><td>Doc Code ID</td><td>Document Code</td><td>Document Name</td></tr></div>";
			$i=0;
			while($row = $query->fetch_assoc())
			{
			$i=$i+1;
			echo "<tr><td>".$i."</td><td>".$row["doc_code"]."</td><td>".$row["doc_name"]."</td><tr>";
			}
			echo"</table>";

		?>
	</fieldset>
	</div>
</body>
</html>
