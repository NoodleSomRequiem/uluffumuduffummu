<?php
/** @var mysqli $db */

//make a connection with the database
require_once "database.php";


if (isset($_POST['submit'])) {

    // Get the user from the database
    $userId = mysqli_escape_string($db, $_POST['id']);
    $query = "SELECT * FROM users WHERE id = '$userId'";
    $result = mysqli_query($db, $query) or die ('Error: ' . $query);

    $user = mysqli_fetch_assoc($result);

    if (!empty($user['image'])) {
        deleteImageFile($user['image']);
    }
    //scurity against deeplinking
    if (!isset($_SESSION['loggedInUser'])) {
        header("Location: index.php");
        exit;
    }

    // delete data of the user from the database.
    $query = "DELETE FROM users WHERE id = '$userId'";
    mysqli_query($db, $query) or die ('Error: ' . mysqli_error($db));

    //Close connection with database
    mysqli_close($db);

    //go back to homepage after deleted
    header("Location: SavedR.php");
    exit;

} else if (isset($_GET['id']) || $_GET['id'] != '') {
    //bring up the Get from super global
    $userId = mysqli_escape_string($db, $_GET['id']);

    //Get the user from the database
    $query = "SELECT * FROM users WHERE id = '$userId'";
    $result = mysqli_query($db, $query) or die ('Error: ' . $query);
    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
    } else {
        // redirect when db returns no result
        header('Location: SavedR.php');
        exit;
    }
} else {


    // redirect to reservations
    header('Location: SavedR.php');
    exit;
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <title>Delete - <?= $user['name'] ?></title>
</head>
<body>
<h2>Delete - <?= $user['name'] ?></h2>
<form action="" method="post">
    <p>
         Are you sure you want to delete"<?= $user['name'] ?>" from the reservations?
    </p>
    <input type="hidden" name="id" value="<?= $user['id'] ?>"/>
    <input type="submit" name="submit" value="Delete"/>
</form>
</body>
</html>
