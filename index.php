<?php
session_start();

//inloggen false of true
if(isset($_SESSION['loggedInUser'])) {
    $login = true;
} else {
    $login = false;
}
//verbinding met de database
/** @var mysqli $db */
require_once "database.php";

//beveiliging
if (isset($_POST['submit'])) {
    $email = mysqli_escape_string($db, $_POST['email']);
    $password = $_POST['password'];

    //error indien er niks ingevuld is
    $errors = [];
    if ($email == '') {
        $errors['email'] = 'fill in an email please';
    }
    if ($password == '') {
        $errors['password'] = 'fill in a password please';
    }

    if (empty($errors)) {
        //haal de gegevens op uit de database
        $query = "SELECT * FROM inlog WHERE email='$email'";
        $result = mysqli_query($db, $query);
        if (mysqli_num_rows($result) == 1) {
            $user = mysqli_fetch_assoc($result);
            if (password_verify($password, $user['password'])) {
                $login = true;

                $_SESSION['loggedInUser'] = [
                    'email' => $user['email'],
                    'id' => $user['id']
                ];
            } else {
                //error voor verkeerde inloggegevens
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
<h2>Inloggen</h2>
<?php if ($login) { ?>
    <p>Je bent ingelogd!</p>
    <p><a href="logout.php">Uitloggen</a> / <a href="homepage.php">home</a></p>
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
