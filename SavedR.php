<?php
//connectie database
/** @var $db */
require_once "database.php";

//haal t resultaat uit de database
$query = "SELECT * FROM users";
$result = mysqli_query($db, $query);

//gaat door t resultaat heen en maakt een aangepastte array aan
$users = [];
while ($row = mysqli_fetch_assoc($result)) {
    $users[] = $row;
}

//sluit de connectie
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

