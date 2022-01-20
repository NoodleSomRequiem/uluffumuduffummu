<?php
session_start();

//Log in is false or tru
if(isset($_SESSION['loggedInUser'])) {
    $login = true;
} else {
    $login = false;
}
//connection with the dtatabase
/** @var mysqli $db */
require_once "database.php";

//security against wrong data that has been filled in
if (isset($_POST['submit'])) {
    $email = mysqli_escape_string($db, $_POST['email']);
    $password = $_POST['password'];

    //security against deeplinking
    if (!isset($_SESSION['loggedInUser'])) {
        header("Location: index.php");
        exit;
    }
    //error when nothing has been filled in
    $errors = [];
    if ($email == '') {
        $errors['email'] = 'fill in an email please';
    }
    if ($password == '') {
        $errors['password'] = 'fill in a password please';
    }

    if (empty($errors)) {
        //select the data from the database
        $query = "SELECT * FROM inlog WHERE email='$email'";
        $result = mysqli_query($db, $query);
        if (mysqli_num_rows($result) == 1) {
            $user = mysqli_fetch_assoc($result);
            //this verifies your password and then logs you in
            if (password_verify($password, $user['password'])) {
                $login = true;

                $_SESSION['loggedInUser'] = [
                    'email' => $user['email'],
                    'id' => $user['id']
                ];
                //this gives an error if the data of the password is incorrect
            } else {
                //error for wrong filled in data
                $errors['loginFailed'] = 'This combination of e-mail and password has not been registrated with us, try again.';

            }
        }
    }
}
?>
<!doctype html>
<html lang="en">
<nav><div class="register"><a href="register.php">make an account</a></div></nav>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <title>Login</title>
</head>
<header>Aritec</header>
<body>
<section>
<h2>Log in</h2>
<?php if ($login) { ?>
    <p>You are logged in!</p>
    <p><a href="logout.php">Log out</a> / <a href="homepage.php">home</a></p>
<?php } else { ?>
    <form action="" method="post">

        <div>
            <label for="email">Email</label>
            <input id="email" type="text" name="email" value="<?= $email ?? '' ?>"/>
            <span class="errors"><?= $errors['email'] ?? '' ?></span>
        </div>
        <div>
            <label for="password">Wachtwoord</label>
            <input id="password" type="password" name="password" />
            <span class="errors"><?= $errors['password'] ?? '' ?></span>
        </div>
        <div>
            <p class="errors"><?= $errors['loginFailed'] ?? '' ?></p>
            <input type="submit" name="submit" value="Login"/>
        </div>
    </form>

<?php } ?>
</section>
</body>
</html>
