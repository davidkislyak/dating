<?php
/*
 * David Kislyak
 * 01/15/2020
 * /328/dating/index.php
 */

// Error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Require autoload file
require("./vendor/autoload.php");
require_once('./model/validate.php');

session_start();

//Instantiate F3
$f3 = Base::instance();

//Turn on Fat-Free error reporting
$f3->set('DEBUG', 3);

//Define arrays
$f3->set('genders', array('Male', 'Female'));
$f3->set('partners', array('Male', 'Female'));
$f3->set('indoor', array("tv", "movies", "cooking", "boardgames", "puzzles",
    "reading", "playing cards", "video games"));
$f3->set('outdoor', array("hiking", "biking", "swimming", "collecting",
    "walking", "climbing"));
$f3->set('states', array("Alabama", "Alaska", "American Samoa", "Arizona",
    "Arkansas", "California", "Colorado", "Connecticut",
    "Delaware", "District of Columbia", "Florida",
    "Georgia", "Guam", "Hawaii", "Idaho", "Illinois",
    "Indiana", "Iowa", "Kansas", "Kentucky", "Louisiana",
    "Maine", "Maryland", "Massachusetts", "Michigan",
    "Minnesota", "Minor Outlying Islands", "Mississippi",
    "Missouri", "Montana", "Nebraska", "Nevada",
    "New Hampshire", "New Jersey", "New Mexico",
    "New York", "North Carolina", "North Dakota",
    "Northern Mariana Islands", "Ohio", "Oklahoma",
    "Oregon", "Pennsylvania", "Puerto Rico",
    "Rhode Island", "South Carolina", "South Dakota",
    "Tennessee", "Texas", "U.S. Virgin Islands", "Utah",
    "Vermont", "Virginia", "Washington", "West Virginia",
    "Wisconsin", "Wyoming"));

//Define a default route
$f3->route('GET /', function () {
    $view = new Template();
    echo $view->render('./views/home.html');
});

// -- Define Sign-Up routes --
//personal information
$f3->route('GET|POST /signup/information', function ($f3) {
    session_unset();

    //If form has been submitted, validate
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        //Get data from the form
        $fName = $_POST['first-name'];
        $lName = $_POST['last-name'];
        $age = $_POST['age'];
        $phone = $_POST['phone-number'];
        $gender = $_POST['gender'];
        $membership = $_POST['premium-checkbox'];

        echo 'premium selected: '.$_POST['premium-checkbox'];

        //Add data to hive
        $f3->set('fName', $fName);
        $f3->set('lName', $lName);
        $f3->set('age', $age);
        $f3->set('phone', $phone);
        $f3->set('gender', $gender);

        //If data is valid
        if (validPersonalInfo()) {
            if ($membership == "premium") {
                $member =
                    new PremiumMember($fName, $lName, $age, $gender, $phone);
            } else {
                $member =
                    new Member($fName, $lName, $age, $gender, $phone);
            }

            $_SESSION['member'] = $member;
            $f3->reroute('/signup/profile');

            echo "Form is valid: True";
        }
    }

    $view = new Template();
    echo $view->render('./views/signup/personal_info.html');
});

//profile information
$f3->route('GET|POST /signup/profile', function ($f3) {

    //If form has been submitted, validate
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        //Get data from the form
        $partner = $_POST['partner'];
        $biography = $_POST['biography'];
        $state = $_POST['state'];
        $email = $_POST['email'];

        //Add data to hive
        $f3->set('partner', $partner);
        $f3->set('biography', $biography);
        $f3->set('state', $state);
        $f3->set('email', $email);

        //If data is valid
        if (validProfileSignup()) {
//            $_SESSION['seeking'] = $partner;
//            $_SESSION['biography'] = $biography;
//            $_SESSION['state'] = $state;
//            $_SESSION['email'] = $email;

            $member = $_SESSION['member'];
//            echo "member is set: ".isset($_SESSION['member']);

            $member->setSeeking($partner);
            $member->setBio($biography);
            $member->setState($state);
            $member->setEmail($email);

            if ($_SESSION['member'] instanceof PremiumMember) {
                $f3->reroute('/signup/interests');
            } else {
                $f3->reroute('/signup/summary');
            }
        }
    }

    $view = new Template();
    echo $view->render('./views/signup/profile_signup.html');
});

//interest(s) selection
$f3->route('GET|POST /signup/interests', function ($f3) {

    //If form has been submitted, validate
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        //Get data from the form
        $indoorSelections = $_POST['indoor'];
        $outdoorSelections = $_POST['outdoor'];

        //Add data to hive
        $f3->set('indoorSelections', $indoorSelections);
        $f3->set('outdoorSelections', $outdoorSelections);

        //If data is valid
        if (validInterests()) {
//            $_SESSION['indoor'] = $indoorSelections;
//            $_SESSION['outdoor'] = $outdoorSelections;
            $member = $_SESSION['member'];


            if ($member instanceof PremiumMember) {
                $member->setInDoorInterests($indoorSelections);
                $member->setOutDoorInterests($outdoorSelections);
            }

//            echo 'Indoor Interests: '.$member->getInDoorInterests();
//            echo 'Outdoor Interests: '.$member->getOutDoorInterests();
            $f3->reroute('/signup/summary');
        }
    }

    $view = new Template();
    echo $view->render('./views/signup/interests.html');
});

//sign-up summary
$f3->route('GET /signup/summary', function () {
    // Generate interest string
//    $_SESSION['interests'] = generateInterest();
    if ($_SESSION['member'] instanceof PremiumMember) {
        $_SESSION['member']->setInDoorInterests(generateInDoorInterests());
        $_SESSION['member']->setOutDoorInterests(generateOutDoorInterests());
    }

    $view = new Template();
    echo $view->render('./views/signup/summary.html');
});

//Run fat free
$f3->run();

//Helper functions
//function generateInterests()
//{
//    $return = '';
//
//    if (!sizeof($_SESSION['member']->getInDoorInterests()) == 0) {
//        foreach ($_SESSION['member']->getInDoorInterests() as $x) {
//            $return .= $x . ' ';
//        }
//    }
//
//
//    if (!sizeof($_SESSION['member']->getOutDoorInterests()) == 0) {
//        foreach ($_SESSION['member']->getOutDoorInterests() as $x) {
//            $return .= $x . ' ';
//        }
//    }
//
//    return $return;
//}

function generateInDoorInterests()
{
    $return = '';

    if ($_SESSION['member']->getInDoorInterests() != null) {
        foreach ($_SESSION['member']->getInDoorInterests() as $x) {
            $return .= $x . ' ';
        }
    }

    return $return;
}

function generateOutDoorInterests()
{
    $return = '';

    if ($_SESSION['member']->getOutDoorInterests() != null) {
        foreach ($_SESSION['member']->getOutDoorInterests() as $x) {
            $return .= $x . ' ';
        }
    }

    return $return;
}