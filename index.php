<?php
    /*
     * David Kislyak
     * 01/15/2020
     * /328/dating/index.php
     */

    session_start();

    // Error reporting
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    //Require autoload file
    require("./vendor/autoload.php");

    //Instantiate F3
    $f3 = Base::instance();

    //Define a default route
    $f3->route('GET /', function() {
        $view = new Template();
        echo $view->render('./views/home.html');
    });

    // -- Define Sign-Up routes --
    //personal information
    $f3->route('GET /signup/information', function() {
        $view = new Template();
        echo $view->render('./views/signup/personal_info.html');
    });

    //profile information
    $f3->route('POST /signup/profile', function() {
        $_SESSION['first-name'] = $_POST['first-name'];
        $_SESSION['last-name'] = $_POST['last-name'];
        $_SESSION['name'] =
            ($_SESSION['first-name'].' '.$_SESSION['last-name']);
        $_SESSION['number'] = $_POST['number'];
        $_SESSION['gender'] = $_POST['gender'];
        $_SESSION['age'] = $_POST['age'];

        $view = new Template();
        echo $view->render('./views/signup/profile_signup.html');
    });

    //interest(s) selection
    $f3->route('POST /signup/interests', function() {
        $_SESSION['email'] = $_POST['email'];
        $_SESSION['state'] = $_POST['state'];
        $_SESSION['seeking'] = $_POST['seeking'];
        $_SESSION['biography'] = $_POST['biography'];

        $view = new Template();
        echo $view->render('./views/signup/interests.html');
    });

    //sign-up summary
    $f3->route('POST /signup/summary', function() {
        $_SESSION['indoor'] = $_POST['indoor'];
        $_SESSION['outdoor'] = $_POST['outdoor'];
        // Generate interest string
        $_SESSION['interests'] = generateInterest();

        $view = new Template();
        echo $view->render('./views/signup/summary.html');
    });

    //Run fat free
    $f3->run();

    //Helper functions
    function generateInterest() {
        $return = '';

        foreach($_SESSION['indoor'] as $x) {
            $return .= $x.' ';
        }

        foreach($_SESSION['outdoor'] as $x) {
            $return .= $x.' ';
        }

        return $return;
    }