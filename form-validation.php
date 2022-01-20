<?php
//check if the data is correct and filled in, when not, show an error
$errors = [];


if ($name == "") {
    $errors['name'] = 'name cannot be empty';
}
if ($companyname == "") {
    $errors['companyname'] = 'companyname cannot be empty';

}
if ($date == "") {
    $errors['date'] = 'date cannot be empty';
}

if ($email == "") {
    $errors['email'] = 'email cannot be empty';
}
