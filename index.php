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

//Define controller
$controller = new MemberController($f3);

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
    $GLOBALS['controller']->home();
});

// -- Define Sign-Up routes --
//personal information
$f3->route('GET|POST /signup/information', function () {
    $GLOBALS['controller']->signupInformation();
});

//profile information
$f3->route('GET|POST /signup/profile', function () {
    $GLOBALS['controller']->signupProfile();
});

//interest(s) selection
$f3->route('GET|POST /signup/interests', function () {
    $GLOBALS['controller']->signupInterests();
});

//sign-up summary
$f3->route('GET /signup/summary', function () {
    $GLOBALS['controller']->signupSummary();
});

//Run fat free
$f3->run();
