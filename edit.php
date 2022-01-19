<?php
//this makes a connection with the database
/** @var mysqli $db */

$userId = $_GET['id'];
//hecks if the post is "isset".
if (isset($_POST['submit'])) {

    require_once "database.php";

    //this secures the data you fill in
    $name   = mysqli_escape_string($db, $_POST['name']);
    $companyname = mysqli_escape_string($db, $_POST['companyname']);
    $date  = mysqli_escape_string($db, $_POST['date']);
    $email  = mysqli_escape_string($db, $_POST['email']);

    //brings up your form validation
    require_once "form-validation.php";


    if (empty($errors)) {
        //saves the filled in data in your database
        $query = "UPDATE users SET name='$name',companyname='$companyname',date='$date',email='$email' WHERE id='$userId'";
        $result = mysqli_query($db, $query) or die('Error: '.mysqli_error($db). ' with query ' . $query);

        //If the result shows you will go back to the page with reservations, else you will get an error
        if ($result) {
            header('SavedR: homepage.php');
            exit;
        } else {
            $errors['db'] = 'Something went wrong: ' . mysqli_error($db);
        }

        //here you close the connection with the database
        mysqli_close($db);
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" href="https://media-exp1.licdn.com/dms/image/C4E0BAQHUo_h0JGtwYw/company-logo_200_200/0/1606490589727?e=2159024400&v=beta&t=MznxbjFunN-3xUqfv2aTCkKzTL8AGNJ4VwoYb3oc1Wk" />
    <title>Edit</title>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>
<body>
<header>

    <h1>Edit</h1>
</header>
<section>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="data-field">
            <label for="name">Name</label>
            <input id="name" type="text" name="name" value="<?= isset($name) ? htmlentities($name) : '' ?>"/>
            <span class="errors"><?= isset($errors['name']) ? $errors['name'] : '' ?></span>
        </div>
        <div class="data-field">
            <label for="companyname">Company name</label>
            <input id="companyname" type="text" name="companyname" value="<?= isset($companyname) ? htmlentities($companyname) : '' ?>"/>
            <span class="errors"><?= isset($errors['companyname']) ? $errors['companyname'] : '' ?></span>
        </div>
        <div class="data-field">
            <label for="date">Date</label>
            <input id="date" type="date" name="date" value="<?= isset($date) ? htmlentities($date) : '' ?>"/>
            <span class="errors"><?= isset($errors['date']) ? $errors['date'] : '' ?></span>
        </div>
        <div class="data-field">
            <label for="email">E-mail</label>
            <input id="email" type="text" name="email" value="<?= isset($email) ? htmlentities($email) : '' ?>"/>
            <span class="errors"><?= isset($errors['email']) ? $errors['email'] : '' ?></span>
        </div>
        <div class="data-submit">
            <input type="submit" name="submit" value="Save"/>
        </div>
    </form>
</section>
<div>
    <a href="SavedR.php">Go back to the list</a>
</div>
</body>
</html>
<footer>
    <p>&copy; Aritec</p>
</footer>

