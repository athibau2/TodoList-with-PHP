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

$taskID = $_POST["task_id"];
$done = $_POST["done"];
$done = ($done) ? 0 : 1;    // toggles done between true and false (1 and 0)

$updateStmt = $conn->prepare("UPDATE task SET done = ? WHERE id = ?");
$updateStmt->bind_param("ss", $done, $taskID);
$updateStmt->execute();
$updateStmt->close();

header("Location: ../index.php");

?>