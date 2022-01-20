<?php

//connection with database
if(isset($_POST['submit'])) {
    require_once "database.php";

    /** @var mysqli $db */

    //security against wrong data that has been filled in
    $email = mysqli_escape_string($db, $_POST['email']);
    $password = $_POST['password'];

    //security against deeplinking
    if (!isset($_SESSION['loggedInUser'])) {
        header("Location: index.php");
        exit;
    }

    //error when nothing has been filled in
    $errors = [];
    if($email == '') {
        $errors['email'] = 'fill in your e-mail please';
    }
    if($password == '') {
        $errors['password'] = 'fill in a password please';
    }
//password hashing, so that your password is safe and hidden
    if(empty($errors)) {
        $password = password_hash($password, PASSWORD_DEFAULT);
//data is placed in the database
        $query = "INSERT INTO inlog (email, password) VALUES ('$email', '$password')";

        //data is now in database
        $result = mysqli_query($db, $query)
        // de gegevens zitten niet in de database
        or die('Db Error: '.mysqli_error($db).' with query: '.$query);

        //when succesfull, return to the login page
        if ($result) {
            header('Location: index.php');
            exit;
        }
    }
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
    <title>Register</title>
</head>
<body>
<h2>register new user</h2>
<form action="" method="post">
    <div class="data-field">
        <label for="email">E-mail</label>
        <input id="email" type="text" name="email" value="<?= $email ?? '' ?>"/>
        <span class="errors"><?= $errors['email'] ?? '' ?></span>
    </div>
    <div class="data-field">
        <label for="password">Wachtwoord</label>
        <input id="password" type="password" name="password" value="<?= $password ?? '' ?>"/>
        <span class="errors"><?= $errors['password'] ?? '' ?></span>
    </div>
    <div class="data-submit">
        <input type="submit" name="submit" value="Registrer"/>
    </div>
</form>

</body>
</html>
