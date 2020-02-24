<?php


class PremiumMember extends Member
{
    private $_inDoorInterests, $_outDoorInterests;

    /**
     * PremiumMember constructor.
     * @param $_fname
     * @param $_lname
     * @param $_age
     * @param $_gender
     * @param $_phone
     */
    function __construct($_fname, $_lname, $_age, $_gender, $_phone)
    {
        parent::__construct($_fname, $_lname, $_age, $_gender, $_phone);
    }

    /**
     * @return mixed
     */
    public function getInDoorInterests()
    {
        return $this->_inDoorInterests;
    }

    /**
     * @param mixed $inDoorInterests
     */
    public function setInDoorInterests($inDoorInterests)
    {
        $this->_inDoorInterests = $inDoorInterests;
    }

    /**
     * @return mixed
     */
    public function getOutDoorInterests()
    {
        return $this->_outDoorInterests;
    }

    /**
     * @param mixed $outDoorInterests
     */
    public function setOutDoorInterests($outDoorInterests)
    {
        $this->_outDoorInterests = $outDoorInterests;
    }
}
