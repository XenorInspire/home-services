<?php
class SubscriptionType
{
    private $typeId;
    private $typeName;
    private $openDays;
    private $openTime;
    private $closeTime;
    private $serviceTimeAmount;
    private $price;


    public function __construct($typeName, $openDays, $openTime, $closeTime, $serviceTimeAmount, $price)
    {
        $this->typeName = htmlspecialchars(trim($typeName));
        $this->openDays = $openDays;
        $this->openTime = $openTime;
        $this->closeTime = $closeTime;
        $this->serviceTimeAmount = $serviceTimeAmount;
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
     * Set the value of typeId
     *
     * @return  self
     */ 
    public function setTypeId($typeId)
    {
        $this->typeId = $typeId;

        return $this;
    }

    /**
     * Get the value of typeName
     */ 
    public function getTypeName()
    {
        return $this->typeName;
    }

    /**
     * Set the value of typeName
     *
     * @return  self
     */ 
    public function setTypeName($typeName)
    {
        $this->typeName = $typeName;

        return $this;
    }

    /**
     * Get the value of openDays
     */ 
    public function getOpenDays()
    {
        return $this->openDays;
    }

    /**
     * Set the value of openDays
     *
     * @return  self
     */ 
    public function setOpenDays($openDays)
    {
        $this->openDays = $openDays;

        return $this;
    }

    /**
     * Get the value of openTime
     */ 
    public function getOpenTime()
    {
        return $this->openTime;
    }

    /**
     * Set the value of openTime
     *
     * @return  self
     */ 
    public function setOpenTime($openTime)
    {
        $this->openTime = $openTime;

        return $this;
    }

    /**
     * Get the value of closeTime
     */ 
    public function getCloseTime()
    {
        return $this->closeTime;
    }

    /**
     * Set the value of closeTime
     *
     * @return  self
     */ 
    public function setCloseTime($closeTime)
    {
        $this->closeTime = $closeTime;

        return $this;
    }

    /**
     * Get the value of serviceTimeAmount
     */ 
    public function getServiceTimeAmount()
    {
        return $this->serviceTimeAmount;
    }

    /**
     * Set the value of serviceTimeAmount
     *
     * @return  self
     */ 
    public function setServiceTime($serviceTimeAmount)
    {
        $this->serviceTimeAmount = $serviceTimeAmount;

        return $this;
    }

    /**
     * Get the value of price
     */ 
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set the value of price
     *
     * @return  self
     */ 
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    public function __toString(): string
    {
        $vars = get_object_vars($this);
        return json_encode($vars);
    }
}
