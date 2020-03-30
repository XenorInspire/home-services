<?php

class ServiceProvided{

    private $serviceProvidedId;
    private $serviceId;
    private $date;
    private $beginHour;
    private $hours;
    private $additionalPrice; 
    private $hoursAssociate;    
    private $address;
    private $town;

    public function __construct($serviceProvidedId, $serviceId, $date, $beginHour, $hours, $additionalPrice, $hoursAssociate, $address, $town)
    {
        $this->serviceProvidedId = $serviceProvidedId;
        $this->serviceId = $serviceId;
        $this->date = $date;
        $this->beginHour = $beginHour;
        $this->hours = $hours;
        $this->additionalPrice = $additionalPrice;
        $this->hoursAssociate = $hoursAssociate;
        $this->address = $address;
        $this->town = $town;
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
     * Get the value of hours
     */ 
    public function getHours()
    {
        return $this->hours;
    }

    /**
     * Set the value of hours
     *
     * @return  self
     */ 
    public function setHours($hours)
    {
        $this->hours = $hours;

        return $this;
    }

    /**
     * Get the value of additionalPrice
     */ 
    public function getAdditionalPrice()
    {
        return $this->additionalPrice;
    }

    /**
     * Set the value of additionalPrice
     *
     * @return  self
     */ 
    public function setAdditionalPrice($additionalPrice)
    {
        $this->additionalPrice = $additionalPrice;

        return $this;
    }

    public function __toString(): string
    {
        $vars = get_object_vars($this);
        return json_encode($vars);
    }

    /**
     * Get the value of hoursAssociate
     */ 
    public function getHoursAssociate()
    {
        return $this->hoursAssociate;
    }

    /**
     * Set the value of hoursAssociate
     *
     * @return  self
     */ 
    public function setHoursAssociate($hoursAssociate)
    {
        $this->hoursAssociate = $hoursAssociate;

        return $this;
    }

    /**
     * Get the value of beginHour
     */ 
    public function getBeginHour()
    {
        return $this->beginHour;
    }

    /**
     * Set the value of beginHour
     *
     * @return  self
     */ 
    public function setBeginHour($beginHour)
    {
        $this->beginHour = $beginHour;

        return $this;
    }

    /**
     * Get the value of address
     */ 
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set the value of address
     *
     * @return  self
     */ 
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get the value of town
     */ 
    public function getTown()
    {
        return $this->town;
    }

    /**
     * Set the value of town
     *
     * @return  self
     */ 
    public function setTown($town)
    {
        $this->town = $town;

        return $this;
    }
}