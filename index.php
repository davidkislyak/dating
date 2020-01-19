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

    //Instantiate F3
    $f3 = Base::instance();

    //Define a default route
    $f3->route('GET /', function() {
        $view = new Template();
        echo $view->render('./views/home.html');
    });

    //Run fat free
    $f3->run();