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

// Store form input in variables
$userID = $_SESSION["id"];
$task = $_POST["text"];
$date = $_POST["date"];
$done = 0;

// Inserting a task
$sql = "INSERT INTO task (user_id, text, date, done) VALUES (?,?,?,?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $userID, $task, $date, $done);
$stmt->execute();
$stmt->close();

header("Location: ../index.php");

?>
