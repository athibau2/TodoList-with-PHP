<?php
session_start();
if ($_SESSION["logged_in"] == false) header("Location: /views/login.php");
?>

<!DOCTYPE html>
<html lang="us-en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <title>Task Website</title>

  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
  <link rel="stylesheet" href="../css/style.css">
</head>

<body>

  <nav class="navbar">
    <a class="navbar-brand">Task List</a>
    <form action="/actions/logout_action.php"><button id="logoutButton" type="submit"><strong>Logout</strong></button></form>
  </nav>
  
  <div class="tasks">
    <h1>Current Tasks</h1>

    <div class="custom-control custom-switch">
      <input type="checkbox" class="custom-control-input" id="customSwitch1">
      <label class="custom-control-label" for="customSwitch1">List by date</label>
    </div>

    <div class="custom-control custom-switch">
      <input type="checkbox" class="custom-control-input" id="customSwitch2">
      <label class="custom-control-label" for="customSwitch2">Filter Out Completed</label>
    </div>
  </div>

    <ul class="list-group" id="taskList">
      <?php 
      // Read variables and create connection
      $mysql_servername = getenv("MYSQL_SERVERNAME");
      $mysql_user = getenv("MYSQL_USER");
      $mysql_password = getenv("MYSQL_PASSWORD");
      $mysql_database = getenv("MYSQL_DATABASE");
      $conn = new mysqli($mysql_servername, $mysql_user, $mysql_password, $mysql_database);

      if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

      $userID = $_SESSION["id"];

      // query for user tasks
      $sqlRead = $conn->prepare("SELECT id, text, date, done FROM task WHERE user_id = ?");
      $sqlRead->bind_param("s", $userID);
      $sqlRead->execute();
      $sqlRead->bind_result($id, $text, $date, $done);

      while ($sqlRead->fetch())    // loop through each task for output
      {
        if ($done == 0)
        {
          echo '<li class="list-group-item">
          <div class="container">
            <div class="row">
              <form action="/actions/update_action.php" method="post">
                <input hidden name="task_id" value="'.$id.'">
                <input hidden name="done" value="'.$done.'">
                <button type="submit" class="invisBtn">
                  <i class="material-icons checkBox">check_box_outline_blank</i>
                </button>
              </form>

              <div class="col-9">'.$text.'</div>            
              <div class="col dueDate">'.$date.'</div>
              
              <form action="/actions/delete_action.php" method="post">
                <input hidden name="delete_id" value="'.$id.'">
                <button type="submit" class="invisBtn">
                  <i class="material-icons removeCircle">remove_circle</i>
                </button>
              </form>
            </div>
          </div>
          </li>';
        }
        else if ($done == 1)
        {
          echo '<li class="list-group-item">
          <div class="container">
            <div class="row">
              <form action="/actions/update_action.php" method="post">
                <input hidden name="task_id" value="'.$id.'">
                <input hidden name="done" value="'.$done.'">
                <button type="submit" class="invisBtn">
                  <i class="material-icons checkBox">check_box</i>
                </button>
              </form>

              <div class="col-9" id="strikeText">'.$text.'</div>            
              <div class="col dueDate">'.$date.'</div>
              
              <form action="/actions/delete_action.php" method="post">
                <input hidden name="delete_id" value="'.$id.'">
                <button type="submit" class="invisBtn">
                  <i class="material-icons removeCircle">remove_circle</i>
                </button>
              </form>
            </div>
          </div>
          </li>';
        }
      }
      ?>
    </ul>

  <form class="formData" action="/actions/create_action.php" method="post">
    <input class="form-group" id="taskInfo" type="task" name="text" required placeholder="Enter your task here">
    <input class="form-group" id="taskDate" type='date' name="date" required>
    <button type="submit" id="AddButton"><strong>Add Task</strong></button>
  </form>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
  <script src="js/script.js"></script>

</body>
</html>