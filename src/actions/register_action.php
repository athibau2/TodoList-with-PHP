<?php
session_start();
$_SESSION["error"] = false;

function throwError($errorMessage)
{
	$_SESSION["error"] = true;
	$_SESSION["errormessage"] = $errorMessage;
	header("Location: ../views/register.php");
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

// Register a new user
$username = $_POST["username"];
$password1 = $_POST["password1"];
$password2 = $_POST["password2"];

// password checking
if ($password1 != $password2) throwError("Passwords do not match; please try again.");


// username checking 
$sql = "SELECT username FROM user WHERE username = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) 
{
	throwerror("Username already exists");
	$stmt->close();
}
else	// adding user to database
{
	$hashedPass = password_hash($password1, PASSWORD_DEFAULT);
	$logged = 1;
	$stmt->close();
	$stmt = $conn->prepare("INSERT INTO user (username, password, logged_in) VALUES(?, ?, ?)");
	$stmt->bind_param("sss", $username, $hashedPass, $logged);
	$stmt->execute();
	$stmt->close();
	$idstmt = $conn->prepare("SELECT id FROM user WHERE username = ?");
	$idstmt->bind_param("s", $username);
	$idstmt->execute();
	$idstmt->bind_result($userID);
	$idstmt->fetch();
	$idstmt->close();
	$_SESSION["username"] = $username;
	$_SESSION["logged_in"] = true;
	$_SESSION["id"] = $userID;
	header("Location: ../index.php");
}

?>
