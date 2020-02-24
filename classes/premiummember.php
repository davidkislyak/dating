<?php


class PremiumMember extends members
{
    private $_inDoorInterests, $_outDoorInterests;

    /**
     * PremiumMember constructor.
     * @param $_inDoorInterests
     * @param $_outDoorInterests
     * @param $_fname
     * @param $_lname
     * @param $_age
     * @param $_gender
     * @param $_phone
     * @param $_email
     * @param $_state
     * @param $_seeking
     * @param $_bio
     */
    public function __construct($_inDoorInterests, $_outDoorInterests,
                                $_fname, $_lname, $_age, $_gender, $_phone,
                                $_email, $_state, $_seeking, $_bio)
    {
        parent::__construct($_fname, $_lname, $_age, $_gender, $_phone,
            $_email, $_state, $_seeking, $_bio);
        $this->_inDoorInterests = $_inDoorInterests;
        $this->_outDoorInterests = $_outDoorInterests;
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
