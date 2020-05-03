<?php

class Estimate
{
    private $estimateId;
    private $customerId;
    private $customerLastName;
    private $customerFirstName;
    private $customerAddress;
    private $customerTown;
    private $email;
    private $estimateDate;
    private $serviceProvidedDate;
    private $serviceProvidedHour;
    private $hours;
    private $serviceId;
    private $totalPrice;

    public function __construct($estimateId, $customerId, $customerLastName, $customerFirstName, $customerAddress, $customerTown, $email, $estimateDate, $serviceProvidedDate, $serviceProvidedHour, $hours, $serviceId, $totalPrice)
    {
        $this->estimateId = $estimateId;
        $this->customerId = $customerId;
        $this->customerLastName = $customerLastName;
        $this->customerFirstName = $customerFirstName;
        $this->customerAddress = $customerAddress;
        $this->customerTown = $customerTown;
        $this->email = $email;
        $this->estimateDate = $estimateDate;
        $this->serviceProvidedDate = $serviceProvidedDate;
        $this->serviceProvidedHour = $serviceProvidedHour;
        $this->hours = $hours;
        $this->serviceId = $serviceId;
        $this->totalPrice = $totalPrice;
    }

    public function __toString(): string
    {
        $vars = get_object_vars($this);
        return json_encode($vars);
    }

    /**
     * Get the value of estimateId
     */
    public function getEstimateId()
    {
        return $this->estimateId;
    }

    /**
     * Get the value of customerId
     */
    public function getCustomerId()
    {
        return $this->customerId;
    }

    /**
     * Get the value of customerLastName
     */
    public function getCustomerLastName()
    {
        return $this->customerLastName;
    }

    /**
     * Get the value of customerFirstName
     */
    public function getCustomerFirstName()
    {
        return $this->customerFirstName;
    }

    /**
     * Get the value of customerAddress
     */
    public function getCustomerAddress()
    {
        return $this->customerAddress;
    }

    /**
     * Get the value of customerTown
     */
    public function getCustomerTown()
    {
        return $this->customerTown;
    }

    /**
     * Get the value of email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Get the value of serviceId
     */
    public function getServiceId()
    {
        return $this->serviceId;
    }

    /**
     * Get the value of totalPrice
     */
    public function getTotalPrice()
    {
        return $this->totalPrice;
    }

    /**
     * Get the value of serviceProvidedDate
     */
    public function getServiceProvidedDate()
    {
        return $this->serviceProvidedDate;
    }

    /**
     * Get the value of estimateDate
     */
    public function getEstimateDate()
    {
        return $this->estimateDate;
    }

    /**
     * Get the value of serviceProvidedHour
     */ 
    public function getServiceProvidedHour()
    {
        return $this->serviceProvidedHour;
    }

    /**
     * Get the value of hours
     */ 
    public function getHours()
    {
        return $this->hours;
    }
}
