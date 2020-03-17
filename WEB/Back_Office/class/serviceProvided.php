<?php

class ServiceProvided{

    private $serviceProvidedId;
    private $serviceId;
    private $date;
    private $beginHour;
    private $hours;
    private $pricePerHour; 
    private $hoursAssociate;

    public function __construct($serviceProvidedId, $serviceId, $date, $beginHour, $hours, $pricePerHour, $hoursAssociate)
    {
        $this->serviceProvidedId = $serviceProvidedId;
        $this->serviceId = $serviceId;
        $this->date = $date;
        $this->beginHour = $beginHour;
        $this->hours = $hours;
        $this->pricePerHour = $pricePerHour;
        $this->hoursAssociate = $hoursAssociate;
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
     * Get the value of pricePerHour
     */ 
    public function getPricePerHour()
    {
        return $this->pricePerHour;
    }

    /**
     * Set the value of pricePerHour
     *
     * @return  self
     */ 
    public function setPricePerHour($pricePerHour)
    {
        $this->pricePerHour = $pricePerHour;

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
}