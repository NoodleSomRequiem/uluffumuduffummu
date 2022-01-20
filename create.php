<?php
//connection with the database
/** @var mysqli $db */

//ga na of de Post 'isset' is.
if (isset($_POST['submit'])) {
    //Require database
    require_once "database.php";

    //security against deeplinking
    if (!isset($_SESSION['loggedInUser'])) {
        header("Location: index.php");
        exit;
    }

    //security against wrong data that has been filled in
    $name   = mysqli_escape_string($db, $_POST['name']);
    $companyname = mysqli_escape_string($db, $_POST['companyname']);
    $date  = mysqli_escape_string($db, $_POST['date']);
    $email = mysqli_escape_string($db, $_POST['email']);

    //Require the form validation
    require_once "form-validation.php";

    if (empty($errors)) {

        //save new user to the database
        $query = "INSERT INTO users (name, companyname, date, email)
                  VALUES ('$name','$companyname','$date', '$email')";
        $result = mysqli_query($db, $query) or die('Error: '.mysqli_error($db). ' with query ' . $query);

        //when result shows, go back to the make a reservation page
        if ($result) {
            header('Location: create.php');
            exit;
        } else {
            $errors['db'] = 'Something went wrong in your database query: ' . mysqli_error($db);
        }

        //Close connection with database
        mysqli_close($db);
    }
}
?>
<!doctype html>
<html lang="en">
<head>
<nav>
    <div class="Back"><a href="homepage.php">Back</a></div>
</nav>
<meta charset="UTF-8">
<title>Make an appointment</title>

<header>Make an appointment</header>
</head>
<link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
<body>
<h1>Fill in your data</h1>

<?php if (isset($errors['db'])) { ?>
    <div><span class="errors"><?= $errors['db']; ?></span></div>
<?php } ?>
<section>
<form action="" method="post" enctype="multipart/form-data">
    <div class="data-field">
        <label for="name">name</label>
        <input id="name" type="text" name="name" value="<?= isset($name) ? htmlentities($name) : '' ?>"/>
        <span class="errors"><?= $errors['name'] ?? '' ?></span>
    </div>
    <div class="data-field">
        <label for="companyname">companyname</label>
        <input id="companyname" type="text" name="companyname" value="<?= isset($companyname) ? htmlentities($companyname) : '' ?>"/>
        <span class="errors"><?= isset($errors['companyname']) ? $errors['companyname'] : '' ?></span>
    </div>
    <div class="data-field">
        <label for="date">date</label>
        <input id="date" type="text" name="date" value="<?= isset($date) ? htmlentities($date) : '' ?>"/>
        <span class="date"><?= isset($errors['date']) ? $errors['date'] : '' ?></span>
    </div>
    <div class="data-field">
        <label for="email">email</label>
        <input id="email" type="text" name="email" value="<?= isset($email) ? htmlentities($email) : '' ?>"/>
        <span class="errors"><?= isset($errors['email']) ? $errors['email'] : '' ?></span>
    </div>



<div class="data-submit">
    <input type="submit" name="submit" value="Save"/>
</div>
</form>
</body>
</section>
</html>
