<?php

class MemberController
{
    private $_f3;

    public function __construct($f3)
    {
        $this->_f3 = $f3;
    }

    public function home()
    {
        $view = new Template();
        echo $view->render('./views/home.html');
    }

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

            echo 'premium selected: ' . $_POST['premium-checkbox'];

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

                echo "Form is valid: True";
            }
        }

        $view = new Template();
        echo $view->render('./views/signup/personal_info.html');
    }

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

    public function signupSummary()
    {
        // Generate interest string
        if ($_SESSION['member'] instanceof PremiumMember) {
            $_SESSION['member']->setInDoorInterests($this->generateInDoorInterests());
            $_SESSION['member']->setOutDoorInterests($this->generateOutDoorInterests());
        }

        $view = new Template();
        echo $view->render('./views/signup/summary.html');
    }

    //Helper functions
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
}