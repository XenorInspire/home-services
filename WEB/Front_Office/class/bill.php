<?php
require_once('class/invoicing.php');

class Bill extends Invoicing
{
    private $billId;
    private $paidStatus;

    public function __construct($billId, $paidStatus, $customerLastName, $customerFistName, $customerAddress, $customerTown, $email, $date, $serviceTitle, $totalPrice, $serviceProvidedId)
    {
        $this->billId = $billId;
        $this->paidStatus = $paidStatus;
        parent::__construct($customerLastName, $customerFistName, $customerAddress, $customerTown, $email, $date, $serviceTitle, $totalPrice, $serviceProvidedId);
    }

    /**
     * Get the value of billId
     */
    public function getBillId()
    {
        return $this->billId;
    }

    /**
     * Set the value of billId
     *
     * @return  self
     */
    public function setBillId($billId)
    {
        $this->billId = $billId;

        return $this;
    }

    /**
     * Get the value of paidStatus
     */
    public function getPaidStatus()
    {
        return $this->paidStatus;
    }

    /**
     * Set the value of paidStatus
     *
     * @return  self
     */
    public function setPaidStatus($paidStatus)
    {
        $this->paidStatus = $paidStatus;

        return $this;
    }

    public function __toString(): string
    {
        $vars = get_object_vars($this);
        $vars1 = json_encode($vars);
        $vars2 = parent::__toString($this);
        $vars3 = $vars1 . $vars2;
        return $vars3;
    }
}
