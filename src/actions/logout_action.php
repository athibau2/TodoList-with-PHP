<?php
session_start();
$_SESSION["error"] = false;
$_SESSION["logged_in"] = false;

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

// Log the user out
$sessionId = $_SESSION["id"];
$conn->query("UPDATE user SET logged_in = false WHERE id = $sessionId");
$conn->close();
session_unset();
session_destroy();
header("Location: ../views/login.php");
exit();
?>
