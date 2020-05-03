<?php

class AssociateBill
{
    private $associateBillId;
    private $billDate;
    private $paidStatus;
    private $associateId;
    private $associateLastName;
    private $associateFirstName;
    private $associateAddress;
    private $associateTown;
    private $email;
    private $sirenNumber;
    private $companyName;
    private $serviceTitle;
    private $totalPrice;
    private $serviceProvidedId;

    public function __construct($associateBillId, $billDate, $paidStatus, $associateId, $associateLastName, $associateFirstName, $associateAddress, $associateTown, $email, $sirenNumber, $companyName, $serviceTitle, $totalPrice, $serviceProvidedId)
    {
        $this->associateBillId = $associateBillId;
        $this->billDate = $billDate;
        $this->paidStatus = $paidStatus;
        $this->associateId = $associateId;
        $this->associateLastName = $associateLastName;
        $this->associateFirstName = $associateFirstName;
        $this->associateAddress = $associateAddress;
        $this->associateTown = $associateTown;
        $this->email = $email;
        $this->sirenNumber = $sirenNumber;
        $this->companyName = $companyName;
        $this->serviceTitle = $serviceTitle;
        $this->totalPrice = $totalPrice;
        $this->serviceProvidedId = $serviceProvidedId;
    }

    public function __toString(): string
    {
        $vars = get_object_vars($this);
        return json_encode($vars);
    }

    /**
     * Get the value of associateBillId
     */
    public function getAssociateBillId()
    {
        return $this->associateBillId;
    }

    /**
     * Get the value of billDate
     */
    public function getBillDate()
    {
        return $this->billDate;
    }

    /**
     * Get the value of paidStatus
     */
    public function getPaidStatus()
    {
        return $this->paidStatus;
    }

    /**
     * Get the value of associateLastName
     */
    public function getAssociateLastName()
    {
        return $this->associateLastName;
    }

    /**
     * Get the value of associateFirstName
     */
    public function getAssociateFirstName()
    {
        return $this->associateFirstName;
    }

    /**
     * Get the value of email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Get the value of associateTown
     */
    public function getAssociateTown()
    {
        return $this->associateTown;
    }

    /**
     * Get the value of sirenNumber
     */
    public function getSirenNumber()
    {
        return $this->sirenNumber;
    }

    /**
     * Get the value of companyName
     */
    public function getCompanyName()
    {
        return $this->companyName;
    }

    /**
     * Get the value of serviceTitle
     */
    public function getServiceTitle()
    {
        return $this->serviceTitle;
    }

    /**
     * Get the value of totalPrice
     */
    public function getTotalPrice()
    {
        return $this->totalPrice;
    }

    /**
     * Get the value of serviceProvidedId
     */
    public function getServiceProvidedId()
    {
        return $this->serviceProvidedId;
    }

    /**
     * Get the value of associateId
     */
    public function getAssociateId()
    {
        return $this->associateId;
    }

    /**
     * Get the value of associateAddress
     */
    public function getAssociateAddress()
    {
        return $this->associateAddress;
    }
}
