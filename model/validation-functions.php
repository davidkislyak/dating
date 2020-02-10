<?php

//Required
function validAge($age)
{
    return ctype_digit($age) && $age > 1 && $age < 120 ? true : false;
}

function validName($name)
{
    return (!empty(trim($name)) && ctype_alpha($name));
}

function validPhone($phone)
{
    return (preg_match('/^[0-9]{10}+$/', $phone));
}

function validEmail($email)
{
    return preg_match('/^[A-z0-9_\-]+[@][A-z0-9_\-]+([.][A-z0-9_\-]+)+[A-z.]{2,4}$/', $email);
}

//Not required
function validGender($gender)
{
    if (empty($gender)) {
        return true;
    }

    global $f3;

    return in_array($gender, $f3->get('genders'));
}

function validState($state)
{
    if ($state == "default") {
        return true;
    }

    global $f3;

    return in_array($state, $f3->get('states'));
}

function validOutdoor($outdoor)
{
    global $f3;

    if (sizeof($outdoor) == 0) {
        return true;
    }

    foreach ($outdoor as $selectedOutdoor) {
        if (!in_array($selectedOutdoor, $f3->get('outdoor'))) {
            return false;
        }
    }

    return true;
}

function validIndoor($indoor)
{
    global $f3;

    if (sizeof($indoor) == 0) {
        return true;
    }

    foreach ($indoor as $selectedIndoor) {
        if (!in_array($selectedIndoor, $f3->get('indoor'))) {
            return false;
        }
    }

    return true;
}
