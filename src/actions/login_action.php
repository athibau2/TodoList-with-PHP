<?php
session_start();
$_SESSION["error"] = false;

function throwError($errorMessage)
{
	$_SESSION["error"] = true;
	$_SESSION["errormessage"] = $errorMessage;
	header("Location: ../views/login.php");
	exit();
}

// Read variables and create connection
$mysql_servername = getenv("MYSQL_SERVERNAME");
$mysql_user = getenv("MYSQL_USER");
$mysql_password = getenv("MYSQL_PASSWORD");
$mysql_database = getenv("MYSQL_DATABASE");


$conn = new mysqli($mysql_servername, $mysql_user, $mysql_password, $mysql_database);

// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

// User entry
$username = $_POST["username"];
$password = $_POST["password"];


// username checking 
$sql = "SELECT username FROM user WHERE username = ?";

$sqlStmt = $conn->prepare($sql);
$sqlStmt->bind_param("s", $username);
$sqlStmt->execute();
$sqlStmt->store_result();

if ($sqlStmt->num_rows == 0) 
{
	throwerror("User does not exist. Please try again.");
	$sqlStmt->close();
}
else	// logging user in
{
	$sqlStmt->close();
	$loginStmt = $conn->prepare("SELECT username, password, id FROM user WHERE username = ?");
	$loginStmt->bind_param("s", $username);
	$loginStmt->execute();
	$loginStmt->bind_result($user, $hashPass, $id);
	$loginStmt->fetch();

	if (!password_verify($password, $hashPass)) 
	{
		throwerror("Incorrect password");
		$loginStmt->close();
	}
	else
	{
		$_SESSION["username"] = $user;
		$_SESSION["logged_in"] = true;
		$_SESSION["id"] = $id;
		$loginStmt->close();
		$conn->query("UPDATE user SET logged_in = true WHERE id = $id");
		$conn->close();
		header("Location: ../index.php");
	}
}

?>