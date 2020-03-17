<?php

class ServiceType{
    private $serviceTypeId;
    private $typeName;

    public function __construct($serviceTypeId, $typeName)
    {
        $this->serviceTypeId = $serviceTypeId;
        $this->typeName = $typeName;
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

    public function __toString(): string
    {
        $vars = get_object_vars($this);
        return json_encode($vars);
    }


}