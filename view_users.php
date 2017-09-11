
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
/*$db=mysql_select_db(DB_NAME,$con) or die("Failed to connect to MySQL: " . mysql_error());

$ID = $_POST['user'];
$Password = $_POST['pass'];
*/
if(isset($_POST["action"]))
{
 if($_POST["action"] == "fetch_data")
 {		
	$query= $con->query("SELECT userID, fullname, username, email FROM users");
	echo "<div><table border= '1'><tr><td>ID</td><td>Fullname</td><td>Username</td><td>E-mail</td></tr></div>";
	while($row = $query->fetch_assoc())
	{
		$online= 'offline';
		if( isset($_SESSION['username'])){
			if($_SESSION['username'] == $row['username']){$online= 'online';}else{$online= 'offline';}
			}
		echo "<tr><td>".$row["userID"]."</td><td>".$row["fullname"]."</td><td>".$row["username"]."</td><td>".$row["email"]."</td>
		<td>".$online."</td></tr>\n";
	}
	echo"</table>";
 }
}
?>

 
