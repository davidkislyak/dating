<?php

/**
 * Class: PremiumMember, represents members with premium, interests data.
 *
 * @author  David Kislyak
 * @version 1.0
 */
class PremiumMember extends Member
{
    private $_inDoorInterests, $_outDoorInterests;

    /**
     * PremiumMember constructor.
     *
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

    /**
     * Creates an indoor interests string
     *
     * @return string
     */
    public function generateInDoorInterests()
    {
        $return = '';

        if ($this->getInDoorInterests() != null) {
            foreach ($this->getInDoorInterests() as $x) {
                $return .= $x . ' ';
            }
        }

        return $return;
    }

    /**
     * Creates an outdoor interests string
     *
     * @return string
     */
    public function generateOutDoorInterests()
    {
        $return = '';

        if ($this->getOutDoorInterests() != null) {
            foreach ($this->getOutDoorInterests() as $x) {
                $return .= $x . ' ';
            }
        }

        return $return;
    }
}
