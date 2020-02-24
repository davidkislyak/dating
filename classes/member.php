<?php

/**
 * Class:   Member, represents any member on the site.
 *
 * @author  David Kislyak
 * @version 1.0
 */
class Member
{
    private $_fname, $_lname, $_age, $_gender, $_phone;
    private $_email;
    private $_state;
    private $_seeking;
    private $_bio;

    /**
     * Members constructor.
     *
     * @param $_fname
     * @param $_lname
     * @param $_age
     * @param $_gender
     * @param $_phone
     */
    function __construct($_fname, $_lname, $_age, $_gender, $_phone)
    {
        $this->_fname = $_fname;
        $this->_lname = $_lname;
        $this->_age = $_age;
        $this->_gender = $_gender;
        $this->_phone = $_phone;
    }

    /**
     * @return String
     */
    public function getFname()
    {
        return $this->_fname;
    }

    /**
     * @param String $fname
     */
    public function setFname($fname)
    {
        $this->_fname = $fname;
    }

    /**
     * @return String
     */
    public function getLname()
    {
        return $this->_lname;
    }

    /**
     * @param String $lname
     */
    public function setLname($lname)
    {
        $this->_lname = $lname;
    }

    /**
     * @return Int
     */
    public function getAge()
    {
        return $this->_age;
    }

    /**
     * @param Int $age
     */
    public function setAge($age)
    {
        $this->_age = $age;
    }

    /**
     * @return String
     */
    public function getGender()
    {
        return $this->_gender;
    }

    /**
     * @param String $gender
     */
    public function setGender($gender)
    {
        $this->_gender = $gender;
    }

    /**
     * @return String
     */
    public function getPhone()
    {
        return $this->_phone;
    }

    /**
     * @param String $phone
     */
    public function setPhone($phone)
    {
        $this->_phone = $phone;
    }

    /**
     * @return String
     */
    public function getEmail()
    {
        return $this->_email;
    }

    /**
     * @param String $email
     */
    public function setEmail($email)
    {
        $this->_email = $email;
    }

    /**
     * @return String
     */
    public function getState()
    {
        return $this->_state;
    }

    /**
     * @param String $state
     */
    public function setState($state)
    {
        $this->_state = $state;
    }

    /**
     * @return String
     */
    public function getSeeking()
    {
        return $this->_seeking;
    }

    /**
     * @param String $seeking
     */
    public function setSeeking($seeking)
    {
        $this->_seeking = $seeking;
    }

    /**
     * @return String
     */
    public function getBio()
    {
        return $this->_bio;
    }

    /**
     * @param String $bio
     */
    public function setBio($bio)
    {
        $this->_bio = $bio;
    }
}
