<?php

class Invoicing
{
    private $customerId;
    private $customerLastName;
    private $customerFirstName;
    private $customerAddress;
    private $customerTown;
    private $email;
    private $date;
    private $serviceTitle;
    private $totalPrice;
    private $serviceProvidedId;

    public function __construct($customerId, $customerLastName, $customerFirstName, $customerAddress, $customerTown, $email, $date, $serviceTitle, $totalPrice, $serviceProvidedId)
    {
        $this->customerId = $customerId;
        $this->customerLastName = $customerLastName;
        $this->customerFirstName = $customerFirstName;
        $this->customerAddress = $customerAddress;
        $this->customerTown = $customerTown;
        $this->email = $email;
        $this->date = $date;
        $this->serviceTitle = $serviceTitle;
        $this->totalPrice = $totalPrice;
        $this->serviceProvidedId = $serviceProvidedId;
    }



    /**
     * Get the value of customerLastName
     */
    public function getCustomerLastName()
    {
        return $this->customerLastName;
    }

    /**
     * Set the value of customerLastName
     *
     * @return  self
     */
    public function setCustomerLastName($customerLastName)
    {
        $this->customerLastName = $customerLastName;

        return $this;
    }

    /**
     * Get the value of customerFirstName
     */
    public function getCustomerFirstName()
    {
        return $this->customerFirstName;
    }

    /**
     * Set the value of customerFirstName
     *
     * @return  self
     */
    public function setCustomerFirstName($customerFirstName)
    {
        $this->customerFirstName = $customerFirstName;

        return $this;
    }

    /**
     * Get the value of customerAddress
     */
    public function getCustomerAddress()
    {
        return $this->customerAddress;
    }

    /**
     * Set the value of customerAddress
     *
     * @return  self
     */
    public function setCustomerAddress($customerAddress)
    {
        $this->customerAddress = $customerAddress;

        return $this;
    }

    /**
     * Get the value of customerTown
     */
    public function getCustomerTown()
    {
        return $this->customerTown;
    }

    /**
     * Set the value of customerTown
     *
     * @return  self
     */
    public function setCustomerTown($customerTown)
    {
        $this->customerTown = $customerTown;

        return $this;
    }

    /**
     * Get the value of date
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set the value of date
     *
     * @return  self
     */
    public function setDate($date)
    {
        $this->date = $date;

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
     * Get the value of totalPrice
     */
    public function getTotalPrice()
    {
        return $this->totalPrice;
    }

    /**
     * Set the value of totalPrice
     *
     * @return  self
     */
    public function setTotalPrice($totalPrice)
    {
        $this->totalPrice = $totalPrice;

        return $this;
    }

    /**
     * Get the value of serviceProvidedId
     */
    public function getServiceProvidedId()
    {
        return $this->serviceProvidedId;
    }

    /**
     * Set the value of serviceProvidedId
     *
     * @return  self
     */
    public function setServiceProvidedId($serviceProvidedId)
    {
        $this->serviceProvidedId = $serviceProvidedId;

        return $this;
    }

    public function __toString(): string
    {
        $vars = get_object_vars($this);
        return json_encode($vars);
    }

    /**
     * Get the value of email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */
    public function setEmail($email)
    {
        $this->email = $email;

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
}
