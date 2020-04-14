<?php

class Service
{
    private $serviceId;
    private $serviceTypeId;
    private $serviceTitle;
    private $description;
    private $recurrence;
    private $timeMin;
    private $servicePrice;
    private $commission;

    public function __construct($serviceId, $serviceTypeId, $serviceTitle, $description, $recurrence, $timeMin, $servicePrice, $commission)
    {
        $this->serviceId = $serviceId;
        $this->serviceTypeId = $serviceTypeId;
        $this->serviceTitle = $serviceTitle;
        $this->description = $description;
        $this->recurrence = $recurrence;
        $this->timeMin = $timeMin;
        $this->servicePrice = $servicePrice;
        $this->commission = $commission;
    }

    /**
     * Get the value of serviceId
     */
    public function getServiceId()
    {
        return $this->serviceId;
    }

    /**
     * Set the value of serviceId
     *
     * @return  self
     */
    public function setServiceId($serviceId)
    {
        $this->serviceId = $serviceId;
        return $this;
    }

    /**
     * Get the value of serviceTypeId
     */
    public function getServiceTypeId()
    {
        return $this->serviceTypeId;
    }

    /**
     * Set the value of serviceTypeId
     *
     * @return  self
     */
    public function setServiceTypeId($serviceTypeId)
    {
        $this->serviceTypeId = $serviceTypeId;
        return $this;
    }

    /**
     * Get the value of serviceTitle
     */
    public function getServiceTitle()
    {
        return $this->serviceTitle;
    }

    /**
     * Set the value of serviceTitle
     *
     * @return  self
     */
    public function setServiceTitle($serviceTitle)
    {
        $this->serviceTitle = $serviceTitle;
        return $this;
    }

    /**
     * Get the value of description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Get the value of recurrence
     */
    public function getRecurrence()
    {
        return $this->recurrence;
    }

    /**
     * Set the value of recurrence
     *
     * @return  self
     */
    public function setRecurrence($recurrence)
    {
        $this->recurrence = $recurrence;
        return $this;
    }

    /**
     * Get the value of timeMin
     */
    public function getTimeMin()
    {
        return $this->timeMin;
    }

    /**
     * Set the value of timeMin
     *
     * @return  self
     */
    public function setTimeMin($timeMin)
    {
        $this->timeMin = $timeMin;
        return $this;
    }

    /**
     * Get the value of servicePrice
     */
    public function getServicePrice()
    {
        return $this->servicePrice;
    }

    /**
     * Set the value of servicePrice
     *
     * @return  self
     */
    public function setServicePrice($servicePrice)
    {
        $this->servicePrice = $servicePrice;
        return $this;
    }

    /**
     * Get the value of commission
     */
    public function getCommission()
    {
        return $this->commission;
    }

    /**
     * Set the value of commission
     *
     * @return  self
     */
    public function setCommission($commission)
    {
        $this->commission = $commission;
        return $this;
    }

    public function __toString(): string
    {
        $vars = get_object_vars($this);
        return json_encode($vars);
    }
}
