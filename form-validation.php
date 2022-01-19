<?php
//check of de data klopt, als het afwijkt, geef een error
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
