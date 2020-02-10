<?php

require_once('validation-functions.php');

function validPersonalInfo()
{
    global $f3;
    $isValid = true;

    if (!validName($f3->get('fName'))) {
        $isValid = false;
        $f3->set("errors['fName']", "Please enter a valid first name.");
    }

    if (!validName($f3->get('lName'))) {
        $isValid = false;
        $f3->set("errors['lName']", "Please enter a valid last name.");
    }

    if (!validAge($f3->get('age'))) {
        $isValid = false;
        $f3->set("errors['age']", "Please enter a valid age.");
    }

    if (!validPhone($f3->get('phone'))) {
        $isValid = false;
        $f3->set("errors['phone']", "Please enter a valid phone number.");
    }

    if (!validGender($f3->get('gender'))) {
        $isValid = false;
        $f3->set("errors['gender']", "Please select a valid gender.");
    }

    return $isValid;
}

function validProfileSignup()
{
    global $f3;
    $isValid = true;

    if (!validGender($f3->get('partner'))) {
        $isValid = false;
        $f3->set("errors['partner']", "Please select a valid partner.");
    }

    if (!validState($f3->get('state'))) {
        $isValid = false;
        $f3->set("errors['state']", "Please select a valid state.");
    }

    if (!validEmail($f3->get('email'))) {
        $isValid = false;
        $f3->set("errors['email']", "Please enter a valid email.");
    }

    return $isValid;
}

function validInterests()
{
    global $f3;
    $isValid = true;

    if (!validIndoor($f3->get('indoorSelections'))) {
        $isValid = false;
        $f3->set("errors['indoor']", "- Please select valid indoor activities.");
    }

    if (!validOutdoor($f3->get('outdoorSelections'))) {
        $isValid = false;
        $f3->set("errors['outdoor']", "- Please select valid outdoor activities.");
    }

    return $isValid;
}