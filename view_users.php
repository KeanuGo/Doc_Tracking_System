
<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'document_tracking_system');
define('DB_USER','root');
define('DB_PASSWORD','Jethshanroyce1204');

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
	$query= $con->query("SELECT userID, fullname, username, email, active FROM users WHERE activated = 'Y'");
	echo "<div><fieldset id = 'fs' style = 'width: 95%'><table id= 'table' border= '1'><tr><td>ID</td><td>Fullname</td><td>Username</td><td>E-mail</td></tr></div>";
	while($row = $query->fetch_assoc())
	{
		echo "<tr><td>".$row["userID"]."</td><td>".$row["fullname"]."</td><td>".$row["username"]."</td><td>".$row["email"]."</td>
		<td>".$row["active"]."</td>\n";
		echo "<td><button name =  ".$row["userID"] ." id = 'button3' onclick='deactivateAcc(this.name)'>FIRE</button></td></tr>";
	}
	echo"</fieldset></table>";
	echo '<script>function deactivateAcc(ID){
			window.location=("deactivate.php?ID="+ID);
		}</script>';
 }
}
?>

 
