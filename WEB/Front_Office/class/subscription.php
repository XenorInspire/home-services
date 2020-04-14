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
     * Get the value of customerId
     */
    public function getCustomerId()
    {
        return $this->customerId;
    }

    /**
     * Get the value of typeId
     */
    public function getTypeId()
    {
        return $this->typeId;
    }

    /**
     * Get the value of remainingHours
     */
    public function getRemainingHours()
    {
        return $this->remainingHours;
    }
}
