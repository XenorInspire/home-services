<?php

class SubscriptionType
{

    private $typeId;
    private $typeName;
    private $days;
    private $beginTime;
    private $endTime;
    private $serviceTime;
    private $price;

    public function __construct($id, $name, $days, $btime, $etime, $stime, $price)
    {

        $this->typeId = $id;
        $this->typeName = $name;
        $this->days = $days;
        $this->beginTime = $btime;
        $this->endTime = $etime;
        $this->serviceTime = $stime;
        $this->price = $price;

    }

    /**
     * Get the value of typeId
     */ 
    public function getTypeId()
    {
        return $this->typeId;
    }

    /**
     * Get the value of typeName
     */ 
    public function getTypeName()
    {
        return $this->typeName;
    }

    /**
     * Get the value of days
     */ 
    public function getDays()
    {
        return $this->days;
    }

    /**
     * Get the value of beginTime
     */ 
    public function getBeginTime()
    {
        return $this->beginTime;
    }

    /**
     * Get the value of endTime
     */ 
    public function getEndTime()
    {
        return $this->endTime;
    }

    /**
     * Get the value of serviceTime
     */ 
    public function getServiceTime()
    {
        return $this->serviceTime;
    }

    /**
     * Get the value of price
     */ 
    public function getPrice()
    {
        return $this->price;
    }

    public function __toString(): string
    {
        $vars = get_object_vars($this);
        return json_encode($vars);
    }

}
