<?php
//connection with the database
/** @var $db */
require_once "database.php";

//takes the result from the database
$query = "SELECT * FROM users";
$result = mysqli_query($db, $query);

//goes through the results and makes an adjusted array
$users = [];
while ($row = mysqli_fetch_assoc($result)) {
    $users[] = $row;
}
//security against deeplinking
if (!isset($_SESSION['loggedInUser'])) {
    header("Location: index.php");
    exit;
}

//close the connection with the database
mysqli_close($db);

?>
<!doctype html>
<html lang="en">
<nav>
    <div class="Back"><a href="homepage.php">Back</a></div>
</nav>
<head>

    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>

<body>
<header>
    <h1>Reservations</h1>
</header>
<section>
    <a href="create.php">Create new user</a>
    <table>
        <thead>
        <tr>
            <th></th>
            <th>email</th>
            <th>name</th>
            <th>company name</th>
            <th>date</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $user) { ?>
            <tr>
                <td><?= $user['email'] ?></td>
                <td><?= $user['name'] ?></td>
                <td><?= $user['companyname'] ?></td>
                <td><?= $user['date'] ?></td>
                <td><a href="details.php?id=<?= $user['id'] ?>">Details</a></td>
                <td><a href="delete.php?id=<?= $user['id'] ?>">Delete</a></td>
                <td><a href="edit.php?id=<?= $user['id'] ?>">edit</a></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</section>
</body>
</html>
<footer>
    <p>&copy; Aritec</p>
</footer>

