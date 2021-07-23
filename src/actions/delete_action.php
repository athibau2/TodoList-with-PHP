<?php
session_start();

// Read variables and create connection
$mysql_servername = getenv("MYSQL_SERVERNAME");
$mysql_user = getenv("MYSQL_USER");
$mysql_password = getenv("MYSQL_PASSWORD");
$mysql_database = getenv("MYSQL_DATABASE");
$conn = new mysqli($mysql_servername, $mysql_user, $mysql_password, $mysql_database);

// Check connection
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$taskID = $_POST["delete_id"];

$deleteStmt = $conn->prepare("DELETE FROM task WHERE id = ?");
$deleteStmt->bind_param("s", $taskID);
$deleteStmt->execute();
$deleteStmt->close();

header("Location: ../index.php");

?>