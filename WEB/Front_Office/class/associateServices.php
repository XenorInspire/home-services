<?php

class AssociateServices{
    private $serviceId;
    private $associateId;

    public function __construct($serviceId, $associateId)
    {
        $this->serviceId = $serviceId;
        $this->associateId = $associateId;
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
     * Get the value of associateId
     */ 
    public function getAssociateId()
    {
        return $this->associateId;
    }

    /**
     * Set the value of associateId
     *
     * @return  self
     */ 
    public function setAssociateId($associateId)
    {
        $this->associateId = $associateId;

        return $this;
    }

    public function __toString(): string
    {
        $vars = get_object_vars($this);
        return json_encode($vars);
    }
}