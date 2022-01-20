<?php
session_start();

//security against deeplinking
if (!isset($_SESSION['loggedInUser'])) {
    header("Location: index.php");
    exit;
}


//Take the e-mail from the session
$email = $_SESSION['loggedInUser']['email'];
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>secure page</title>
</head>
<body>
<h2>Secure page</h2>
<p>This is a secured page, you may only enter if you are logged in.</p>
<p>Welcome, <?= $email ?></p>
<p><a href="logout.php">Log out</a></p>
</body>
</html>
