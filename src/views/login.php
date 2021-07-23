<?php
session_start();
?>

<!DOCTYPE html>

<html lang="us-en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <title>Login Page</title>

  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
  <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <div>
        <?php
            if ($_SESSION["error"] == true)
            {
                $errorMessage = $_SESSION["errormessage"];
                echo "<p style='text-align: center; color: red; border: solid; border-radius: 60px; border-color: red;'><strong>$errorMessage</strong></p>";
            }
            $_SESSION["error"] = false;
        ?>
    </div>

    <form id="loginForm" action="../actions/login_action.php" method="post">
        <div id="login-welcome">Welcome! Please Login</div>
        <div class="mb-3">
            <label for="inputUsername" class="form-label">Username</label>
            <input type="username" class="form-control" id="inputUsername" name="username" required>
        </div>
        <div class="mb-3">
            <label for="inputPassword" class="form-label">Password</label>
            <input type="password" class="form-control" id="inputPassword" name="password" required>
        </div>
        <button type="submit" class="btn btn-dark"><strong>Login</strong></button>
    </form>
    <form id="loginToRegister" action="register.php">
        <span style="font-size: 13.6px"><em>Not a member? Register here: </em></span>
        <button type="submit" class="btn btn-dark"><strong>Register</strong></button>
    </form>

</body>