<?php
//Require database in this file
/** @var $db */
require_once "database.php";

//if the id is not given you will be set back to the reservations
if (!isset($_GET['id']) || $_GET['id'] === '') {
    header('Location: SavedR.php');
    exit;
}

//brings up the GET.
$user = $_GET['id'];

//get the result from the database
$query = "SELECT * FROM users WHERE id = " . $user;
$result = mysqli_query($db, $query);

//if the user does not exist you will be set back to the reservations
if (mysqli_num_rows($result) == 0) {
    header('Location: SavedR.php');
    exit;
}

//change the row in the database into an array
$users = mysqli_fetch_assoc($result);

//close the connection
mysqli_close($db);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <title>Details - <?= $users['name'] ?></title>
</head>
<header>Aritec</header>
<body>
<section>
<h2><?= $users['name'] ?></h2>

<ul>
    <li>companyname: <?= $users['companyname'] ?></li>
    <li>date: <?= $users['date'] ?></li>
    <li>email: <?= $users['email'] ?></li>
</ul>
<div>
    <a href="SavedR.php">Go back to the list</a>
</div>
</section>
</body>
</html>