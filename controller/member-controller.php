<?php

/**
 * Class: MemberController, in charge of containing the routing logic
 *
 * @author  David Kislyak
 * @version 1.0
 */
class MemberController
{
    private $_f3;
    private $_db;

    /**
     * MemberController constructor.
     *
     * @param $f3
     */
    public function __construct($f3)
    {
        $this->_f3 = $f3;
    }

    /**
     * Home route
     */
    public function home()
    {
        $view = new Template();
        echo $view->render('./views/home.html');
    }

    /**
     * Basic Information Page
     */
    public function signupInformation()
    {
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

            //Add data to hive
            $this->_f3->set('fName', $fName);
            $this->_f3->set('lName', $lName);
            $this->_f3->set('age', $age);
            $this->_f3->set('phone', $phone);
            $this->_f3->set('gender', $gender);

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
                $this->_f3->reroute('/signup/profile');
            }
        }

        $view = new Template();
        echo $view->render('./views/signup/personal_info.html');
    }

    /**
     * Expanded profile details
     */
    public function signupProfile()
    {
        //If form has been submitted, validate
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            //Get data from the form
            $partner = $_POST['partner'];
            $biography = $_POST['biography'];
            $state = $_POST['state'];
            $email = $_POST['email'];

            //Add data to hive
            $this->_f3->set('partner', $partner);
            $this->_f3->set('biography', $biography);
            $this->_f3->set('state', $state);
            $this->_f3->set('email', $email);

            //If data is valid
            if (validProfileSignup()) {
                $member = $_SESSION['member'];

                $member->setSeeking($partner);
                $member->setBio($biography);
                $member->setState($state);
                $member->setEmail($email);

                if ($_SESSION['member'] instanceof PremiumMember) {
                    $this->_f3->reroute('/signup/interests');
                } else {
                    $this->_f3->reroute('/signup/summary');
                }
            }
        }

        $view = new Template();
        echo $view->render('./views/signup/profile_signup.html');
    }

    /**
     * Premium, profile details
     */
    public function signupInterests()
    {
        //If form has been submitted, validate
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            //Get data from the form
            $indoorSelections = $_POST['indoor'];
            $outdoorSelections = $_POST['outdoor'];

            //Add data to hive
            $this->_f3->set('indoorSelections', $indoorSelections);
            $this->_f3->set('outdoorSelections', $outdoorSelections);

            //If data is valid
            if (validInterests()) {
                $member = $_SESSION['member'];


                if ($member instanceof PremiumMember) {
                    $member->setInDoorInterests($indoorSelections);
                    $member->setOutDoorInterests($outdoorSelections);
                }

                $this->_f3->reroute('/signup/summary');
            }
        }

        $view = new Template();
        echo $view->render('./views/signup/interests.html');
    }

    /**
     * Overall, profile creation summary
     */
    public function signupSummary()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->_f3->reroute('/signup/submit');
        }

        $view = new Template();
        echo $view->render('./views/signup/summary.html');
    }

    // ---Helper functions---
//    function test()
//    {
//        $this->_db = new Database();
//
//        $db = $this->_db;
//
//        echo "<br><br>Get all members: ";
//        var_dump(highlight_string("\n<?\n". var_export($db->getMembers(), true)));
//
//
//        echo "<br><br>Get member 1: ";
//        var_dump(highlight_string("\n<?\n". var_export($db->getMember(1), true)));
//
//
//        echo "<br><br>Get member 1 interests: ";
//        var_dump(highlight_string("\n<?\n". var_export($db->getInterests(1), true)));
//
//        $member = new PremiumMember('Joe', 'Bidden', 65,
//                             0, '0321654987');
//        $member->setEmail('JoeBidden@campain.com');
//        $member->setState("Washington");
//        $member->setSeeking(1);
//        $member->setBio("Just another corrupt politician looking for another wife to divorce.");
//        $member->setInDoorInterests(array("tv", "movies", "puzzles"));
//        $member->setOutDoorInterests(array("biking", "climbing"));
//
//        echo "<br><br>Insert member: ";
//        var_dump(highlight_string("\n<?\n". var_export($member, true)));
//        echo "<br><br>Insert Success: ".$db->insertMember($member);
//    }

    public function submit() {
        //database object
        $this->_db = new Database();

        var_dump(highlight_string("\n<?\n". var_export($_SESSION['member'], true)));

        $this->_db->insertMember($_SESSION['member']);
    }
}
