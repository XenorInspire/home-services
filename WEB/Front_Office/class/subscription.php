<?php

class Subscription
{

    private $beginDate;
    private $customerId;
    private $typeId;
    private $remainingHours;

    public function __construct($beginDate, $customerId, $typeId, $remainingHours)
    {

        $this->beginDate = $beginDate;
        $this->customerId = $customerId;
        $this->typeId = $typeId;
        $this->remainingHours = $remainingHours;
    }

    /**
     * Get the value of beginDate
     */
    public function getBeginDate()
    {
        return $this->beginDate;
    }

    /**
     * Set the value of beginDate
     *
     * @return  self
     */
    public function setBeginDate($beginDate)
    {
        $this->beginDate = $beginDate;
        return $this;
    }

    /**
     * Get the value of customerId
     */
    public function getCustomerId()
    {
        return $this->customerId;
    }

    /**
     * Set the value of customerId
     *
     * @return  self
     */
    public function setCustomerId($customerId)
    {
        $this->customerId = $customerId;
        return $this;
    }

    /**
     * Get the value of typeId
     */
    public function getTypeId()
    {
        return $this->typeId;
    }

    /**
     * Set the value of typeId
     *
     * @return  self
     */
    public function setTypeId($typeId)
    {
        $this->typeId = $typeId;
        return $this;
    }

    /**
     * Get the value of remainingHours
     */
    public function getRemainingHours()
    {
        return $this->remainingHours;
    }

    /**
     * Set the value of remainingHours
     *
     * @return  self
     */
    public function setRemainingHours($remainingHours)
    {
        $this->remainingHours = $remainingHours;
        return $this;
    }
}
