<?php

class Reservation
{
    private $reservationId;
    private $reservationDate;
    private $customerId;
    private $serviceProvidedId;
    private $status;

    public function __construct($reservationId, $reservationDate, $customerId, $serviceProvidedId, $status)
    {
        $this->reservationId = $reservationId;
        $this->reservationDate = $reservationDate;
        $this->customerId = $customerId;
        $this->serviceProvidedId = $serviceProvidedId;
        $this->status = $status;
    }

    /**
     * Get the value of reservationId
     */ 
    public function getReservationId()
    {
        return $this->reservationId;
    }

    /**
     * Set the value of reservationId
     *
     * @return  self
     */ 
    public function setReservationId($reservationId)
    {
        $this->reservationId = $reservationId;

        return $this;
    }

    /**
     * Get the value of reservationDate
     */ 
    public function getReservationDate()
    {
        return $this->reservationDate;
    }

    /**
     * Set the value of reservationDate
     *
     * @return  self
     */ 
    public function setReservationDate($reservationDate)
    {
        $this->reservationDate = $reservationDate;

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

    /**
     * Get the value of status
     */ 
    public function getStatus()
    {
        return $this->status;
    }
    
    /**
     * Set the value of status
     *
     * @return  self
     */ 
    public function setStatus($status)
    {
        $this->status = $status;
        
        return $this;
    }

    public function __toString(): string
    {
        $vars = get_object_vars($this);
        return json_encode($vars);
    }
}
